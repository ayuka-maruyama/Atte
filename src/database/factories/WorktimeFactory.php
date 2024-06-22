<?php

namespace Database\Factories;

use App\Models\Work_time;
use Illuminate\Database\Eloquent\Factories\Factory;
use Carbon\Carbon;

class WorktimeFactory extends Factory
{
    protected $model = Work_time::class;

    public function definition()
    {
        // 今日の前後1週間の日付を生成
        $start = Carbon::today()->subDays(7);
        $end = Carbon::today()->addDays(7);
        $randomDate = Carbon::createFromTimestamp(rand($start->timestamp, $end->timestamp))->toDateString();

        // 開始時間を生成
        $startTime = $this->faker->time();

        // 終了時間を開始時間よりも遅く設定するためのロジック
        $startDateTime = Carbon::createFromFormat('H:i:s', $startTime);
        $endDateTime = (clone $startDateTime)->addMinutes(rand(1, 480)); // 開始時間から1分から480分後（8時間後）までの間で終了時間を設定
        $endTime = $endDateTime->format('H:i:s');

        // created_atとupdated_atを生成
        $createdAt = Carbon::createFromFormat('Y-m-d H:i:s', $randomDate . ' ' . $startTime);
        $updatedAt = Carbon::createFromFormat('Y-m-d H:i:s', $randomDate . ' ' . $endTime);

        return [
            'user_id' => $this->faker->numberBetween(1, 100),
            'date' => $randomDate,
            'start_time' => $startTime,
            'end_time' => $endTime,
            'created_at' => $createdAt,
            'updated_at' => $updatedAt,
        ];
    }
}
