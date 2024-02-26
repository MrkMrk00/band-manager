package templates

import (
	"bytes"
	"fmt"
	htmltemplate "html/template"
	"io"

	"github.com/MrkMrk00/band-manager/pkg/env"
)

const templateDir = "templates"

var templateFuncs = htmltemplate.FuncMap{
	"IsDev": env.IsDev,
}

func WriteTemplate(w io.Writer, templateName string, data interface{}) error {
	t, err := htmltemplate.New("base.go.html").
		Funcs(templateFuncs).
		ParseGlob(fmt.Sprintf("%s/*.go.html", templateDir))

	if err != nil {
		return err
	}

	t, err = t.ParseFiles(fmt.Sprintf("%s/%s.go.html", templateDir, templateName))
	if err != nil {
		return err
	}

	return t.Execute(w, data)
}

func RenderTemplate(templateName string, data interface{}) (string, error) {
	var buf bytes.Buffer
	err := WriteTemplate(&buf, templateName, data)

	return buf.String(), err
}
