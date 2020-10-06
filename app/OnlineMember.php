<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OnlineMember extends Model
{
    protected $fillable = ['user_id', 'agency_id', 'price_per_second', 'pc_num'];
}
