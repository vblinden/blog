package main

import (
	"blog/templates"
	"blog/templates/errors"
	"blog/templates/posts"
	"net/http"

	"github.com/asdgo/asdgo"
	"github.com/asdgo/asdgo/atemplate"
	"github.com/labstack/echo/v4"
	gonanoid "github.com/matoous/go-nanoid"
)

func main() {
	asd := asdgo.New(&asdgo.Config{
		TemplateNotFound: errors.NotFound(),
	})
	asd.Static("/static", "./static")

	asd.GET("/", func(c echo.Context) error {
		id, _ := gonanoid.Generate("vblinden", 6)

		return atemplate.Render(c, http.StatusOK, templates.Index(id))
	})

	asd.GET("/posts/:name", func(c echo.Context) error {
		postName := c.Param("name")

		switch postName {
		case "never-forget-backups":
			return atemplate.Render(c, http.StatusOK, posts.NeverForgetBackups())
		case "retrieve-submodules-with-git":
			return atemplate.Render(c, http.StatusOK, posts.RetrieveSubmodulesWithGit())
		case "setup-lets-encrypt-with-nginx":
			return atemplate.Render(c, http.StatusOK, posts.SetupLetsEncryptWithNginx())
		case "deploying-an-application-using-dokku-with-https-and-redirects":
			return atemplate.Render(c, http.StatusOK, posts.DeployingAnApplicationUsingDokkuWithHttpsAndRedirects())
		case "what-did-you-undesign":
			return atemplate.Render(c, http.StatusOK, posts.WhatDidYouUndesign())
		case "how-to-install-amqp-on-macos":
			return atemplate.Render(c, http.StatusOK, posts.HowToInstallAmqpOnMacOs())
		case "implement-rigorously-the-five-step-process":
			return atemplate.Render(c, http.StatusOK, posts.ImplementRigorouslyTheFiveStepProcess())
		case "starship-mission-to-mars":
			return atemplate.Render(c, http.StatusOK, posts.StarshipMissionToMars())
		case "where-are-the-product-people":
			return atemplate.Render(c, http.StatusOK, posts.WhereAreTheProductPeople())
		default:
			return atemplate.Render(c, http.StatusNotFound, errors.NotFound())
		}
	})

	asd.Logger.Fatal(asd.Start(":3000"))
}
