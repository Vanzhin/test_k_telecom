<?php

namespace app\interfaces;

interface IRender
{
    public function renderTemplate(string $template, array $params = []);
}