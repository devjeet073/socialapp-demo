<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class Posttag extends Pivot
{
    protected $table = "post_tag";
}
