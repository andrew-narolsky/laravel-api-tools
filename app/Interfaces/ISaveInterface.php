<?php

namespace App\Interfaces;

interface ISaveInterface
{
    public function saveData(string $data, string $fileName, bool $append = false): void;
}
