<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PessoaEndereco extends Model
{
    use HasFactory;

    protected $table = 'pessoa_endereco';

    protected $fillable = [
        'pes_id',
        'end_id',
    ];

    public function pessoa()
    {
        return $this->belongsTo(Pessoa::class);
    }

    public function endereco()
    {
        return $this->belongsTo(Endereco::class);
    }
}