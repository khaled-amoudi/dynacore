<?php

namespace App\Http\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Storage;

trait HasFilters
{

    /**
     * $q: The Eloquent query builder.
     * $attribute: The name of the field to filter on.
     * $value: The value to filter by.
     * $operator: The SQL operator to use in the WHERE clause. The default operator is LIKE.
     *
     * Example: // $this->filterByKey($query, 'description', $request['description']);
     */
    public function filterByKey(Builder $query, $attribute, $value, $operator = "LIKE")
    {
        // تبحث عن النص بشكل عادي
        return isset($value) ? $query->where($attribute, $operator, "%$value%") : $query;
    }



    /////////////////////////////////////////////////////////////////////
    /////////////////////////////////////////////////////////////////////
    /////////////////////////////////////////////////////////////////////



    /**
     * $relation: The name of the relationship to search on.
     * $attribute: The name of the field in the related model to search on.
     * $request_key: The name of the request key that contains the search value.
     * $json: A boolean value indicating whether the field in the related model is a JSON field.
     *
     * Example:  // $this->filterByKeyRelation('posts', 'title', $request['title']);
     */
    public function filterByKeyRelation($relation, $attribute, $request_key, bool $json = false)
    {
        // تبحث عن النص في العلاقة, مثلا (جيبلي الطلاب اللي اسمهم خالد وتابعين لهذا الكورس)
        return $this->whereHas($relation, function ($inner) use ($attribute, $request_key, $json) {
            $json ? $this->filterByJson($inner, $attribute, request()->get($request_key)) :
                $this->filterByKey($inner, $attribute, request()->get($request_key));
        });
    }



    /////////////////////////////////////////////////////////////////////
    /////////////////////////////////////////////////////////////////////
    /////////////////////////////////////////////////////////////////////



    /**
     * $q: The Eloquent query builder.
     * $attribute: The name of the JSON field to filter on.
     * $value: The value to filter by.
     * $operator: The SQL operator to use in the WHERE clause. The default operator is LIKE.
     *
     * Example:  // $this->filterByJsonCurrentLang($query, 'description', $request['description']);
     */
    public function filterByJsonCurrentLang(Builder $query, $attribute, $value, $operator = "LIKE")
    {
        // تبحث عن النص في الجيسون وتظهر كل النتائج للغة الحالية فقط
        $query = isset($value) ? $query->whereRaw('LOWER(JSON_EXTRACT(' . $attribute . ', "$.' . app()->getLocale() . '")) like ?', ['"%' . strtolower($value) . '%"']) : $query;
        return $query;
    }



    /////////////////////////////////////////////////////////////////////
    /////////////////////////////////////////////////////////////////////
    /////////////////////////////////////////////////////////////////////

    /**
     * $q: The Eloquent query builder.
     * $attribute: The name of the JSON field to filter on.
     * $value: The value to filter by.
     *
     * Example:  // $this->filterByJsonMultipleLang($query, 'description', $request['description']);
     */
    public function filterByJsonMultipleLang(Builder $q, $attribute, $value)
    {
        // تبحث عن النص في الجيسون وتظهر كل النتائج من جميع اللغات
        $q = isset($value) ? $q->whereRaw("JSON_SEARCH(LOWER($attribute), 'all', ?) IS NOT NULL", ["%{$value}%"]) : $q;
        return $q;
    }



}
