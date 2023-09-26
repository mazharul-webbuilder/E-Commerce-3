<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\User;
class Gifttokenhistory extends JsonResource
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
            'id'=>$this->id,
            'provider'=>User::find($this->provider_id)->name,
            'receiver'=>User::find($this->receiver_id)->name,
            'receiver_avatar'=>User::find($this->receiver_id)->avatar,
            'provider_avatar'=>User::find($this->provider_id)->avatar,
            'user_token'=>$this->user_token->token_number,
            'type'=>$this->user_token->type,
            'created_at'=>$this->user_token->created_at->format('d-m-Y, g:i A'),

        ];
    }
}
