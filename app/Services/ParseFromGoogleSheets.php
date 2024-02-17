<?php

namespace App\Services;

use Exception;
use App\Interfaces\IParseInterface;
use Revolution\Google\Sheets\Facades\Sheets;

class ParseFromGoogleSheets implements IParseInterface
{
    public function parseData(array $credentials): array
    {
        try {
            return $this->getSheet($credentials['sheetId'], $credentials['sheet']);
        } catch (Exception $exception) {
            return ['error' => json_decode($exception->getMessage())->error->message];
        }
    }

    private function getSheet(string $sheetId, string $sheet): array
    {
        $rows = Sheets::spreadsheet($sheetId)->sheet($sheet)->get();
        $header = $rows->pull(0);
        $values = Sheets::collection(header: $header, rows: $rows);

        return $values->toArray();
    }
}
