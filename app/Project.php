<?php

namespace App;

use App\Traits\ParentProjects;
use App\Traits\PaymentSystems;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Project extends Model
{
    use ParentProjects;
}
