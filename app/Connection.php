<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Connection extends Model
{
    //
    protected $fillable = [
        'user_id','department_id'
    ];

    
    protected $table_name="connections";
    protected $primaryKey = 'id';
    protected $keyType = 'string';

    // protected $casts = [
    //     'id' => 'string',
    // ];

    public static function getByUser($id){
      
        return self::where('user_id',$id)
            ->join('departments', 'department_id', '=','departments.id')
            ->select('departments.id','user_id', 'departments.created_at', 'departments.updated_at', 'description','status', 'name')
            ->get();
    }
}
