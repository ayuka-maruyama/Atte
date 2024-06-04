<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\Work_time;

class WorktimeController extends Controller
{
    public function store(Request $request)
    {
        // 認証情報の確認
        $user = Auth::user();

        // DBへの打刻は1日1回まで
        $oldTimestamp = Work_time::where('user_id', $user->id)->latest()->first();
        if ($oldTimestamp) {
            $oldStartTime = new Carbon($oldTimestamp->start_time);
            $oldDate = $oldStartTime->startOfDay();
        } else {
            $oldDate = null; // 初期化
        }

        $newDate = Carbon::today()->startOfDay();

        // DBの日付と今回の打刻時間の日付を比較する
        // 同日付の出勤打刻で、かつ直前のend_time（退勤打刻）がされていない場合はエラーを出す
        if ($oldDate && ($oldDate == $newDate) && empty($oldTimestamp->end_time)) {
            return redirect()->back()->with('flash_message', 'すでに出勤打刻がされています');
        }

        // 新しい出勤打刻を作成
        Work_time::create([
            'user_id' => $user->id,
            'date' => $newDate,
            'start_time' => Carbon::now(),
        ]);

        return redirect()->back()->with('flash_message', '勤務開始しました');
    }
}
