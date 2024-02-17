<?php

namespace App\Services;

use App\Interfaces\ISaveInterface;
use Illuminate\Support\Facades\Storage;

class SaveToFile implements ISaveInterface
{
    public function saveData(string $data, string $fileName, bool $append = false): void
    {
        $append
            ? Storage::disk('public')->append($fileName, $data)
            : Storage::disk('public')->put($fileName, $data);
    }
}
