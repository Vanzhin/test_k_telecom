<?php

use app\engine\{Autoload, Render, Request};

include "../engine/Autoload.php";
include '../config/config.php';

spl_autoload_register([new Autoload(), 'loadClass']);


try {
    $request = new Request();

    $controllerName = $request->getControllerName() ?: 'index';

    $actionName = $request->getActionName() ?? '';


    $controllerClass = CONTROLLER_NAMESPACE . ucfirst($controllerName) . 'Controller';

// если класса контроллера нет, перенаправляю на главную
    if (!class_exists($controllerClass)) {
        $controllerClass = CONTROLLER_NAMESPACE . 'IndexController';

        if (!method_exists($controllerClass, $actionName)) {
            $actionName = 'index';
        };

    }
    $controller = new $controllerClass(new Render());
    $controller->runAction($actionName);


} catch (\PDOException $e) {
    var_dump($e->getMessage());
} catch (\Exception $e) {
    var_dump($e->getTrace());
}




