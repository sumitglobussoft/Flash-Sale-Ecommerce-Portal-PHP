<?php

namespace FlashSaleApi\Http\Models;

use Illuminate\Database\Eloquent\Model;
use DB;
use Illuminate\Database\QueryException;

class ProductTags extends Model

{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'product_tags';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['pi_id', 'for_product_id', 'image_type', 'images_upload_type', 'image_url'];





}