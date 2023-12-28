package main

import (
	"blog/templates/templs"
	"blog/templates/templs/errors"
	"blog/templates/templs/posts"
	"fmt"
	"net/http"
	"os"
	"path/filepath"
	"strings"

	"github.com/go-chi/chi/v5"
	"github.com/go-chi/chi/v5/middleware"
	gonanoid "github.com/matoous/go-nanoid/v2"
)

func main() {
	r := chi.NewRouter()

	r.Use(middleware.RequestID)
	r.Use(middleware.RealIP)
	r.Use(middleware.Logger)
	r.Use(middleware.Recoverer)

	fileServer(r)

	r.Get("/", func(w http.ResponseWriter, r *http.Request) {
		id, _ := gonanoid.New()

		templs.Index(id).Render(r.Context(), w)
	})

	r.Get("/posts/{name}", func(w http.ResponseWriter, r *http.Request) {
		postName := chi.URLParam(r, "name")

		switch postName {
		case "never-forget-backups":
			posts.NeverForgetBackups().Render(r.Context(), w)
		case "retrieve-submodules-with-git":
			posts.RetrieveSubmodulesWithGit().Render(r.Context(), w)
		case "setup-lets-encrypt-with-nginx":
			posts.SetupLetsEncryptWithNginx().Render(r.Context(), w)
		case "deploying-an-application-using-dokku-with-https-and-redirects":
			posts.DeployingAnApplicationUsingDokkuWithHttpsAndRedirects().Render(r.Context(), w)
		case "what-did-you-undesign":
			posts.WhatDidYouUndesign().Render(r.Context(), w)
		case "how-to-install-amqp-on-macos":
			posts.HowToInstallAmqpOnMacOs().Render(r.Context(), w)
		case "implement-rigorously-the-five-step-process":
			posts.ImplementRigorouslyTheFiveStepProcess().Render(r.Context(), w)
		default:
			errors.NotFound().Render(r.Context(), w)
		}
	})

	fmt.Println("starting server on :3000")
	http.ListenAndServe(":3000", r)
}

func fileServer(r chi.Router) {
	path := "/static"
	workDir, _ := os.Getwd()
	root := http.Dir(filepath.Join(workDir, "static"))

	if strings.ContainsAny(path, "{}*") {
		panic("static files do not permit any URL parameters.")
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
