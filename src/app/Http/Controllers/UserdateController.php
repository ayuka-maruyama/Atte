<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Work_time;
use App\Models\Break_time;
use Illuminate\Http\Request;

class UserdateController extends Controller
{
    public function open(Request $request)
    {
        $users = User::paginate(5);

        return view('usersdate', compact('users'));
    }

    public function details(Request $request)
    {
        $userId = $request->input('user_id');
        $user = User::findOrFail($userId); // 選んだ対象者のIDを検索して表示する
        $worktimes = Work_Time::where('user_id', $userId)
            ->orderBy('date', 'desc')
            ->paginate(5);; // ユーザーIDと一致するデータをすべて取得

        if ($worktimes->isEmpty()) {
            // worktimes が空の場合の処理
            return view('worktime', compact('user'));
        }

        $workIds = $worktimes->pluck('id'); // work_timesテーブルのidを取得している
        $breakRecords = Break_Time::whereIn('work_time_id', $workIds)
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

        foreach ($worktimes as $worktime) {
            $workStartTime = strtotime($worktime->start_time);

            if ($worktime->end_time) {
                $workEndTime = strtotime($worktime->end_time);
                $workDuration = $workEndTime - $workStartTime;

                $breakDuration = isset($breakTimesByWorkId[$worktime->id]) && is_numeric($breakTimesByWorkId[$worktime->id]) ? $breakTimesByWorkId[$worktime->id] : 0;

                $actualWorkTimeInSeconds = $workDuration - $breakDuration;

                $pureWorkTimes[$worktime->id] = gmdate("H:i:s", $actualWorkTimeInSeconds);
            } else {
                $pureWorkTimes[$worktime->id] = '勤務中';
            }
        }

        foreach ($breakTimesByWorkId as $workTimeId => $breakTimeInSeconds) {
            if (is_numeric($breakTimeInSeconds)) {
                $breakTimesByWorkId[$workTimeId] = gmdate("H:i:s", $breakTimeInSeconds);
            }
        }

        return view('worktime', compact('user', 'worktimes', 'userId', 'breakTimesByWorkId', 'pureWorkTimes'));
    }
}
