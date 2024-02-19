package routing

import (
	"html/template"
	"net/http"
)

func index(w http.ResponseWriter, r *http.Request) {
	data := map[string]interface{}{
		"Header": "Band Manager",
	}

	template.Must(template.ParseFiles("templ/base.go.html")).Execute(w, data)
}
