<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Evaluation extends Model
{
    use HasFactory;
    public function evaluator()
    {
        return $this->belongsTo(User::class, 'evaluator_id'); // Aquí 'evaluator_id' es la clave foránea
    }
    public function evaluated()
    {
        return $this->belongsTo(User::class, 'evaluated_id'); // Aquí 'evaluated_id' es la clave foránea
    }
}
