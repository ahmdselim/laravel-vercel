<?php

namespace App\Models\api\coursePrice;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CoursesPrice extends Model
{
    use HasFactory;

    protected $fillable = ["price"];
}
