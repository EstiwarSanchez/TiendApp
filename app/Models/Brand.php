<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    use HasFactory;

     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'reference','created_at','updated_at'
    ];

    /**
     *  Querys
     */
    public function scopeGetBrand($query){

        return $query->where('delete',0);
    }
}
