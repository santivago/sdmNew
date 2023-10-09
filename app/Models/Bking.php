<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bking extends Model
{
    use HasFactory;
    protected $fillable = ['course_id','clients_id'];
}
