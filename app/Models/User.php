<?php

namespace App\Models;

use App\Http\Traits\HasFilters;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Illuminate\Database\Eloquent\Builder;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;
    use HasRoles;
    use SoftDeletes;
    use HasFilters;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'profile_photo_url',
    ];

    public $imageable = [
        'profile_photo_url',
    ];
    public function getImageable()
    {
        return $this->imageable;
    }
    public $translatable = [];
    public function getTranslatableOptions()
    {
        return $this->translatable;
    }

    public function scopeSearch(Builder $query, $request)
    {

        ////////////////////////////////////////////////////////////////////
        ///////* common search queries */
        ////////////////////////////////////////////////////////////////////
        if ($request['name'] ?? false) {
            $query->where('name', 'LIKE', "%{$request['name']}%");
        }
        if ($request['email'] ?? false) {
            $query->where('email', 'LIKE', "%{$request['email']}%");
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
