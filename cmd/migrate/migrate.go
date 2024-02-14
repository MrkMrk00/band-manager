package main

import (
	"fmt"
	"os"

	"github.com/MrkMrk00/band-manager/pkg/database"
	"github.com/jmoiron/sqlx"
)

type Migration interface {
	Up() error
	Check() (bool, error)
}

type migrationPool []Migration

func (m *migrationPool) Register(migration Migration) {
	*m = append(*m, migration)
}

type MigrationType uint8

const (
	UP    MigrationType = iota
	CLEAN MigrationType = iota
)

func GetMigrationType() (MigrationType, error) {
	if len(os.Args) < 2 {
		return UP, nil
	}

	switch os.Args[1] {
	case "up":
		return UP, nil
	case "clean":
		return CLEAN, nil
	default:
		return CLEAN, fmt.Errorf("Invalid migration type: %s", os.Args[1])
	}
}

func (m *migrationPool) Migrate(migrationType MigrationType) error {
	for _, migration := range *m {
		var err error
		switch migrationType {
		case UP:
			err = migration.Up()
		}
		if err != nil {
			return err
		}
	}

	return nil
}

var MigrationPool migrationPool = migrationPool{}

type BaseMigration struct {
	db *sqlx.DB
}

func initPool() {
	db := database.GetDB()

	based := BaseMigration{db: db}
	MigrationPool.Register(&Migration_0000_base{based})
}

func main() {
	migrationType, err := GetMigrationType()
	if err != nil {
		fmt.Println(err)
		os.Exit(1)
	}

	initPool()
	if err := MigrationPool.Migrate(migrationType); err != nil {
		fmt.Println(err)
		os.Exit(1)
	}

	fmt.Println("Migration successful")
}
