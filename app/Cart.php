<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
  public function user(){

  	return $this->hasmany('App\User');

  }
  public function product(){

  	return $this->belongsTo('App\Product');

  }    
}