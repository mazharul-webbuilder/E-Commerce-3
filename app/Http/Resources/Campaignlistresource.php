<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;
class Campaignlistresource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        if($this->start_date > Carbon::today()){
            $status = "Upcoming";
        }elseif (($this->start_date <= Carbon::today()) && ($this->end_date >= Carbon::today())){
            $status = "Running";
        }
        return [
            'id' => $this->id,
            'name' => $this->campaign_title,
            'status' => $status,
            'tournament'=>[
                'id'=>$this->tournament->id,
                'player_type'=>$this->tournament->player_type
            ]
        ];
    }
}
