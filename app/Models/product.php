<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class product extends Model
{
    use HasFactory;
  protected  $table = "products";

  public function category(){
    return $this->belongsTo(category::class,'category_id');
  }

  public function orderItems(){
    return $this->hasMany(OrderItem::class,'product_id');
  }

  public function subCategories(){
    return $this->belongsTo(Subcategory::class,'subcategory_id');
  }

  public function AttributeValues(){
     return $this->hasMany(AttributeValue::class,'product_id');
  }
}
