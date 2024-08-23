<?php

namespace App\Models;

use App\Models\BaseModel\BaseModel;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Translatable\HasTranslations;

class Post extends BaseModel
{
    use HasFactory, SoftDeletes, HasTranslations;


    protected $fillable = [
        'user_id',
        'image',
        'title',
        'description',
        'is_active',
        'status',
    ];


    public $imageable = [
        'image',
    ];

    public $translatable = [
        'title',
        'description',
    ];
    protected $casts = [
        'title' => 'array',
        'description' => 'array',
    ];



    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function scopeSearch(Builder $query, $request)
    {
        if ($request['title'] ?? false) {
            $query->where('title', 'LIKE', "%{$request['title']}%");
        }
        if ($request['description'] ?? false) {
            $query->where('description', 'LIKE', "%{$request['description']}%");
        }
        if (isset($request['is_active']) && $request['is_active'] != '') {
            $query->where('is_active', '=', $request['is_active']);
        }
        if (isset($request['status']) && $request['status'] != '') {
            $query->where('status', '=', $request['status']);
        }

        /* one to many || one to one */
        // if (isset($request['user_id']) && $request['user_id'] != '') {
        //     $query->where('user_id', '=', $request['user_id']);
        // }

        /* many to many || one to many || one to one (by relation method) */
        if (isset($request['user_id']) && $request['user_id'] != '') {
            $query->whereHas('user', function ($userQuery) use ($request) {
                $userQuery->where('id', '=', $request['user_id']);
            });
        }

        /* multi search in one input */
        // if ($request['name_courseNumber'] ?? false) {
        //     $query->where('name', 'LIKE', "%{$request['name_courseNumber']}%")->orWhere('course_number', 'LIKE', "%{$request['name_courseNumber']}%");
        // }
    }
}
