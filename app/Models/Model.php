<?php

namespace App\Models;

use App\Audit\Traits\RecordsActivity;
use Illuminate\Database\Eloquent\Model as EloquentModel;

class Model extends EloquentModel
{
    use RecordsActivity;

    /**
     * @param $query
     * @return mixed
     */
    public function scopeRecent($query)
    {
        return $query->orderBy('id', 'desc');
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('order', 'desc');
    }

}
