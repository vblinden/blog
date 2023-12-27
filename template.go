package main

import (
	"fmt"
	"net/http"
	"path/filepath"
	"text/template"
)

type Template struct {
	cache map[string]*template.Template
}

func (t *Template) NewCache() {
	t.cache = map[string]*template.Template{}

	pages, err := filepath.Glob("./templates/*.html")
	if err != nil {
		return
	}

	for _, page := range pages {
		name := filepath.Base(page)

		ts, err := template.ParseFiles("./templates/layout.html")
		if err != nil {
			fmt.Printf("%v", err)
			return
		}

		ts, err = ts.ParseGlob("./templates/partials/*.html")
		if err != nil {
			fmt.Printf("%v", err)
			return
		}

		ts, err = ts.ParseFiles(page)
		if err != nil {
			fmt.Printf("%v", err)
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
