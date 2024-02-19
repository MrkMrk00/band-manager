package env

import "os"

func IsDev() bool {
	return os.Getenv("APP_ENV") == "dev"
}

func IsProd() bool {
	return !IsDev()
}
