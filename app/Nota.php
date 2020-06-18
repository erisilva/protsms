<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Nota extends Model
{
    protected $fillable = [
        'conteudo', 'notaable_id', 'notaable_type', 'user_id',
    ];

    protected $dates = ['created_at'];

    public function notaable()
    {
        return $this->morphTo();
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
