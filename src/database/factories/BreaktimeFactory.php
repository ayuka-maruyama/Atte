<?php

namespace Database\Factories;

use App\Models\Break_time;
use Illuminate\Database\Eloquent\Factories\Factory;
use Carbon\Carbon;

class BreaktimeFactory extends Factory
{
    protected $model = Break_time::class;

    public function definition()
    {
        return [
            // 
        ];
    }

    public function configure()
    {
        return $this->afterMaking(function (Break_time $breakTime) {
            $workStartTime = Carbon::createFromFormat('H:i:s', $breakTime->work_time->start_time);
            $workEndTime = Carbon::createFromFormat('H:i:s', $breakTime->work_time->end_time);

            $breakStartTime = Carbon::createFromTimestamp(rand($workStartTime->timestamp, $workEndTime->timestamp - 120 * 60));
            $breakStartTimeString = $breakStartTime->format('H:i:s');

            $breakEndTime = (clone $breakStartTime)->addMinutes(rand(1, 120));
            $breakEndTimeString = $breakEndTime->format('H:i:s');

            $breakTime->break_start_time = $breakStartTimeString;
            $breakTime->break_end_time = $breakEndTimeString;
            $breakTime->created_at = Carbon::createFromFormat('Y-m-d H:i:s', $breakTime->work_time->date . ' ' . $breakStartTimeString);
            $breakTime->updated_at = Carbon::createFromFormat('Y-m-d H:i:s', $breakTime->work_time->date . ' ' . $breakEndTimeString);
        });
    }
}
