<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;

class UsersController extends Controller
{
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        return View::make('users.edit');
    }

    public function update(Request $request)
    {
        $input = $request->all();
        $rules = [
            'name' => 'required',
        ];
        $messages = [
            'name.required' => 'Nome é obrigatório',
        ];
        if (!empty($input['password'])) {
            $rules['password'] = 'required|string|min:6|confirmed';
            $messages['password.required'] = 'Senha é obrigatória';
            $messages['password.confirmed'] = 'Senha não conferem';
            $messages['password.min'] = 'Senha deve possuir no mínimo 6 caracteres';
        }

        $validator = Validator::make($input, $rules,$messages);

        if ($validator->fails()) {
            return Redirect::to('/usuarios/editar')
                ->withErrors($validator);
        } else {
            Auth::user()->name = $input['name'];
            Auth::user()->password = bcrypt($input['password']);
            if ( Auth::user()->save()) {
                Session::flash('success', 'Dados editados com sucesso!');
                return Redirect::to('/home');
            }

            Session::flash('fail', 'Ocorreu um erro ao atualizar seus dados!');
            return Redirect::to('/home');


        }

    }
}
