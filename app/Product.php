<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    //
    protected $table= "interieur_products";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
   protected $fillable = [
       'name', 'price', 'catagory', 'description', 'image', 'user'
   ];
}
