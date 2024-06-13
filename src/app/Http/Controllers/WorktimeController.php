<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\Work_time;
use App\Models\Break_time;
use Illuminate\Support\Facades\Log;

class WorktimeController extends Controller
{
    public function todayWorkStart()
    {
        $user = Auth::user();

        $workStart = Work_time::where('user_id', $user->id)
            ->whereDate('date', Carbon::today())
            ->first();

        $workEnd = Work_time::where('user_id', $user->id)
            ->whereDate('date', Carbon::today())
            ->whereNotNull('end_time')
            ->first();

        $breakStart = Break_time::where('work_time_id', $workStart->id ?? null)
            ->orderBy('break_start_time', 'desc')
            ->pluck('break_start_time')
            ->first();

        $breakEnd = Break_time::where('work_time_id', $workStart->id ?? null)
            ->whereNotNull('break_start_time')
            ->orderBy('break_start_time', 'desc')
            ->pluck('break_end_time')
            ->first();

        return view('stamp', compact('workStart', 'workEnd', 'breakStart', 'breakEnd'));
    }

    public function startWork(Request $request)
    {
        $user = Auth::user();

        // 今日の出勤状態を確認
        $workStart = Work_time::where('user_id', $user->id)
            ->whereDate('date', Carbon::today())
            ->exists();

        if ($workStart) {
            return redirect()->route('starttime');
        }

        // 新しい出勤打刻を作成
        Work_time::create([
            'user_id' => $user->id,
            'date' => Carbon::today(),
            'start_time' => Carbon::now(),
        ]);

        return redirect()->route('todayWorkStart');
    }

    public function endWork(Request $request)
    {
        $user = Auth::user();

        $todayWorkRecord = Work_time::where('user_id', $user->id)
            ->whereDate('date', Carbon::today())
            ->first();

        if (!$todayWorkRecord || $todayWorkRecord->end_time) {
            Log::info('退勤処理スキップ: 出勤記録がないか、既に退勤処理済み', [
                'user_id' => $user->id,
                'todayWorkRecord' => $todayWorkRecord,
            ]);
            return redirect()->route('endtime');
        }

        // 既存の出勤打刻を更新
        $todayWorkRecord->update([
            'end_time' => Carbon::now(),
        ]);

        Log::info('退勤時間を登録', [
            'user_id' => $user->id,
            'end_time' => Carbon::now(),
        ]);

        return redirect()->route('todayWorkStart');
    }
}
