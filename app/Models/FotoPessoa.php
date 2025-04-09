<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FotoPessoa extends Model
{
    use HasFactory;

    protected $table = 'foto_pessoa';

    protected $primaryKey = 'fp_id';

    protected $fillable = [
        'fp_data',
        'fp_bucket',
        'fp_hash',
        'pes_id',
    ];

    public function pessoa()
    {
        return $this->belongsTo(Pessoa::class,'pes_id','pes_id');
    }
}