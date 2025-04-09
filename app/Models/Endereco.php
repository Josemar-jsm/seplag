<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Endereco extends Model {

    use HasFactory;

    protected $table = 'endereco';
    protected $primaryKey = 'end_id';
    protected $fillable = [
        'end_tipo_logradouro',
        'end_logradouro',
        'end_numero',
        'end_bairro',
        'cid_id',
    ];

    public function cidade()
    {
        return $this->belongsTo(Cidade::class, 'cid_id', 'cid_id');
    }

    public function unidades()
    {
        return $this->belongsToMany(Unidade::class, 'unidade_endereco', 'end_id', 'unid_id');
    }
}
