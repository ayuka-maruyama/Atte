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
        $start = Carbon::today()->subDays(7);
        $end = Carbon::today()->addDays(7);
        $randomDate = Carbon::createFromTimestamp(rand($start->timestamp, $end->timestamp))->toDateString();

        $startTime = $this->faker->time();

        $startDateTime = Carbon::createFromFormat('H:i:s', $startTime);
        $endDateTime = (clone $startDateTime)->addMinutes(rand(1, 480)); // 開始時間から1分から480分後（8時間後）までの間で終了時間を設定
        $endTime = $endDateTime->format('H:i:s');

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

    public function withBreaks()
    {
        return $this->afterCreating(function (Work_time $workTime) {
            $breakCount = rand(0, 2);
            \App\Models\Break_time::factory()
                ->count($breakCount)
                ->create([
                    'work_time_id' => $workTime->id,
                    'work_start_time' => $workTime->start_time,
                    'work_end_time' => $workTime->end_time
                ]);
        });
    }
}
