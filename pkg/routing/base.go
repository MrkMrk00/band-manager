package routing

import (
	"net/http"

	"github.com/MrkMrk00/band-manager/pkg/templates"
)

func index(ctx *AppRequestContext) {
	if err := templates.WriteTemplate(ctx.ResponseWriter(), "pages/index", nil); err != nil {
		http.Error(ctx.ResponseWriter(), err.Error(), http.StatusInternalServerError)
	}
}

func login(ctx *AppRequestContext) {
	if err := templates.WriteTemplate(ctx.ResponseWriter(), "pages/login", nil); err != nil {
		http.Error(ctx.ResponseWriter(), err.Error(), http.StatusInternalServerError)
	}
}
