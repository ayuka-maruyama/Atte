<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\Work_time;

class WorktimeController extends Controller
{
    public function todayWorkStart()
    {
        $user = Auth::user();

        $todayWorkStart = Work_time::where('user_id', $user->id)
            ->whereDate('start_time', Carbon::today())
            ->exists();

        return view('stamp', compact('todayWorkStart'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();

        // 今日の出勤状態を確認
        $todayWorkStart = Work_time::where('user_id', $user->id)
            ->whereDate('start_time', Carbon::today())
            ->exists();

        if ($todayWorkStart) {
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
}
