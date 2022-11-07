<?php

namespace app\controllers;

use app\interfaces\IRender;

abstract class Controller
{
    private string $action;
    private string $defaultAction = 'index';
    private string $layout = 'main';
    private bool $useLayout = true;
    private IRender $render;


    public function __construct(IRender $render)
    {
        $this->render = $render;
    }


    public function runAction( string $action): void
    {

        $this->action = $action  === '' ? $this->defaultAction : $action ;
        $method = "action" . ucfirst($this->action);
        if (method_exists($this,$method )){
            $this->$method();
        } else{
            die("class error");
        }
    }

    public function render(string $template, array $params = []): mixed
    {
        if ($this->useLayout){
            return $this->renderTemplate('layouts/' . $this->layout,[
                'content' => $this->renderTemplate($template, $params),
            ]);
        }else{
            return $this->renderTemplate($template, $params);
        }
    }

    public function renderTemplate(string $template, array $params)
    {
        return $this->render->renderTemplate($template, $params);
    }

}