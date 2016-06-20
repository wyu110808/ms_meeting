<?php namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Staff extends Model {

	//
    protected  $table='staff';

    protected $fillable = [
        's_name',
        's_department',


    ];
}
