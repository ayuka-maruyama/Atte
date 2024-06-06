<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class addDataToTable extends Command
{
    // コマンドの名前と説明を設定
    protected $signature = 'auto:update-times';
    protected $description = 'Automatically update end_time to 23:59:59 and start_time to 0:00:00 for users who did not set their own end_time';

    // コマンドの処理を実装 
    public function handle()
    {
        // 更新する時間を指定
        $endTime = Carbon::today()->setTime(23, 59, 59);
        $startTime = Carbon::tomorrow()->setTime(0, 0, 0);

        // end_timeがNULLのユーザーすべてのend_timeカラムを更新する
        DB::table('work_times')
            ->whereNull('end_time')
            ->update(['end_time' => $endTime, 'start_time' => $startTime]);

        $this->info('End time and start time updated successfully for all users without an end_time.');
    }
}
