package main

import (
	"context"
	"fmt"
	"log"
	"net/http"

	"connectrpc.com/connect"
	rpcgen "github.com/MrkMrk00/band-manager/internal/rpcgen/rpc/v1"
	"github.com/MrkMrk00/band-manager/internal/rpcgen/rpc/v1/rpcgenconnect"
)

type GreetServer struct{}

func (s *GreetServer) Greet(
	ctx context.Context,
	req *connect.Request[rpcgen.GreetRequest],
) (*connect.Response[rpcgen.GreetResponse], error) {
	log.Println("Request headers: ", req.Header())
	res := connect.NewResponse(&rpcgen.GreetResponse{
		Greeting: fmt.Sprintf("Hello, %s!", req.Msg.Name),
	})
	res.Header().Set("Greet-Version", "v1")
	return res, nil
}

func main() {
	greeter := &GreetServer{}
	mux := http.NewServeMux()
	path, handler := rpcgenconnect.NewGreetServiceHandler(greeter)
	mux.Handle(path, handler)
	http.ListenAndServe(
		"localhost:4000",
		mux,
	)
}
