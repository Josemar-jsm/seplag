<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UnidadeEndereco extends Model
{
    use HasFactory;

    protected $table = 'unidade_endereco';
    public $incrementing = false;
    protected $primaryKey = null;

    protected $fillable = [
        'unid_id',
        'end_id',
    ];

    public function unidades()
    {
        return $this->belongsTo(Unidade::class,'unid_id','unid_id');
    }

    public function endereco()
    {
        return $this->belongsTo(Endereco::class,'end_id','end_id');
    }
}