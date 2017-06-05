<?php

namespace App\Http\Controllers;

use App\Reserve;
use App\Room;
use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;
use Mockery\CountValidator\Exception;

class ReservesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($date = null)
    {
        if ($date == null) {
            $date = Carbon::today()->format('Y-m-d');
        }
        $from = $date . ' 00:00:00';
        $to = $date . ' 23:59:59';
        $rooms = Room::all();
        $reserves = [];
        $free = [];
        $hours = [];

        for ($i = 0; $i < 24; $i++) {
            $hours[$i] = $date . ' ' . str_pad($i, 2, '00', STR_PAD_LEFT) . ':00:00';
        }
        foreach ($rooms as $room) {
            $hoursReserved = [];
            $reserve = Reserve::where([['room_id', '=', $room->id], ['datetime', 'like', $date . '%']])->get();
            $reserves[$room->id] = $reserve;
            $free[$room->id] = [];
            foreach ($reserve as $reg) {
                $hoursReserved[] = $reg->datetime;
            }
            for ($i = 0; $i < 24; $i++) {
                if (!in_array($hours[$i], $hoursReserved))
                    $free[$room->id][] = str_pad($i, 2, '00', STR_PAD_LEFT) . ':00';
            }
        }
        return View::make('home', ['reserves' => $reserves, 'free' => $free, 'rooms' => $rooms, 'date' => $date]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
        $validator = Validator::make($input, Reserve::$rules, Reserve::$messages);

        if ($validator->fails()) {
            return Redirect::to('/home');
        } else {
            $reserve  = new Reserve();
            $reserve->user_id = $input['user_id'];
            $reserve->room_id = $input['room_id'];
            $reserve->datetime = $input['datetime'];
            $date = Carbon::parse($input['datetime']);
            try {
                $reserve->save();
            } catch (QueryException $ex) {
                $msg = '';
                if ($ex->getMessage().contains('UN_RESERVES_USER_DATETIME')) {
                    $msg = 'Você já reservou uma sala neste horário';
                } else {
                    $msg = 'Ocorreu um erro ao reservar a sala';
                }
                Session::flash('fail', $msg);
                return Redirect::route('home', ['date' => $date->format('Y-m-d')]);
            }

            Session::flash('success', 'Reserva cadastrada com sucesso!');
            return Redirect::route('home', ['date' => $date->format('Y-m-d')]);


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
    public function edit($id)
    {
        //
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
        //
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
            return Redirect::to('/home');

        $reserve = Reserve::find($id);
        if (!$reserve) {
            return Redirect::to('/home');
        }
        $date = Carbon::parse($reserve->datetime);
        $reserve->delete();
        Session::flash('success', 'Reserva removida com sucesso!');

        return Redirect::route('home', ['date' => $date->format('Y-m-d')]);
    }
}
