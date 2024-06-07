<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Work_time;
use Carbon\Carbon;

class addDataToTable extends Command
{
    // コマンドの名前と説明を設定
    protected $signature = 'auto:update-times';
    protected $description = 'Automatically update end_time to 23:59:59 and start_time to 0:00:00 for users who did not set their own end_time';

    public function __construct()
    {
        parent::__construct();
    }

    // コマンドの処理を実装 
    public function handle()
    {
        // 今日の出勤時間があるが退勤時間がないユーザーを取得
        $usersWithoutEndTime = Work_time::whereNull('end_time')
            ->whereDate('date', Carbon::today())
            ->get();

        if ($usersWithoutEndTime->isEmpty()) {
            $this->info('No users found without end_time');
            return;
        }

        foreach ($usersWithoutEndTime as $workTime) {
            // 今日の退勤時間を更新
            $workTime->end_time = Carbon::today()->setTime(23, 59, 59);
            $workTime->save();

            // 翌日の出勤時間を新しく作成
            Work_time::create([
                'user_id' => $workTime->user_id,
                'date' => Carbon::tomorrow(),
                'start_time' => Carbon::tomorrow()->setTime(0, 0, 0),
            ]);
        }

        $this->info('User times updated successfully');
    }
}
