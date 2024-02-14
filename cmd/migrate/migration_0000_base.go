package main

import "fmt"

type Migration_0000_base struct {
	BaseMigration
}

func (m *Migration_0000_base) Check() (bool, error) {
	return true, nil
}

func (Migration_0000_base) Up() error {
	return fmt.Errorf("Not implemented")
}
