<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    protected $fillable = ['name'];

    public static $rules = [
        'name' => 'required|max:255|unique:rooms',
    ];
    public static $messages = [
        'name.required' => 'Nome é obrigatório',
        'name.max' => 'Nome deve possuir no máximo 255 caracteres',
        'name.unique' => 'Já existe uma sala com este nome',
    ];
}
