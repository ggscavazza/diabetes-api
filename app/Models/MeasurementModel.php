<?php

namespace App\Models;

use CodeIgniter\Model;

class MeasurementModel extends Model
{
    protected $table = 'measurements';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'user_id',
        'moment',
        'before_level',
        'before_time',
        'after_level',
        'after_time',
        'insulin_regular',
        'insulin_nph',
        'bedtime_level',
        'observation',
    ];

    protected $useTimestamps = true;
    protected $returnType = 'array';
}
