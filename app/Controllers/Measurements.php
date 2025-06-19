<?php

namespace App\Controllers;

use App\Models\MeasurementModel;
use CodeIgniter\RESTful\ResourceController;

class Measurements extends ResourceController
{
    protected $format = 'json';

    public function index()
    {
        $userId = service('request')->user_id;
        $model = new MeasurementModel();

        $data = $model->where('user_id', $userId)->orderBy('created_at', 'desc')->findAll();

        return $this->respond($data);
    }

    public function create()
    {
        $userId = service('request')->user_id;
        $data = $this->request->getJSON(true);

        $validationRules = [
            'moment' => 'required|in_list[cafe_da_manha,almoco,lanche_da_tarde,jantar]',

            'before_level' => 'permit_empty|is_natural',
            'after_level' => 'permit_empty|is_natural',
            'bedtime_level' => 'permit_empty|is_natural',

            'before_time' => 'permit_empty|valid_date[Y-m-d H:i:s]',
            'after_time' => 'permit_empty|valid_date[Y-m-d H:i:s]',

            'insulin_regular' => 'permit_empty|is_natural',
            'insulin_nph' => 'permit_empty|is_natural',

            'observation' => 'permit_empty|string',
        ];

        if (!$this->validate($validationRules)) {
            return $this->failValidationErrors($this->validator->getErrors());
        }

        $model = new MeasurementModel();
        $data['user_id'] = $userId;

        $model->insert($data);
        return $this->respondCreated(['message' => 'Medição registrada com sucesso.']);
    }

    public function stats()
    {
        $userId = service('request')->user_id;
        $model = new MeasurementModel();

        $data = $model->select('
            AVG(before_level) as avg_before,
            AVG(after_level) as avg_after,
            AVG(bedtime_level) as avg_bedtime,
            MAX(before_level) as max_before,
            MAX(after_level) as max_after,
            MAX(bedtime_level) as max_bedtime,
            MIN(before_level) as min_before,
            MIN(after_level) as min_after,
            MIN(bedtime_level) as min_bedtime
        ')
            ->where('user_id', $userId)
            ->first();

        return $this->respond($data);
    }
}
