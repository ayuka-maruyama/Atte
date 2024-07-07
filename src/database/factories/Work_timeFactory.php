<?php

namespace Database\Factories;

use App\Models\Work_time;
use Illuminate\Database\Eloquent\Factories\Factory;
use Carbon\Carbon;
use App\Models\User;

class Work_timeFactory extends Factory
{
    protected $model = Work_time::class;

    public function definition()
    {
        $user = User::inRandomOrder()->first();

        $start = Carbon::today()->subDays(20);
        $end = Carbon::today()->addDays(20);

        // ユーザーと日付の組み合わせが存在しないランダムな日付を見つける
        do {
            $randomDate = Carbon::createFromTimestamp(rand($start->timestamp, $end->timestamp))->toDateString();
            $existingWorkTime = Work_time::where('user_id', $user->id)->where('date', $randomDate)->first();
        } while ($existingWorkTime);

        $startTime = $this->faker->time();

        $startDateTime = Carbon::createFromFormat('H:i:s', $startTime);
        $latestEndTime = Carbon::createFromFormat('H:i:s', '23:59:59');
        $endDateTime = (clone $startDateTime)->addMinutes(rand(1, 480));

        // 終了時刻が23:59:59を超えないように調整
        if ($endDateTime->greaterThan($latestEndTime)) {
            $endDateTime = $latestEndTime;
        }

        $endTime = $endDateTime->format('H:i:s');

        $createdAt = Carbon::createFromFormat('Y-m-d H:i:s', $randomDate . ' ' . $startTime);
        $updatedAt = Carbon::createFromFormat('Y-m-d H:i:s', $randomDate . ' ' . $endTime);

        return [
            'user_id' => $user->id,
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
            $breakCount = rand(1, 2);
            \App\Models\Break_time::factory()
                ->count($breakCount)
                ->create([
                    'work_time_id' => $workTime->id,
                ]);
        });
    }
}
