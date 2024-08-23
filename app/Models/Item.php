<?php

namespace App\Models;

use App\Models\BaseModel\BaseModel;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Translatable\HasTranslations;

class Item extends BaseModel
{
    use HasFactory, SoftDeletes, HasTranslations;


    protected $fillable = [
        'category_id',
        'image',
        'name',
        'description',
        'is_active',
        'status',
    ];

    public $imageable = [
        'image',
    ];

    public $translatable = [
        'name',
        'description',
    ];
    protected $casts = [
        'name' => 'array',
        'description' => 'array',
    ];


    public function category() {
        return $this->belongsTo(Category::class, 'category_id');
    }


    public function scopeSearch(Builder $query, $request)
    {

        ////////////////////////////////////////////////////////////////////
        ///////* common search queries */
        ////////////////////////////////////////////////////////////////////
        if ($request['name'] ?? false) {
            $query->where('name', 'LIKE', "%{$request['name']}%");
        }
        if ($request['description'] ?? false) {
            $query->where('description', 'LIKE', "%{$request['description']}%");
            // $this->filterByJson($query, 'description', $request['description']);
        }

        if (isset($request['is_active']) && $request['is_active'] != '') {
            $query->where('is_active', '=', $request['is_active']);
        }
        if (isset($request['category_id']) && $request['category_id'] != '') {
            // $query->where('category_id', '=', $request['category_id']);

        }
        ////////////////////////////////////////////////////////////////////
        ///////* one to many || one to one */
        ////////////////////////////////////////////////////////////////////
        // if (isset($request['user_id']) && $request['user_id'] != '') {
        //     $query->where('user_id', '=', $request['user_id']);
        // }


        ////////////////////////////////////////////////////////////////////
        ///////* many to many || one to many || one to one (by relation method) */
        ////////////////////////////////////////////////////////////////////
        // if (isset($request['user_id']) && $request['user_id'] != '') {
        //     $query->whereHas('user', function ($userQuery) use ($request) {
        //         $userQuery->where('id', '=', $request['user_id']);
        //     });
        // }

        ////////////////////////////////////////////////////////////////////
        ///////* multi search in one input */
        ////////////////////////////////////////////////////////////////////
        // if ($request['name_courseNumber'] ?? false) {
        //     $query->where('name', 'LIKE', "%{$request['name_courseNumber']}%")->orWhere('course_number', 'LIKE', "%{$request['name_courseNumber']}%");
        // }
    }
}
