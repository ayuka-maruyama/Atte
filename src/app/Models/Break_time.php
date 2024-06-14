<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Break_time extends Model
{
    use HasFactory;

    protected $table = 'break_times';
    protected $fillable = ['work_time_id', 'break_start_time', 'break_end_time'];
    protected $dates = ['created_at', 'updated_at'];

    /**
     * User関連付け
     * 1対多
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
