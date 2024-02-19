package templates

import (
	"bytes"
	htmltemplate "html/template"
	"io"

	"github.com/MrkMrk00/band-manager/pkg/env"
)

const templateDir = "templates"

var templateFuncs = htmltemplate.FuncMap{
	"IsDev": env.IsDev,
}

func WriteTemplate(w io.Writer, templateName string, data interface{}) error {
	template := htmltemplate.New(templateName).Funcs(templateFuncs)
	template.ParseFiles(templateDir + "/" + templateName)

	return template.Execute(w, data)
}

func RenderTemplate(templateName string, data interface{}) (string, error) {
	var buf bytes.Buffer
	err := WriteTemplate(&buf, templateName, data)

	return buf.String(), err
}
