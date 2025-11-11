<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JokeUser extends Model
{
    use HasFactory;
    protected $table = 'joke_user'; 
    protected $guarded = [];
	
	 public function Jokes()
    {
        return $this->HasOne(Joke::class, 'joke_id');
    }
}
