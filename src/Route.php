<?php 
namespace App;

class Route
{
    private $uri;
    private $controller;
    private $view;

    public function __construct(
        String $uri        = null, 
        String $controller = null, 
        String $view       = null
    )
    {
        $this->uri        = $uri;
        $this->controller = $controller;
        $this->view       = $view;
    }

    public function getUri(): String
    {
        return $this->uri;
    }

    public function getController(): String
    {
        return $this->controller;
    }

    public function getView(): String
    {
        return $this->view;
    }

    public function setUri(String $uri): void
    {
        $this->uri = $uri;
    }

    public function setController(String $controller): void
    {
        $this->controller = $controller;
    }

    public function setView(String $view): void
    {
        $this->view = $view;
    }
}
