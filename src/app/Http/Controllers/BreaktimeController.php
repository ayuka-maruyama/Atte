<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\Work_time;
use App\Models\Break_time;
use Illuminate\Support\Facades\Log;

class BreaktimeController extends Controller
{
    // 勤務情報の有無の確認および変数の定義
    public function todayWorkRecord()
    {
        $user = Auth::user();

        // ユーザーのIDをログに記録
        Log::info('User ID: ' . $user->id);

        $todayWorkRecord = Work_time::where('user_id', $user->id)
            ->whereDate('date', Carbon::today())
            ->first();

        // 今日の出勤記録をログに記録
        Log::info('Today Work Record: ' . ($todayWorkRecord ? 'Found' : 'Not Found'));

        $todayWorkStart = $todayWorkRecord ? $todayWorkRecord->start_time : null;
        $todayWorkEnd = $todayWorkRecord ? $todayWorkRecord->end_time : null;

        // 休憩時間のレコードを取得してログに記録
        $breakRecord = Break_time::where('work_time_id', $todayWorkRecord->id ?? null)
            ->orderBy('break_start_time', 'desc')
            ->first();
        Log::info('Break Record: ' . ($breakRecord ? 'Found' : 'Not Found'));

        $break_start_time = $breakRecord ? $breakRecord->break_start_time : null;
        $break_end_time = $breakRecord ? $breakRecord->break_end_time : null;

        // 必要な変数をビューに渡す
        return view('stamp', [
            'todayWorkStart' => $todayWorkStart,
            'todayWorkEnd' => $todayWorkEnd,
            'break_start_time' => $break_start_time,
            'break_end_time' => $break_end_time,
        ]);
    }

    // 休憩ボタンを押したときの動作
    public function breakStart(Request $request)
    {
        $user = Auth::user();

        $todayWorkRecord = Work_time::where('user_id', $user->id)
            ->whereDate('date', Carbon::today())
            ->first();

        if (!$todayWorkRecord || $todayWorkRecord->end_time) {
            return redirect()->route('endtime');
        }

        // 新しい休憩レコードを作成
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

        if (!$todayWorkRecord || $todayWorkRecord->end_time) {
            Log::info('退勤処理スキップ: 出勤記録がないか、既に退勤処理済み', [
                'work_time_id' => $todayWorkRecord->id ?? null,
                'todayWorkRecord' => $todayWorkRecord,
            ]);
            return redirect()->route('breakEnd');
        }

        // 複数の休憩レコードを取得
        $breakTimeRecords = Break_time::where('work_time_id', $todayWorkRecord->id)
            ->whereNull('break_end_time')
            ->get();

        if ($breakTimeRecords->isEmpty()) {
            return back();
        }

        // 最新の休憩を終了
        $latestBreakTimeRecord = $breakTimeRecords->first();
        $latestBreakTimeRecord->update([
            'break_end_time' => Carbon::now(),
        ]);

        Log::info('休憩時間を登録', [
            'break_time_id' => $latestBreakTimeRecord->id,
            'end_time' => Carbon::now(),
        ]);

        return back();
    }
}
