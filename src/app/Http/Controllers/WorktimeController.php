<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\Work_time;
use App\Models\Break_time;

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

        $workStart = Work_time::where('user_id', $user->id)
            ->whereDate('date', Carbon::today())
            ->exists();

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

        $todayWorkRecord->update([
            'end_time' => Carbon::now(),
        ]);

        return redirect()->route('todayWorkStart');
    }
}
