<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class ShortLink
 * @package App\Models
 * @version March 19, 2022, 8:46 am UTC
 *
 */
class ShortLink extends Model
{
    use SoftDeletes;

    use HasFactory;

    public $table = 'short_links';


    protected $dates = ['deleted_at'];



    public $fillable = [
        'full_path',
        'short_path',
        'redirection_count'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [

    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'short_path' => 'unique:short_links'
    ];

    /**
     * @return array|string[]
     */
    public function getRules(): array
    {
        return self::$rules;
    }
}
