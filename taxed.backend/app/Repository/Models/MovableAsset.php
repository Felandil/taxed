<?php

namespace App\Repository\Models;

use Illuminate\Database\Eloquent\Model;

class MovableAsset extends Model
{
    protected $table = 'moveable_assets';

    public $timestamps = false;

    protected $fillable = [
        'name',
        'price',
        'bookedAt',
        'asset_category_id',
    ];

    protected $casts = [
        'price'    => 'double',
        'bookedAt' => 'date',
    ];

    public function assetCategory()
    {
        return $this->belongsTo(AssetCategory::class, 'asset_category_id');
    }
}