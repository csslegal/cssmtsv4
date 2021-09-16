<?php


namespace App\MyClass;

use DOMDocument;

class WebSiteUrls
{
    public $url;

    public function __construct($url)

    {

        $this->url = $url;

        $options = array(
            'http' => array(
                'method' => 'GET',
                'header' => "Accept-language: en\r\n" .
                    "Cookie: foo=bar\r\n"
            ),
            "ssl" => array(
                "verify_peer" => false,
                "verify_peer_name" => false,
            ),
        );
        $context = stream_context_create($options);

        $this->document = new DOMDocument('1.0', 'UTF-8');
        $internalErrors = libxml_use_internal_errors(true);
        @$this->document->loadHTML(file_get_contents($this->url, false, $context));
        libxml_use_internal_errors($internalErrors);
    }

    public function fetch()
    {
        $linksArray = array();
        $links = $this->document->getElementsByTagName('a');

        foreach ($links as $link) {
            if (
                $link->getAttribute('href') != ''
                && $link->getAttribute('href') != '/'
                &&  substr($link->getAttribute('href'), 0, 1) != '#'
                &&  substr($link->getAttribute('href'), 0, 6) != 'mailto'
                &&  substr($link->getAttribute('href'), 0, 3) != 'tel'
                &&  substr($link->getAttribute('href'), 0, 2) != '//'
                &&  substr($link->getAttribute('href'), 0, 2) != '..'
            ) {
                if (
                    substr($link->getAttribute('href'), 0, 1) == '/'
                    && substr($link->getAttribute('href'), 1, 1) != '/'
                ) {
                    array_push($linksArray, $this->url . $link->getAttribute('href'));
                } else {
                    array_push($linksArray, $link->getAttribute('href'));
                }
            }
        }
        return $linksArray;
    }
}
