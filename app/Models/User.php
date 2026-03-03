<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Colocation;
use App\Models\Expense;
use App\Models\Payment;
use App\Models\ColocationUser;

class User extends Authenticatable
{


    public function colocations()
    {
        return $this->belongsToMany(Colocation::class)
            ->using(ColocationUser::class)
            ->withPivot(['role', 'joined_at', 'left_at'])
            ->withTimestamps();
    }

    public function expenses()
    {
        return $this->hasMany(Expense::class);
    }

    public function paymentsSent()
    {
        return $this->hasMany(Payment::class, 'from_user_id');
    }

    public function paymentsReceived()
    {
        return $this->hasMany(Payment::class, 'to_user_id');
    }

    /**
     * Vérifier si l'utilisateur a une colocation active
     */
    public function hasActiveColocation()
    {
        return $this->colocations()->wherePivotNull('left_at')->exists();
    }

    /**
     * Obtenir la colocation active de l'utilisateur
     */
    public function getActiveColocation()
    {
        return $this->colocations()->wherePivotNull('left_at')->first();
    }
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'reputation',
        'is_admin',
        'is_banned'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
