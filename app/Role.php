<?php

namespace App;

use App\Traits\Permissions;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use Permissions;

}
