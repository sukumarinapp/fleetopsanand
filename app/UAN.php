<?php
  
namespace App;
  
use Illuminate\Database\Eloquent\Model;
   
class UAN extends Model
{
    protected $table = 'uan';
    protected $primaryKey = 'id';
	public $timestamps = false;
}
