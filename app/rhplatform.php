<?php
  
namespace App;
  
use Illuminate\Database\Eloquent\Model;
   
class rhplatform extends Model
{
    protected $fillable = [
        'RHN', 'RMN', 'RMS', 'RML', 'RHF','RHT','status','can_delete'
    ];

    protected $table = 'tbl361';
    
    protected $primaryKey = 'id';

    public $timestamps = false;

}