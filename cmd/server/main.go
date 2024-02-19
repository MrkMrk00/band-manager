package main

import (
	"fmt"
	"log"
	"net/http"
	"os"
	"strconv"

	"github.com/MrkMrk00/band-manager/pkg/routing"
)

const defaultPort = 8080

type LoggingHandler struct {
	wrapping http.Handler
}

func (h LoggingHandler) ServeHTTP(w http.ResponseWriter, r *http.Request) {
	log.Printf("%s %s", r.Method, r.URL)

	h.wrapping.ServeHTTP(w, r)
}

func runServer(server http.Handler) error {
	serverPort := defaultPort
	if port := os.Getenv("SERVER_PORT"); port != "" {
		var err error
		serverPort, err = strconv.Atoi(port)

		if err != nil {
			panic(err)
		}
	}

	log.Printf("Server is running on port %d", serverPort)
	return http.ListenAndServe(
		fmt.Sprintf(":%d", serverPort),
		LoggingHandler{wrapping: server},
	)
}

func main() {
	mux := http.NewServeMux()

	for path, handler := range *routing.GetRoutes() {
		mux.HandleFunc(path, handler)
	}

	log.Fatalln(runServer(mux))
}
