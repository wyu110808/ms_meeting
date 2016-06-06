<?php namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Meeting extends Model {

	//
    protected  $table='meeting';

    protected $fillable = [
        'm_state',
        'm_type',
        'm_subject',
        'm_member',
        'm_department',
        'm_mc',
        'm_author',
        'm_date1',
        'm_date2',
        'm_address',
        'm_comment',

    ];
}
