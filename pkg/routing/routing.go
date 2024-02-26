package routing

import (
	"context"
	"net/http"
	"time"

	"github.com/MrkMrk00/band-manager/pkg/templates"
)

type RouteCollection map[string]http.HandlerFunc

type handleFuncWithContext func(ctx *AppRequestContext)

// dej to do jinyho package
type AppRequestContext struct {
	request        *http.Request
	responseWriter http.ResponseWriter

	cancelFunc context.CancelFunc
}

func (h *AppRequestContext) Request() *http.Request {
	return h.request
}

func (h *AppRequestContext) ResponseWriter() http.ResponseWriter {
	return h.responseWriter
}

func (h *AppRequestContext) Deadline() (deadline time.Time, ok bool) {
	return h.request.Context().Deadline()
}

func (h *AppRequestContext) Done() <-chan struct{} {
	return h.request.Context().Done()
}

func (h *AppRequestContext) Err() error {
	return h.request.Context().Err()
}

func (h *AppRequestContext) Value(key interface{}) interface{} {
	return h.request.Context().Value(key)
}

func (h *AppRequestContext) MustRender(templateName string, data interface{}) {
	err := templates.WriteTemplate(h.responseWriter, templateName, data)

	if err != nil {
		http.Error(h.responseWriter, err.Error(), http.StatusInternalServerError)
		h.cancelFunc()
	}
}

func contextMiddleware(next handleFuncWithContext) http.HandlerFunc {
	return func(w http.ResponseWriter, r *http.Request) {
		ctx, cancel := context.WithCancel(r.Context())
		r = r.WithContext(ctx)

		h := &AppRequestContext{
			request:        r,
			responseWriter: w,
			cancelFunc:     cancel,
		}

		next(h)
	}
}

func GetRoutes() *RouteCollection {
	return &RouteCollection{
		"/{$}":   contextMiddleware(index),
		"/login": contextMiddleware(login),
	}
}
