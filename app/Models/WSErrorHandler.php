<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;


class WSErrorHandler extends Model
{
    use Notifiable;

    /**
    * The table associated with the model.
    *
    * @var string
    */
    protected $table = 'error_handler';
    protected $primaryKey = 'error_id';

    public $incrementing = false;

    /* Customization start - ashwin for the revision class */
    // use SoftDeletes;
    // protected $dates = ['deleted_at'];
    /* Customization end - ashwin for the revision class */


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [

    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [

    ];

}
