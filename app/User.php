<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use NotificationChannels\WebPush\HasPushSubscriptions;

class User extends Authenticatable
{
    use Notifiable, HasPushSubscriptions;

    protected $primaryKey = 'github_id';
    public $incrementing = false;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'github_id',
        'uuid',
        'api_token'
    ];


    public function updatePush($endpoint, $device, $key = null, $token = null)
    {
        $this->updatePushSubscription(
            $endpoint,
            $key,
            $token
        );
        $subscription = app(config('webpush.model'))->findByEndpoint($endpoint);
        $subscription->device = $device;
        $subscription->save();
    }
    
}
