<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
// use App\Policies\OrderPolicy;
// use Illuminate\Database\Eloquent\Attributes\UsePolicy;

// #[UsePolicy(OrderPolicy::class)]
class Booking extends Model
{
    protected $fillable = ['title','date','status'];
}