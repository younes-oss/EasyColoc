<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class ColocationUser extends Pivot
{
    protected $table = 'colocation_user';

    protected $dates = ['joined_at', 'left_at'];
}
