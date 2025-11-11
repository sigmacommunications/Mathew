<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    use HasFactory;
    protected $table = 'purchases'; 
    protected $guarded = [];
   
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function file()
    {
        return $this->belongsTo(FileUpload::class);
    }
	
	public function FileUploadCategory()
    {
        return $this->hasOne(FileUploadCategory::class,'file_category_id','category_id');
    }
	
	
	

}

