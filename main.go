package main

import (
	"blog/templates/templs"
	"fmt"
	"net/http"
	"os"
	"path/filepath"
	"strings"

	"github.com/go-chi/chi/v5"
	"github.com/go-chi/chi/v5/middleware"
)

var a Application

func main() {
	a := Application{
		Error:    Error{},
		Template: Template{},
	}

	a.Boot()

	r := chi.NewRouter()

	r.Use(middleware.RequestID)
	r.Use(middleware.RealIP)
	r.Use(middleware.Logger)
	r.Use(middleware.Recoverer)

	fileServer(r)

	r.Get("/", func(w http.ResponseWriter, r *http.Request) {
		templs.Hello("Vincent").Render(r.Context(), w)
	})

	r.Get("/posts/{name}", func(w http.ResponseWriter, r *http.Request) {
		postName := chi.URLParam(r, "name")
		template := fmt.Sprintf("%s.html", postName)

		a.Template.Render(w, r, http.StatusOK, template, struct{}{})
	})

	fmt.Println("starting server on :3000")
	http.ListenAndServe(":3000", r)
}

func fileServer(r chi.Router) {
	path := "/static"
	workDir, _ := os.Getwd()
	root := http.Dir(filepath.Join(workDir, "static"))

	if strings.ContainsAny(path, "{}*") {
		panic("Static files do not permit any URL parameters.")
	}

	if path != "/" && path[len(path)-1] != '/' {
		r.Get(path, http.RedirectHandler(path+"/", 301).ServeHTTP)
		path += "/"
	}

	path += "*"

	r.Get(path, func(w http.ResponseWriter, r *http.Request) {
		rctx := chi.RouteContext(r.Context())
		pathPrefix := strings.TrimSuffix(rctx.RoutePattern(), "/*")
		fs := http.StripPrefix(pathPrefix, http.FileServer(root))
		fs.ServeHTTP(w, r)
	})
}
