<?php
  
namespace App;
  
use Illuminate\Database\Eloquent\Model;
   
class CAN extends Model
{
    protected $table = 'can';
    protected $primaryKey = 'id';
	public $timestamps = false;
}
