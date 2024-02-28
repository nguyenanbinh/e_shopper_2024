<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'products';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['user_id', 'name', 'price', 'category_id', 'brand_id', 'status', 'sale', 'company', 'image', 'detail'];

    public function getImageSrcAttribute()
    {
        return $this->image ? asset(('upload/product/') . json_decode($this->image)[0]) : '';
    }
}
