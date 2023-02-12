<?php

namespace App\Models\api\words;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Word extends Model
{
    use HasFactory;

    public function wordsCategory()
    {
        return $this->belongsTo(WordsCategory::class);
    }

    protected $fillable = ["nameAr", "nameEn", "nameFr", "nameGr", "category_id", "recognitionEn", "recognitionGr", "recognitionFr"];
}
