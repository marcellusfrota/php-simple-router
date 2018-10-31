<?php 
namespace App;

class Route
{
    private $uri;
    private $controller;
    private $view;

    public function __construct($uri, $controller, $view)
    {
        $this->uri        = $uri;
        $this->controller = $controller;
        $this->view       = $view;
    }

    public function getUri()
    {
        return $this->uri;
    }

    public function getController()
    {
        return $this->controller;
    }

    public function getView()
    {
        return $this->view;
    }

    public function setUri($uri)
    {
        $this->uri = $uri;
    }

    public function setController($controller)
    {
        $this->controller = $controller;
    }

    public function setView($view)
    {
        $this->view = $view;
    }
}
