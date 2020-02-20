<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Setor extends Model
{
    protected $fillable = [
        'codigo', 'descricao',
    ];

    public function users()
    {
        return $this->belongsToMany('App\User');
    }

    public function protocolos()
    {
        return $this->hasMany('App\Protocolo');
    } 
}
