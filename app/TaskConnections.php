<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuids;

class TaskConnections extends Model
{
    //
    use Uuids; //Added for special UUID Trait

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [

     'user_id', 'task_id'
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
    
    protected $table_name = "task_connections";
    public $incrementing = false;
  
}
