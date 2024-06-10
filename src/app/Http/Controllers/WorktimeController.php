<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\Work_time;
use Illuminate\Support\Facades\Log;

class WorktimeController extends Controller
{
    public function todayWorkStart()
    {
        $user = Auth::user();

        $todayWorkStart = Work_time::where('user_id', $user->id)
            ->whereDate('date', Carbon::today())
            ->exists();

        $todayWorkEnd = Work_time::where('user_id', $user->id)
            ->whereDate('date', Carbon::today())
            ->whereNotNull('end_time')
            ->exists();
        return view('stamp', compact('todayWorkStart', 'todayWorkEnd'));
    }

    public function startWork(Request $request)
    {
        $user = Auth::user();

        // 今日の出勤状態を確認
        $todayWorkStart = Work_time::where('user_id', $user->id)
            ->whereDate('date', Carbon::today())
            ->exists();

        if ($todayWorkStart) {
            return redirect()->route('starttime')->with('flash_message', 'すでに出勤処理済みです');
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
            return redirect()->route('endtime')->with('flash_message', 'すでに退勤処理済みです');
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
