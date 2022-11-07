<?php

namespace app\engine;

class Request
{
    protected  string $requestString;
    protected  ?string $controllerName;
    protected  ?string $actionName;
    protected  ?string $method;
    protected array $params = [];


    public function __construct()
    {
        $this->parseRequest();
    }

    protected function parseRequest(): void
    {
        $this->requestString = $_SERVER['REQUEST_URI'];
        $this->method = $_SERVER['REQUEST_METHOD'];

        $url = explode('/', $this->requestString);

        $this->controllerName = $url[1];
        $this->actionName = $url[2] ?? null;
        $this->params = $_REQUEST;

    }


    public function getRequestString(): string
    {
        return $this->requestString;
    }


    public function getControllerName(): ?string
    {
        return $this->controllerName;
    }


    public function getActionName(): ?string
    {
        return $this->actionName;
    }


    public function getMethod(): ?string
    {
        return $this->method;
    }


    public function getParams(): array
    {
        return $this->params;
    }


}