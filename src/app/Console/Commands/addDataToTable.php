<?php

namespace app\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\Work_time;

class addDataToTable extends Command
{
    // コマンドの名前と説明を設定
    protected $signature = 'auto:update-times {date?}';
    protected $description = 'Automatically update end_time to 23:59:59 and start_time to 0:00:00 for users who did not set their own end_time';

    public function __construct()
    {
        parent::__construct();
    }

    // コマンドの処理を実装 
    public function handle()
    {
        // 引数から日付を取得し、なければ今日の日付を使用
        $date = $this->argument('date') ? Carbon::parse($this->argument('date')) : Carbon::today();

        // 指定された日付の出勤時間があるが退勤時間がないユーザーを取得
        $usersWithoutEndTime = Work_time::whereNull('end_time')
            ->whereDate('date', $date)
            ->get();

        foreach ($usersWithoutEndTime as $workTime) {
            // 指定された日付の退勤時間を更新
            $workTime->end_time = $date->copy()->setTime(23, 59, 59);
            $workTime->save();

            // 翌日の出勤時間を新しく作成
            Work_time::create([
                'user_id' => $workTime->user_id,
                'date' => $date->copy()->addDay()->toDateString(),
                'start_time' => $date->copy()->addDay()->setTime(0, 0, 0),
            ]);
        }

        $this->info('User times updated successfully');
    }
}
