<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    protected $fillable = ['name'];

    public static $rules = [
        'name' => 'required',
    ];
    public static $messages = [
        'name.required' => 'Nome é obrigatório',
    ];
}
