<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Work_time;
use App\Models\Break_time;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    public function attendance(Request $request)
    {
        $date = $request->input('date', Carbon::today()->format("Y-m-d"));
        $dateCarbon = Carbon::createFromFormat('Y-m-d', $date);

        $previousDate = $dateCarbon->copy()->subDay()->format('Y-m-d');
        $nextDate = $dateCarbon->copy()->addDay()->format('Y-m-d');

        $workRecords = Work_time::where('date', $date)
            ->with('user')
            ->paginate(5);

        $workId = $workRecords->pluck('id');

        $breakRecords = Break_time::whereIn('work_time_id', $workId)
            ->with('work_time')
            ->get();

        $breakTimesByWorkId = [];

        foreach ($breakRecords as $breakRecord) {
            $workTimeId = $breakRecord->work_time_id;

            if (!isset($breakTimesByWorkId[$workTimeId])) {
                $breakTimesByWorkId[$workTimeId] = 0;
            }

            $breakStartTime = strtotime($breakRecord->break_start_time);
            if ($breakRecord->break_end_time) {
                $breakEndTime = strtotime($breakRecord->break_end_time);
                $breakSecond = $breakEndTime - $breakStartTime;
                $breakTimesByWorkId[$workTimeId] += $breakSecond;
            } else {
                $breakTimesByWorkId[$workTimeId] = '休憩中';
            }
        }

        $pureWorkTimes = [];

        foreach ($workRecords as $workRecord) {
            $workStartTime = strtotime($workRecord->start_time);

            if ($workRecord->end_time) {
                $workEndTime = strtotime($workRecord->end_time);
                $workDuration = $workEndTime - $workStartTime;

                $breakDuration = isset($breakTimesByWorkId[$workRecord->id]) && is_numeric($breakTimesByWorkId[$workRecord->id]) ? $breakTimesByWorkId[$workRecord->id] : 0;

                $actualWorkTimeInSeconds = $workDuration - $breakDuration;

                $pureWorkTimes[$workRecord->id] = gmdate("H:i:s", $actualWorkTimeInSeconds);
            } else {
                $pureWorkTimes[$workRecord->id] = '勤務中';
            }
        }

        foreach ($breakTimesByWorkId as $workTimeId => $breakTimeInSeconds) {
            if (is_numeric($breakTimeInSeconds)) {
                $breakTimesByWorkId[$workTimeId] = gmdate("H:i:s", $breakTimeInSeconds);
            }
        }

        return view('date', compact('date', 'previousDate', 'nextDate', 'workRecords', 'breakTimesByWorkId', 'pureWorkTimes'));
    }
}
