<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $fillable = [
        'product_name',
        'product_slug',
        'product_price',
        'product_desc',
        'product_content',
        'category_id',
        'brand_id',
        'product_status',
        'product_image'
    ];
    protected $primaryKey = 'product_id';
    protected $table = 'tbl_product';
}
