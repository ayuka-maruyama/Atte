<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Work_time extends Model
{
    use HasFactory;

    protected $table = 'work_times';
    protected $fillable = ['user_id', 'date', 'start_time', 'end_time'];
    protected $dates = ['created_at', 'updated_at'];

    public function break_times()
    {
        return $this->hasMany(Break_time::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
