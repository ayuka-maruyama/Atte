<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\Work_time;
use App\Models\Break_time;

class BreaktimeController extends Controller
{
    // 休憩ボタンを押したときの動作
    public function breakStart(Request $request)
    {
        $user = Auth::user();

        $todayWorkRecord = Work_time::where('user_id', $user->id)
            ->whereDate('date', Carbon::today())
            ->first();

        Break_time::create([
            'work_time_id' => $todayWorkRecord->id,
            'break_start_time' => Carbon::now(),
        ]);

        return back();
    }

    public function breakEnd(Request $request)
    {
        $user = Auth::user();

        $todayWorkRecord = Work_time::where('user_id', $user->id)
            ->whereDate('date', now()->toDateString())
            ->first();

        $breakTimeRecords = Break_time::where('work_time_id', $todayWorkRecord->id)
            ->whereNull('break_end_time')
            ->get();

        $latestBreakTimeRecord = $breakTimeRecords->first();
        $latestBreakTimeRecord->update([
            'break_end_time' => Carbon::now(),
        ]);

        return back();
    }
}
