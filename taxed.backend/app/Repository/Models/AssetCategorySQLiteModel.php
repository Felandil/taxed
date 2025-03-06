<?php

namespace App\Repository\Models;

use App\Entity\AssetCategory;
use Illuminate\Database\Eloquent\Model;

class AssetCategorySQLiteModel extends Model
{
    protected $table = 'asset_categories';

    protected $fillable = [
        'code',
        'name',
        'useful_life',
        'depreciation_rate',
        'parent_id'
    ];

    public function parent()
    {
        return $this->belongsTo(AssetCategorySQLiteModel::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(AssetCategorySQLiteModel::class, 'parent_id');
    }

    public function categories()
    {
        return $this->children()->with('categories');
    }

    /**
     * @return AssetCategory
     */
    public function toEntity(): AssetCategory
    {
        return new AssetCategory($this->id, $this->name, $this->useful_life, $this->depreciation_rate);
    }
}
