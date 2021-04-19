<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $fillable = ["ISBN","title","author","editorial","gender","synopsis","idiom","miniature","user_id"];

    public function User(){
        return $this->hasOne(User::class);
    }

}
