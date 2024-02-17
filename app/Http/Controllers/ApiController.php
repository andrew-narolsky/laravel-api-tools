<?php

namespace App\Http\Controllers;

use App\Http\Requests\GoogleSheetRequest;
use App\Services\ParseFromGoogleSheets;
use App\Services\SaveToFile;

class ApiController extends Controller
{
    private SaveToFile $saveToFile;
    private ParseFromGoogleSheets $parseFromGoogleSheets;

    public function __construct(SaveToFile $saveToFile, ParseFromGoogleSheets $parseFromGoogleSheets)
    {
        $this->saveToFile = $saveToFile;
        $this->parseFromGoogleSheets = $parseFromGoogleSheets;
    }

    public function parse(GoogleSheetRequest $request): array
    {
        $data = $this->parseFromGoogleSheets->parseData($request->safe()->only(['sheetId', 'sheet']));
        if (!isset($data['error'])) {
            $this->saveToFile->saveData(json_encode($data), $request->get('fileName'), true);
        }
        return $data;
    }
}
