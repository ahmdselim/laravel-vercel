<?php

namespace App\Models\api\sentence;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sentence extends Model
{
    use HasFactory;

    protected $fillable = ["nameAr","nameEn","nameFr","nameGr","category_id","recognitionAr"];
}
