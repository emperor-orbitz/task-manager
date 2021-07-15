<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuids;

class Task extends Model
{
    //a
    use Uuids; //Added for special UUID Trait

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [

        'title', 'department_id', 'description', 'assigner', 'status', 'start', 'finish', 'notes'
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
    
    protected $table_name = "tasks";
    public $incrementing = false;
    protected $casts = [
        // 'notes' => 'array',
    ];
}
