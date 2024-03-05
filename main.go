package main

import (
	"blog/templates"
	"blog/templates/errors"
	"blog/templates/posts"
	"log"

	"github.com/a-h/templ"
	"github.com/gofiber/fiber/v3"
	"github.com/gofiber/fiber/v3/middleware/adaptor"
	"github.com/gofiber/fiber/v3/middleware/favicon"
	"github.com/gofiber/fiber/v3/middleware/logger"
	"github.com/gofiber/fiber/v3/middleware/recover"
	"github.com/gofiber/fiber/v3/middleware/requestid"
	gonanoid "github.com/matoous/go-nanoid/v2"
)

func main() {
	app := fiber.New(fiber.Config{
		// DisableStartupMessage: true,
	})

	app.Use(recover.New())
	app.Use(favicon.New())
	app.Use(logger.New())
	app.Use(requestid.New())

	app.Static("/static", "./static")

	app.Get("/", func(c fiber.Ctx) error {
		id, _ := gonanoid.New()

		return Render(c, templates.Index(id))
	})

	app.Get("/posts/:name", func(c fiber.Ctx) error {
		postName := c.Params("name")

		switch postName {
		case "never-forget-backups":
			return Render(c, posts.NeverForgetBackups())
		case "retrieve-submodules-with-git":
			return Render(c, posts.RetrieveSubmodulesWithGit())
		case "setup-lets-encrypt-with-nginx":
			return Render(c, posts.SetupLetsEncryptWithNginx())
		case "deploying-an-application-using-dokku-with-https-and-redirects":
			return Render(c, posts.DeployingAnApplicationUsingDokkuWithHttpsAndRedirects())
		case "what-did-you-undesign":
			return Render(c, posts.WhatDidYouUndesign())
		case "how-to-install-amqp-on-macos":
			return Render(c, posts.HowToInstallAmqpOnMacOs())
		case "implement-rigorously-the-five-step-process":
			return Render(c, posts.ImplementRigorouslyTheFiveStepProcess())
		case "starship-mission-to-mars":
			return Render(c, posts.StarshipMissionToMars())
		default:
			return Render(c, errors.NotFound())
		}
	})

	log.Fatal(app.Listen(":3000"))
}

func Render(c fiber.Ctx, component templ.Component, options ...func(*templ.ComponentHandler)) error {
	componentHandler := templ.Handler(component)

	for _, o := range options {
		o(componentHandler)
	}

	return adaptor.HTTPHandler(componentHandler)(c)
}
