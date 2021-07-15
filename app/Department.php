<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuids;

class Department extends Model
{
    //
    use Uuids; //Added for special UUID Trait
    // use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'description', 'status', 'logo',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $primaryKey = 'id';
    protected $table_name = "departments";
    protected $keyType = 'string';

    protected $casts = [
        'id' => 'string',
    ];
}
