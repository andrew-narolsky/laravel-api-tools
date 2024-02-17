<?php

namespace App\Interfaces;

interface IParseInterface
{
    public function parseData(array $credentials): array;
}
