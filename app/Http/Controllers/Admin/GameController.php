<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Playerenroll;
use Illuminate\Http\Request;
use App\Models\Game;
use App\Models\Gameround;
use App\Models\Roundludoboard;
use App\Models\User;
use App\Models\Playerinboard;
use App\Models\Tournament;

class GameController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $tournament = Tournament::find($id);
        $games = Game::where('tournament_id', $id)->get();
        return view('webend.game', compact('games', 'tournament'));
    }

    public function  join_user($game_id,$tournament_id){
        $tournament=Tournament::find($tournament_id);
        $datas=Playerenroll::where(['tournament_id'=>$tournament_id,'game_id'=>$game_id])->get();
        return view('webend.join_user', compact('datas','tournament','game_id'));
    }



    public function round_list($id)
    {
        //return $id;
        $game = Game::find($id);
        $rounds = Gameround::where('game_id', $id)->get();
        return view('webend.round_list', compact('game', 'rounds'));
    }

    public function board_list($id)
    {
        $round = Gameround::find($id);
        $boards = Roundludoboard::where('round_id', $id)->get();
        return view('webend.board_list', compact('round', 'boards'));
    }

    public function playerlist($id)
    {
        $board = Roundludoboard::find($id);
        $player = Playerinboard::where('board_id', $board->id)->first();
        return view('webend.player_list', compact('player', 'board'));
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
    public function destroy($id)
    {
        //
    }
}
