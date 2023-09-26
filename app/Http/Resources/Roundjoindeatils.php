<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Roundjoindeatils extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
        "id" => $this->id,
        "tournament_id" =>$this->tournament_id,
        "game_id" =>$this->game_id,
        "round_id" => $this->round_id,
        "board_id" => $this->board_id,
        "board_start_time" => 3,
        "room_id" => $this->board_name->board,
        "player_one" => $this->player_one,
        "player_two" => $this->player_two,
        "player_three" => $this->player_three,
        "player_four" =>$this->player_four,
        "first_winner" => $this->first_winner,
        "second_winner" => $this->second_winner,
        "third_winner" => $this->third_winner,
        "fourth_winner" => $this->fourth_winner,
        "round_diamond" => $this->round_diamond,
        "status" => $this->status,
        "created_at" => $this->created_at->format('d-m-Y, g:i A') ,
        "updated_at" =>$this->updated_at->format('d-m-Y, g:i A'),
        ];
    }
}
