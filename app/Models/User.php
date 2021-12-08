<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasRoles;
    use HasApiTokens;
    use HasFactory;
    use Notifiable;
    use TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable
        = [
            'name',
            'email',
            'status',
            'password',
            'first_name',
            'last_name',
        ];


    private static $userStatusLabelValueArray = ['A' => 'Активен', 'I' => 'Неактивен', 'N' => 'Новый'];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden
        = [
            'password',
            'remember_token',
            'two_factor_recovery_codes',
            'two_factor_secret',
        ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts
        = [
            'email_verified_at' => 'datetime',
        ];

    public static function getUserStatusValueArray($key_return = true): array
    {
        $resArray = [];
        foreach (self::$userStatusLabelValueArray as $key => $value) {
            if ($key_return) {
                $resArray[] = ['key' => $key, 'label' => $value];
            } else {
                $resArray[$key] = $value;
            }
        }

        return $resArray;
    }

    public static function getUserStatusLabel(string $status): string
    {
        if ( ! empty(self::$userStatusLabelValueArray[$status])) {
            return self::$userStatusLabelValueArray[$status];
        }

        return '';
    }


    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [ ];

    public static function getUserValidationRulesArray($user_id, array $skipFieldsArray = []): array
    {
        $validationRulesArray = [
            'name'       => 'required|max:100|unique:' . with(new User)->getTable(),
            'email'      => 'required|email|max:100|unique:' . with(new User)->getTable(),
            'status'     => 'required|in:' . getValueLabelKeys(User::getUserStatusValueArray(false)),
            'password'   => 'required|min:6|max:15',
            'password_2' => 'required|min:6|max:15|same:' . 'password',
            'first_name' => 'required|max:50',
            'last_name'  => 'required|max:50',
        ];

        foreach ($skipFieldsArray as $next_field) {
            if ( ! empty($validationRulesArray[$next_field])) {
                unset($validationRulesArray[$next_field]);
            }
        }

        return $validationRulesArray;
    }

}
