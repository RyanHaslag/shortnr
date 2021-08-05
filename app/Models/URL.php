<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class URL extends Model
{

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'url';


    public $timestamps = true;


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'shortcode',
        'full_url',
        'url_title',
        'nsfw',
        'visit_count'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [

    ];
}
