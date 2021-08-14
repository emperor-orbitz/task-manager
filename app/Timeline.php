<?php

namespace App;
use App\Traits\Uuids;

use Illuminate\Database\Eloquent\Model;

class Timeline extends Model
{
    //

    use Uuids; //Added for special UUID Trait

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'notes','progress','task_updates','user_id', 'task_id', 'task_connection_id'
        ];

  

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */

    protected $table_name="timelines";
   
    protected $primaryKey = 'id';
    protected $keyType = 'string';
}
