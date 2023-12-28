package main

type Application struct {
	Error    Error
	Template Template
}

func (a *Application) Boot() {
	a.Template.warmupCache()
}
