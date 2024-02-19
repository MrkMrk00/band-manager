package routing

import (
	"log"
	"net/http"

	"github.com/MrkMrk00/band-manager/pkg/templates"
)

func index(w http.ResponseWriter, r *http.Request) {
	data := map[string]interface{}{
		"Header": "Band Manager",
	}

	log.Println(templates.WriteTemplate(w, "base.go.html", data))
}
