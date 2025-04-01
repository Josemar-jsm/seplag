<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ServidorEfetivo extends Model
{
    use HasFactory;

    protected $table = 'servidor_efetivo';

    protected $fillable = [
        'pes_id',
        'se_matricula',
    ];

    public function pessoa()
    {
        return $this->belongsTo(Pessoa::class);
    }
}