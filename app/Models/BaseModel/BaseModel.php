<?php

namespace App\Models\BaseModel;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use PhpOffice\PhpSpreadsheet\Calculation\Statistical\Distributions\F;

class BaseModel extends Model
{
    use HasFactory;

    protected $fillable = [];
    protected $columnsForSheets = null;
    public $imageable = [];
    public $translatable = [];
    // protected $primaryKey = 'id';
    // protected $with = ['relationMethod:attr1,attr2'];


    // public function setIsActiveAttribute($value)
    // {
    //     $this->attributes['is_active'] = 'on' ? 1 : 0;
    // }

    //////////////////////////////////////////////////////////////////
    //////////////////////////////////////////////////////////////////
    //// Scopes
    //////////////////////////////////////////////////////////////////
    public function scopeSearch(Builder $query, $request)
    {

        ////////////////////////////////////////////////////////////////////
        ///////* common search queries */
        ////////////////////////////////////////////////////////////////////
        // if ($request['name'] ?? false) {
        //     $query->where('name', 'LIKE', "%{$request['name']}%");
        // }
        // if (isset($request['is_active']) && $request['is_active'] != '') {
        //     $query->where('is_active', '=', $request['is_active']);
        // }

        ////////////////////////////////////////////////////////////////////
        ///////* Translatable Column */
        ////////////////////////////////////////////////////////////////////
        // if ($request['description'] ?? false) {
        // // search in all languages
        // $query->where('description', 'LIKE', "%{$request['description']}%");

        // // search in the current language
        // $this->filterByJson($query, 'description', $request['description']);
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




    public function scopeActive(Builder $query)
    {
        // $query->where('status', 'active');
        // $query->where('status', 1);
        // $query->where('is_active', 1);
    }
    public function scopeWithAndWhereHas($query, $relation, $constraint)
    {
        return $query->whereHas($relation, $constraint)
            ->with([$relation => $constraint]);

        // Example: How to use?
        // $categories = Category:: **withAndWhereHas('items', function ($query) {
        //     $query->where('name', 'LIKE', "%{$request['name']}%");
        // }) ** ->get();
    }
    //////////////////////////////////////////////////////////////////
    //////////////////////////////////////////////////////////////////



    //////////////////////////////////////////////////////////////////
    //////////////////////////////////////////////////////////////////
    //// Getters & Setters
    //////////////////////////////////////////////////////////////////
    public function getTranslatableOptions()
    {
        return $this->translatable;
    }

    public function getColumnsForSheets()
    {
        return $this->columnsForSheets;
    }
    public function setColumnsForSheets($columns = [])
    {
        $this->columnsForSheets = $columns;
        return $this;
    }

    public function getImageable()
    {
        return $this->imageable;
    }
    public function setImageable($columns = [])
    {
        $this->imageable = $columns;
        return $this;
    }
    //////////////////////////////////////////////////////////////////
    //////////////////////////////////////////////////////////////////
}
