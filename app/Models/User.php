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
        return $this->belongsToMany(User::class, 'friends', 'user_id', 'friend_id')
            ->wherePivot('status', Friend::STATUS_ACCEPTED)
            ->withTimestamps();
    }

    /**
     * @return BelongsToMany
     */
    public function friendPendingRequest(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'friends', 'user_id', 'friend_id')
            ->wherePivot('status', Friend::STATUS_PENDING)
            ->withTimestamps();
    }

    /**
     * @return BelongsToMany
     */
    public function friendRequest(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'friends', 'friend_id', 'user_id')
            ->wherePivot('status', Friend::STATUS_PENDING)
            ->withTimestamps();
    }

    /**
     * @return string
     */
    public function receivesBroadcastNotificationsOn(): string
    {
        return 'push_notify.' . $this->id;
    }

    /**
     * @param $token
     * @return void
     */
    public function sendResetPasswordEmail($token): void
    {
        Notification::send($this, new ForgotPasswordNotification($token));
    }

    /**
     * @return void
     */
    public function sendVerificationEmail(): void
    {
        Notification::send($this, new VerifyEmailNotification());
    }

    /**
     * @return HasOne
     */
    public function profile(): HasOne
    {
        return $this->hasOne(Profile::class);
    }
}
