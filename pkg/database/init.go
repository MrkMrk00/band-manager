package database

import (
	_ "github.com/go-sql-driver/mysql"
	"github.com/jmoiron/sqlx"
)

var db *sqlx.DB

func GetDB() *sqlx.DB {
	if db == nil {
		var err error

		db, err = sqlx.Connect("mysql", "root:strongpassword@tcp(localhost:3306)/band_manager")
		if err != nil {
			panic(err)
		}
	}

	return db
}
