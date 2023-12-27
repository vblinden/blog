package main

import (
	"log"
	"net/http"
)

type Error struct {
}

func (e *Error) Server(w http.ResponseWriter, r *http.Request, err error) {
	log.Print(err.Error())
	http.Error(w, http.StatusText(http.StatusInternalServerError), http.StatusInternalServerError)
}

func (e *Error) Client(w http.ResponseWriter, status int) {
	http.Error(w, http.StatusText(status), status)
}

func (e *Error) NotFound(w http.ResponseWriter, r *http.Request, err error) {
	e.Client(w, http.StatusNotFound)
}
