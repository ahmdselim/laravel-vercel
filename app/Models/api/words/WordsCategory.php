<?php

namespace App\Models\api\words;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WordsCategory extends Model
{
    use HasFactory;

    protected $fillable = ["name","paid"];


    public function words() {
        return $this->hasMany(Words::class);
    }
}
