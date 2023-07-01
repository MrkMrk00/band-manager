<?php

use Illuminate\Support\Facades\Blade;

Blade::directive('icon', function (string $expr) {
    preg_match("/'([\w\-]+)'(.*)/", $expr, $matches);
    $matches = array_filter($matches);
    $name = $matches[1];
    $svg = file_get_contents(base_path('resources/icons/solid/'.$name.'.svg'));
    if (count($matches) <= 2) {
        return $svg;
    }

    preg_match("/.*\[ *(['\w\-=> ,]+) *\].*/", $matches[2], $attrs);
    if (count($attrs) < 2) {
        return $svg;
    }

    $attrs = explode(',', $attrs[1]);
    $attrMapping = [];
    foreach ($attrs as $pair) {
        list($key, $val) = explode('=>', $pair);
        $attrMapping[preg_replace("/( )|(')/", '', $key)] = preg_replace("/( )|(')/", '', $val);
    }

    $doc = new DOMDocument();
    $doc->loadXML($svg);

    /** @var DOMElement $svg */
    $svg = $doc->getElementsByTagName('svg')->item(0);
    foreach ($attrMapping as $name => $value) {
        $svg->setAttribute($name, $value);
    }

    return (string)$doc->saveHTML();
});
