<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\ApiTrait;

class Work extends Model
{
    use HasFactory, ApiTrait;
    const NoRealizado = 1;
    const Realizado = 2;
    protected $fillable = ['name','user_id','status'];

    protected $allowIncluded = ['user'];

    protected $allowFilter = ['id','name','status','user_id','created_at'];
    protected $allowSort = ['id','name','status','user_id','created_at'];


    public function user(){
        return $this->belongsTo(User::class);
    }

    //realacion uno a muchos polimorfica
    public function image(){
        return $this->morphOne(Image::class,'imageable');
    }
}


