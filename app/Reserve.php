<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reserve extends Model
{
    protected $fillable = ['user_id', 'room_id', 'datetime'];

    public static $rules = [
        'user_id' => 'required',
        'room_id' => 'required',
        'datetime' => 'required',
    ];
    public static $messages = [
        'user_id.required' => 'O Usuário é obrigatório',
        'room_id.required' => 'A Sala é obrigatório',
        'datetime.required' => 'A Data é obrigatório',
    ];
}
