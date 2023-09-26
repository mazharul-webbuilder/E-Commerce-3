<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class Notificationresource extends JsonResource
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
            'order_id'=>$this->order_id,
            'user_id'=>$this->user_id,
            'tournament_id'=>$this->tournament_id,
            'gameround_id'=>$this->gameround_id,
            'game_id'=>$this->game_id,
            'type'=>$this->type,
            'title'=>$this->title,
            'status'=>$this->status == 1?"seen":"unseen",
            'created_at'=>$this->created_at->diffForHumans(),
            'humanize_date'=>Carbon::parse($this->created_at)->diffForHumans()
        ];
    }
}
