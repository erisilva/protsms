<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProtocoloTipo extends Model
{
    protected $fillable = [
        'descricao',
    ];

    public function protocolos()
    {
        return $this->hasMany('App\Protocolo');
    } 

}
