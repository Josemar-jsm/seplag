<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ServidorTemporario extends Model
{
    use HasFactory;

    protected $table = 'servidor_temporario';

    protected $fillable = [
        'pes_id',
        'sf_data_admissao',
        'sf_data_demissao',
    ];

    public function pessoa()
    {
        return $this->belongsTo(Pessoa::class);
    }
}