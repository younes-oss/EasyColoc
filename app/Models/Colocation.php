<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Colocation extends Model
{
    public function users()
    {
        return $this->belongsToMany(User::class)
            ->withPivot(['role', 'joined_at', 'left_at'])
            ->withTimestamps();
    }

    public function activeUsers()
    {
        return $this->belongsToMany(User::class)
            ->wherePivotNull('left_at');
    }

    public function expenses()
    {
        return $this->hasMany(Expense::class);
    }

    public function categories()
    {
        return $this->hasMany(Category::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    protected $fillable = [
        'name',
        'status',
    ];
}
