<?php

namespace App\Models;

use App\Notifications\VerifyEmailNotification;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Notification;
use App\Notifications\ForgotPasswordNotification;

/**
 * @method where
 */
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;


    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = ['id'];
    protected $fillable = [
        'name',
        'email',
        'password',
        'last_seen',

    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'pivot'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    /**
     * @return BelongsToMany
     */
    public function friends(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'friends', 'user_id', 'friend_id')->withTimestamps();
    }

    /**
     * @return BelongsToMany
     */
    public function friendPendingRequest(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'friend_pendings', 'user_id', 'friend_id')->withTimestamps();
    }

    /**
     * @return BelongsToMany
     */
    public function friendRequest(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'friend_pendings', 'friend_id', 'user_id')->withTimestamps();
    }

    /**
     * @param $user
     * @return void
     */
    public function friendAdd($user): void
    {
        $this->friendPendingRequest()->attach($user->id);
    }

    /**
     * @param $user
     * @return void
     */
    public function friendDelete($user): void
    {
        $this->friends()->detach($user->id);

    }

    /**
     * @param $user
     * @return void
     */
    public function friendAccept($user): void
    {
        $this->friendRequest()->detach($user->id);
        $this->friends()->attach($user->id);
    }

    /**
     * @param $user
     * @return void
     */
    public function friendDecline($user): void
    {
        $this->friendRequest()->detach($user->id);
    }

    /**
     * @param User $user
     * @return void
     */
    public function pendingCancel(User $user): void
    {
        $this->friendPendingRequest()->detach($user->id);
    }

    public function friendCounts(): array
    {
        return [
            'friends' => $this->friends()->count(),
            'pending' => $this->friendPendingRequest()->count(),
            'request' => $this->friendRequest()->count(),
        ];
    }

    public function receivesBroadcastNotificationsOn(): string
    {
        return 'push_notify.' . $this->id;
    }

//    public function settings(): HasOne
//    {
//        return $this->hasOne(UserSetting::class, 'user_id', 'id');
//    }

    public function sendResetPasswordEmail($token)
    {
        Notification::send($this, new ForgotPasswordNotification($token));
    }

    public function sendVerificationEmail($token)
    {
        Notification::send($this, new VerifyEmailNotification($token));
    }

    public function profile(): HasOne
    {
        return $this->hasOne(Profile::class);
    }

}
