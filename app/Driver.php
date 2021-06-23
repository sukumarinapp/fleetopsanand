<?php
  
namespace App;
  
use Illuminate\Database\Eloquent\Model;
   
class Driver extends Model
{
    protected $fillable = [
        'DNO','DNM','DSN','DCN','DLD','VCC','VBM','VPF','VPD','VAM','LEX','CEX' 
    ];

    protected $table = 'driver';
    
    protected $primaryKey = 'id';

}
