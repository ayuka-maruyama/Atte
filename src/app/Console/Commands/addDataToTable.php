<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class addDataToTable extends Command
{
    // コマンドの名前と説明を設定
    protected $signature = 'add:data-to-table';
    protected $description = 'Add data to a specific table at a scheduled time';

    // コマンドの処理を実装 
    public function addEndtime()
    {
        // 対象者の検索
        $use_id = $this->argument('user_id');

        // 更新する時間を指定
        $addEndTime = Carbon::today()->setTime(23, 59, 59);

        // end_timeがNULLのユーザーすべてのend_timeカラムを更新する
        DB::table('work_times')
            ->whereNull('end_time')
            ->update(['end_time' => $addEndTime]);

        $this->info('end time updated successfully for all users without an end_time.');
    }
}
