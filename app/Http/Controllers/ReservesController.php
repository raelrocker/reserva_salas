<?php

namespace App\Http\Controllers;

use App\Reserve;
use App\Room;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;

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
        $hoursReserved = [];
        for ($i = 0; $i < 24; $i++) {
            $hours[$i] = $date . ' ' . str_pad($i, 2, '00', STR_PAD_LEFT) . ':00:00';
        }
        foreach ($rooms as $room) {
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
        //
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

        $reserve->delete();
        Session::flash('success', 'Reserva removida com sucesso!');

        return Redirect::route('home', ['date' => '2017-06-04']);
    }
}
