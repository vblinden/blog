package main

import (
	"blog/templates"
	"errors"
	"fmt"
	"io/fs"
	"net/http"
	"path/filepath"
	"text/template"
)

type Template struct {
	cache map[string]*template.Template
}

var functions = template.FuncMap{
	"dict": func(values ...interface{}) (map[string]interface{}, error) {
		if len(values)%2 != 0 {
			return nil, errors.New("invalid dict call")
		}

		dict := make(map[string]interface{}, len(values)/2)

		for i := 0; i < len(values); i += 2 {
			key, ok := values[i].(string)

			if !ok {
				return nil, errors.New("dict keys must be strings")
			}

			dict[key] = values[i+1]
		}

		return dict, nil
	},
}

func (t *Template) warmupCache() {
	t.cache = map[string]*template.Template{}

	pages, err := fs.Glob(templates.Files, "html/pages/*.html")
	if err != nil {
		return
	}

	for _, page := range pages {
		name := filepath.Base(page)

		patterns := []string{
			"html/layout.html",
			"html/partials/*.html",
			page,
		}

		ts, err := template.New(name).Funcs(functions).ParseFS(templates.Files, patterns...)
		if err != nil {
			fmt.Println(err.Error())
			return
		}

		t.cache[name] = ts
	}
}

func (t *Template) Render(w http.ResponseWriter, r *http.Request, status int, page string, data struct{}) {
	ts, ok := t.cache[page]
	if !ok {
		err := fmt.Errorf("the template %s does not exist", page)
		a.Error.Server(w, r, err)
		return
	}

	w.WriteHeader(status)

	err := ts.ExecuteTemplate(w, "layout", data)
	if err != nil {
		a.Error.Server(w, r, err)
	}
}
