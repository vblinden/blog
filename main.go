package main

import (
	"blog/templates"
	"blog/templates/errors"
	"blog/templates/posts"
	"fmt"
	"net/http"

	"github.com/a-h/templ"
	"github.com/go-chi/chi/v5"
	"github.com/go-chi/chi/v5/middleware"
	gonanoid "github.com/matoous/go-nanoid"
)

func main() {
	r := chi.NewRouter()
	r.Use(middleware.RequestID)
	r.Use(middleware.RealIP)
	r.Use(middleware.Logger)
	r.Use(middleware.Recoverer)
	r.Use(middleware.RedirectSlashes)

	fs := http.FileServer(http.Dir("static"))
	r.Handle("/static/*", http.StripPrefix("/static/", fs))

	r.Get("/", func(w http.ResponseWriter, r *http.Request) {
		id, _ := gonanoid.Generate("vblinden", 6)

		templ.Handler(templates.Index(id)).ServeHTTP(w, r)
	})

	r.Get("/posts/{name}", func(w http.ResponseWriter, r *http.Request) {
		postName := chi.URLParam(r, "name")

		switch postName {
		case "never-forget-backups":
			templ.Handler(posts.NeverForgetBackups()).ServeHTTP(w, r)
			return
		case "retrieve-submodules-with-git":
			templ.Handler(posts.RetrieveSubmodulesWithGit()).ServeHTTP(w, r)
			return
		case "setup-lets-encrypt-with-nginx":
			templ.Handler(posts.SetupLetsEncryptWithNginx()).ServeHTTP(w, r)
			return
		case "deploying-an-application-using-dokku-with-https-and-redirects":
			templ.Handler(posts.DeployingAnApplicationUsingDokkuWithHttpsAndRedirects()).ServeHTTP(w, r)
			return
		case "what-did-you-undesign":
			templ.Handler(posts.WhatDidYouUndesign()).ServeHTTP(w, r)
			return
		case "how-to-install-amqp-on-macos":
			templ.Handler(posts.HowToInstallAmqpOnMacOs()).ServeHTTP(w, r)
			return
		case "implement-rigorously-the-five-step-process":
			templ.Handler(posts.ImplementRigorouslyTheFiveStepProcess()).ServeHTTP(w, r)
			return
		case "starship-mission-to-mars":
			templ.Handler(posts.StarshipMissionToMars()).ServeHTTP(w, r)
			return
		case "where-are-the-product-people":
			templ.Handler(posts.WhereAreTheProductPeople()).ServeHTTP(w, r)
			return
		default:
			w.WriteHeader(http.StatusNotFound)
			templ.Handler(errors.NotFound()).ServeHTTP(w, r)
			return
		}
	})

	r.NotFound(func(w http.ResponseWriter, r *http.Request) {
		w.WriteHeader(http.StatusNotFound)
		templ.Handler(errors.NotFound()).ServeHTTP(w, r)
	})

	fmt.Println("starting server on :3000")
	http.ListenAndServe(":3000", r)
}
