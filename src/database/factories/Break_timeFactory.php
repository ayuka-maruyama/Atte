<?php

namespace Database\Factories;

use App\Models\Break_time;
use App\Models\Work_time;
use Illuminate\Database\Eloquent\Factories\Factory;
use Carbon\Carbon;

class Break_timeFactory extends Factory
{
    protected $model = Break_time::class;

    public function definition()
    {
        $workTime = Work_time::inRandomOrder()->first(); // ランダムな Work_time インスタンスを取得

        $workStartTime = Carbon::createFromFormat('H:i:s', $workTime->start_time);
        $workEndTime = Carbon::createFromFormat('H:i:s', $workTime->end_time);

        $breakStartTime = Carbon::createFromTimestamp(rand($workStartTime->timestamp, $workEndTime->timestamp - 120 * 60));
        $breakStartTimeString = $breakStartTime->format('H:i:s');

        $breakEndTime = (clone $breakStartTime)->addMinutes(rand(1, 120));
        $breakEndTimeString = $breakEndTime->format('H:i:s');

        $createdAt = Carbon::createFromFormat('Y-m-d H:i:s', $workTime->date . ' ' . $breakStartTimeString);
        $updatedAt = Carbon::createFromFormat('Y-m-d H:i:s', $workTime->date . ' ' . $breakEndTimeString);

        return [
            'work_time_id' => $workTime->id,
            'break_start_time' => $breakStartTimeString,
            'break_end_time' => $breakEndTimeString,
            'created_at' => $createdAt,
            'updated_at' => $updatedAt,
        ];
    }
}
