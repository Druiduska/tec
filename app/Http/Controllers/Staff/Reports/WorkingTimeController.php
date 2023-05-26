<?php

namespace App\Http\Controllers\Staff\Reports;

use App\Actions\Staff\Reports\WorkingTimeAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Staff\WorkingTimeRequest;

class WorkingTimeController extends Controller
{
    /**
     * @param WorkingTimeAction $workingTimeAction
     */
    public function __construct(protected WorkingTimeAction $workingTimeAction)
    {
        $this->middleware('auth:api', ['except' => ['byWeek']]);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function byWeek(WorkingTimeRequest $request)
    {
        $workingTimeList = $this->workingTimeAction->byWeek($request->user_id, $request->date, $request->count);
        return response()->json(['success' => true, 'working_time_list' => $workingTimeList]);
    }
}
