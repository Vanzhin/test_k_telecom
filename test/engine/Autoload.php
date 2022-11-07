<?php

namespace app\engine;
class Autoload
{
    public function loadClass($className): void
    {
        $fileName = str_replace('app', ROOT, $className);
        $fileName = str_replace('\\', DS, $fileName) . '.php';

        if (file_exists($fileName)) {
            include $fileName;
        }
    }
}