<?php

namespace App\Models\api\sentence;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SentenceCategory extends Model
{
    use HasFactory;

    protected $fillable = ["name","paid"];

}
