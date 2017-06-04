<?php

namespace App\Http\Controllers;

use App\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\Rule;

class RoomsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $rooms = Room::all();
        return View::make('rooms.index', ['rooms' => $rooms]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return View::make('rooms.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input, Room::$rules, Room::$messages);

        if ($validator->fails()) {
            return Redirect::to('/salas/cadastrar')
                ->withErrors($validator)
                ->withInput($input);
        } else {
            $room  = new Room();
            $room->name = $input['name'];
            $room->save();

            Session::flash('success', 'Sala cadastrada com sucesso!');
            return Redirect::to('/salas');

        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id = 0)
    {
        if ($id == 0)
            return Redirect::to('/salas');

        $room = Room::find($id);
        if ($room) {
            return View::make('rooms.edit', ['room' => $room]);
        }

        Session::flash('fail', 'Sala não encontrada!');
        return Redirect::to('/salas');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if ($id == 0)
            return Redirect::to('/salas');

        $room = Room::find($id);
        if (!$room) {
            Session::flash('fail', 'Sala não encontrada!');
            return Redirect::to('/salas');
        }

        $input = $request->all();
        $rules = ['name' => 'required|unique:rooms,name,' . $id];
        $validator = Validator::make($input, $rules, Room::$messages);

        if ($validator->fails()) {
            return Redirect::to('/salas/editar')
                ->withErrors($validator)
                ->withInput($input);
        } else {
            $room->name = $input['name'];
            if ($room->save()) {
                Session::flash('success', 'Sala editada com sucesso!');
                return Redirect::to('/salas');
            }

            Session::flash('fail', 'Ocorreu um erro ao atualizar a sala!');
            return Redirect::to('/salas');

        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id = 0)
    {
        if ($id == 0)
            return Redirect::to('/salas');

        $room = Room::find($id);
        if (!$room) {
            Session::flash('fail', 'Sala não encontrada!');
            return Redirect::to('/salas');
        }

        $room->delete();
        Session::flash('success', 'Sala removida com sucesso!');
        return Redirect::to('/salas');
    }
}
