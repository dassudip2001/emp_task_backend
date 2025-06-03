<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DailyUpdate extends Model
{
    /** @use HasFactory<\Database\Factories\DailyUpdateFactory> */
    use HasFactory;

    protected $table = 'daily_updates';

    protected $fillable = [
        'date',
        'task_title',
        'summary',
        'hoursSpent'
    ];

    protected $hidden = [
        'userId',
    ];
}
