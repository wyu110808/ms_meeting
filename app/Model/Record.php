<?php namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Record extends Model {

	//
    protected  $table='record';

    protected  $fillable=[
        'm_id',
        's_openid',
        'r_date',



    ];
}
