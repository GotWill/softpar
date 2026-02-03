<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Demand extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'client_id',
        'title',
        'priority',
        'sector',
        'responsible',
        'who_should_test',
        'description',
        'midia',
        'customer_charged',
        'estimated_time',
        'time_spent',
        'status',
        'return',
        'is_deleted'
    ];
}
