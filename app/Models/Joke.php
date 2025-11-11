<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Joke extends Model
{
    use HasFactory;
	
	protected $table = 'jokes'; 
	public $timestamps = false;
    protected $guarded = [];
	
	
	
	 public function isRead()
    {
        return $this->hasMany(JokeUser::class,'joke_id');
    }
}
