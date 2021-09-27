<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Sushi\Sushi;

class Schedule extends Model
{
    use Sushi;
    protected $rows = [
        [
            'label' => 'hourly',
            'description' => 'Every hour of the day',
        ],
        [
            'label' => 'daily',
            'description' => 'Daily at 00:00 hrs.',
        ],
        [
            'label' => 'weekly',
            'description' => 'Weekly on Sunday at 00:00 hrs.',
        ],
        [
            'label' => 'monthly',
            'description' => 'First day of the Month at 00:00 hrs.',
        ],
        [
            'label' => 'yearly',
            'description' => 'First day of the Year at 00:00 hrs.',
        ],
    ];
}
