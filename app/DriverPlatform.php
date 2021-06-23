<?php
  
namespace App;
  
use Illuminate\Database\Eloquent\Model;
   
class DriverPlatform extends Model
{
    protected $fillable = [
        'driver_id','PLF' 
    ];
    protected $table = 'driver_platform';
    protected $primaryKey = 'id';
	public $timestamps = false;
}
