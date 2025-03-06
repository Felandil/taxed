<?php

namespace App\Repository\Models;

use App\Entity\MovableAsset;
use Illuminate\Database\Eloquent\Model;

class MovableAssetSQLiteModel extends Model
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
        return $this->belongsTo(AssetCategorySQLiteModel::class, 'asset_category_id');
    }

    public function toEntity(): MovableAsset
    {
        return new MovableAsset(
            $this->id,
            $this->name,
            $this->price,
            $this->bookedAt,
            $this->assetCategory->toEntity()
        );
    }
}