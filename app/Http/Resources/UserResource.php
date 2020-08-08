<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        
        return [
            'token' => $this['token'], 
            'name' => $this['name'], 
            'avatar' => $this['avatar'], 
            'id' => $this['id'],
            'eid' => $this['eid'],
            'subscriptions' => new PushSubscriptionCollection($this['subscriptions']),
        ];
    }
}
