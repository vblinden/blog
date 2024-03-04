package main

import (
	"log"

	"github.com/gofiber/fiber/v3"
	"github.com/gofiber/fiber/v3/middleware/favicon"
	"github.com/gofiber/fiber/v3/middleware/logger"
	"github.com/gofiber/fiber/v3/middleware/recover"
	"github.com/gofiber/fiber/v3/middleware/requestid"
	"github.com/gofiber/template/html/v2"
	gonanoid "github.com/matoous/go-nanoid/v2"
)

func main() {
	engine := html.New("./views", ".html")

	app := fiber.New(fiber.Config{
		Views:       engine,
		ViewsLayout: "layout",
		// DisableStartupMessage: true,
	})

	app.Use(recover.New())
	app.Use(favicon.New())
	app.Use(logger.New())
	app.Use(requestid.New())

	app.Static("/static", "./static")

	app.Get("/", func(c fiber.Ctx) error {
		id, _ := gonanoid.New()

		return c.SendString(id)

		// return c.Render("index", fiber.Map{
		// 	"id": id,
		// })
	})

	log.Fatal(app.Listen(":3000"))

	// // OLD:
	//
	// r.Get("/", func(w http.ResponseWriter, r *http.Request) {
	// 	id, _ := gonanoid.New()
	//
	// 	templates.Index(id).Render(r.Context(), w)
	// })
	//
	// r.Get("/posts/{name}", func(w http.ResponseWriter, r *http.Request) {
	// 	postName := chi.URLParam(r, "name")
	//
	// 	switch postName {
	// 	case "never-forget-backups":
	// 		posts.NeverForgetBackups().Render(r.Context(), w)
	// 	case "retrieve-submodules-with-git":
	// 		posts.RetrieveSubmodulesWithGit().Render(r.Context(), w)
	// 	case "setup-lets-encrypt-with-nginx":
	// 		posts.SetupLetsEncryptWithNginx().Render(r.Context(), w)
	// 	case "deploying-an-application-using-dokku-with-https-and-redirects":
	// 		posts.DeployingAnApplicationUsingDokkuWithHttpsAndRedirects().Render(r.Context(), w)
	// 	case "what-did-you-undesign":
	// 		posts.WhatDidYouUndesign().Render(r.Context(), w)
	// 	case "how-to-install-amqp-on-macos":
	// 		posts.HowToInstallAmqpOnMacOs().Render(r.Context(), w)
	// 	case "implement-rigorously-the-five-step-process":
	// 		posts.ImplementRigorouslyTheFiveStepProcess().Render(r.Context(), w)
	// 	case "starship-mission-to-mars":
	// 		posts.StarshipMissionToMars().Render(r.Context(), w)
	// 	default:
	// 		errors.NotFound().Render(r.Context(), w)
	// 	}
	// })
	//
	// fmt.Println("starting server on :3000")
	// http.ListenAndServe(":3000", r)
}
