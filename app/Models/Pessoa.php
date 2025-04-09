<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pessoa extends Model {

    use HasFactory;

    protected $table = 'pessoa';
    protected $primaryKey = 'pes_id';
    protected $fillable = [
        'pes_nome',
        'pes_data_nascimento',
        'pes_sexo',
        'pes_mae',
        'pes_pai',
    ];

    public function foto()
    {
        return $this->hasOne(FotoPessoa::class, 'pes_id', 'pes_id');
    }

    public function enderecos()
    {
        return $this->hasMany(PessoaEndereco::class, 'pes_id', 'pes_id');
    }

    public function lotacoes()
    {
        return $this->hasMany(Lotacao::class, 'pes_id', 'pes_id');
    }
}
