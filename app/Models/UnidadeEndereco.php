<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UnidadeEndereco extends Model
{
    use HasFactory;

    protected $table = 'unidade_endereco';

    protected $fillable = [
        'unid_id',
        'end_id',
    ];

    public function unidade()
    {
        return $this->belongsTo(Unidade::class);
    }

    public function endereco()
    {
        return $this->belongsTo(Endereco::class);
    }
}