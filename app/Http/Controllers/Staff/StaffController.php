<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Actions\Staff\StaffAction;

class StaffController extends Controller
{
    protected int $rowLength;

    public function __construct(protected StaffAction $staffAction)
    {
        $this->middleware('auth:api', ['except' => ['index']]);
        $this->rowLength = count(config('import.staff-csv'));
    }

    /**
     * Gives the list of staffs
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $staffList = $this->staffAction->index();
        return response()->json(['staff_list' => $staffList]);
    }

    /**
     * Uploading staffs data from a CSV file
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function loadCSV(Request $request)
    {
        if (!$request->hasFile('file')) {
            return response()->json(['error' => 'upload_file_not_found'], 400);
        }
        $file = $request->file('file');
        if (!$file->isValid()) {
            return response()->json(['error' => 'invalid_file_upload'], 400);
        }
        $csvString = $file->get();
        $csvRowList = explode("\n", $csvString);
        foreach ($csvRowList as $item) {
            if (strlen($item) === 0) continue;
            $itemRow = str_getcsv($item, ';', "\n");
            if (!$this->verifyCsvRow($itemRow)) {
                return response()->json(['error' => 'invalid_data_format'], 400);
            }
            $csvList [] = $itemRow;
        }
        if (!$this->verifyCsvHead($csvList[0])) {
            return response()->json(['error' => 'invalid_data_format'], 400);
        }

        for ($i = 1; $i < count($csvList); $i++) {
            $staffList [] = $csvList[$i];
        }
        $loadResult = StaffAction::loadCSV($staffList);
        return response()->json(['not_loaded' => $loadResult]);
    }

    /**
     * @param array $row
     * @return bool
     */
    protected function verifyCsvRow(array $row)
    {
        return gettype($row) === 'array' || count($row) === $this->rowLength;
    }

    /**
     * @param array $head
     * @return bool
     */
    protected function verifyCsvHead(array $head)
    {
        return $head[config('import.staff-csv.family')] === 'family'
            && $head[config('import.staff-csv.name')] === 'name'
            && $head[config('import.staff-csv.patronymic')] === 'patronymic'
            && $head[config('import.staff-csv.email')] === 'email'
            && $head[config('import.staff-csv.login')] === 'login'
            && $head[config('import.staff-csv.pass')] === 'pass';
    }
}