<?php

namespace app\service;

class RegexpService
{
    private string $expression = "/^";

    private array $expressions = [
        'X' => "([A-Z|0-9])",
        'A' => "([A-Z])",
        'N' => "([0-9])",
        'Z' => "([-|_|@])",
        'a' => "([a-z])",
    ];

    private function getRegexp(string $string): string
    {
        foreach (str_split($string) as $item) {
            if ($this->expressions[$item]) {
                $this->expression .= $this->expressions[$item];

            }
        }
        $this->expression .= "$/m";
        return $this->expression;
    }

    public function match(string $string, string $mask): bool
    {
        $regexp = $this->getRegexp($mask);
        return preg_match($regexp, $string);
    }

}