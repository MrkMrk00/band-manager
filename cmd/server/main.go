package main

import (
	"fmt"

	"github.com/MrkMrk00/band-manager/pkg/database"
)

func main() {
	fmt.Println("Hello, World!")

	db := database.GetDB()

	fmt.Println(db.MustExec("DROP TABLE \"TVOJE Máma\"").LastInsertId())

}
