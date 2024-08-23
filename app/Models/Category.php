<?php

namespace App\Models;

use App\Models\BaseModel\BaseModel;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends BaseModel
{
    use HasFactory, SoftDeletes;


    protected $fillable = [
        'slug',
        'name',
        'image',
        // 'tags',
        'description',
        'is_active',
    ];

    protected $with = ['items'];



    public $imageable = [
        'image',
    ];

    public $translatable = [];


    public function scopeSearch(Builder $query, $request)
    {
        if ($request['name'] ?? false) {
            $query->where('name', 'LIKE', "%{$request['name']}%");
        }
        if ($request['description'] ?? false) {
            $query->where('description', 'LIKE', "%{$request['description']}%");
        }
        if (isset($request['is_active']) && $request['is_active'] != '') {
            $query->where('is_active', '=', $request['is_active']);
        }
        // if ($request['name_courseNumber'] ?? false) {
        //     $query->where('name', 'LIKE', "%{$request['name_courseNumber']}%")->orWhere('course_number', 'LIKE', "%{$request['name_courseNumber']}%");
        // }
        // if (isset($request['degree']) && $request['degree'] != '') {
        //     $query->where('degree', '=', $request['degree']);
        // }
    }

    public function items() {
        return $this->hasMany(Item::class);
    }
}
