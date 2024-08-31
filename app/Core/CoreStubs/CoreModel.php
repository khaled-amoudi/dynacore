<?php

namespace App\Core\CoreStubs;

use App\Http\Traits\HasFilters;
use App\Models\BaseModel\BaseModel;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Translatable\HasTranslations;

class CoreModel extends BaseModel
{
    use HasFactory, SoftDeletes, HasTranslations, HasFilters;


    protected $fillable = [
        // 'user_id',
        // 'image',
        // 'title',
        // 'description',
        // 'is_active',
        // 'status',
    ];


    public $imageable = [
        // 'image',
    ];

    public $translatable = [
        // 'title',
        // 'description',
    ];
    protected $casts = [
        // 'title' => 'array',
        // 'description' => 'array',
    ];



    public function scopeSearch(Builder $query, $request)
    {

        ////////////////////////////////////////////////////////////////////
        ///////* common search queries */
        ////////////////////////////////////////////////////////////////////
        // if ($request['title'] ?? false) {
        //     $query->where('title', 'LIKE', "%{$request['title']}%");
        // }
        // if (isset($request['is_active']) && $request['is_active'] != '') {
        //     $query->where('is_active', '=', $request['is_active']);
        // }

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
