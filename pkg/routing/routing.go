package routing

import (
	"net/http"
)

type RouteCollection map[string]http.HandlerFunc

func GetRoutes() *RouteCollection {
	return &RouteCollection{
		"/{$}": index,
	}
}
