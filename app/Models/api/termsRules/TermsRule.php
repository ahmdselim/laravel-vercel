<?php

namespace App\Models\api\termsRules;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TermsRule extends Model
{
    use HasFactory;

    protected $fillable = ["terms"];
}
