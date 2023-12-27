package main

import (
	"fmt"
	"net/http"

	"github.com/go-chi/chi/v5"
	"github.com/go-chi/chi/v5/middleware"
)

type Application struct {
	Error    Error
	Template Template
}

var a Application

func main() {
	a := Application{
		Error:    Error{},
		Template: Template{},
	}

	a.Template.NewCache()

	r := chi.NewRouter()

	r.Use(middleware.RequestID)
	r.Use(middleware.RealIP)
	r.Use(middleware.Logger)
	r.Use(middleware.Recoverer)

	fileServer := http.FileServer(http.Dir("./static"))

	r.Mount("/static", fileServer)

	r.Get("/", func(w http.ResponseWriter, r *http.Request) {
		a.Template.Render(w, r, http.StatusOK, "index.html", struct{}{})
	})

	fmt.Println("starting server on :3000")
	http.ListenAndServe(":3000", r)
}
