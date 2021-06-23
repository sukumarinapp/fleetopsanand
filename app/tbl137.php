<?php
  
namespace App;
  
use Illuminate\Database\Eloquent\Model;
   
class tbl137 extends Model
{
	protected $fillable = [
        'SDT','CAN','VNO','CHR','CML','RCN','RHN','SPF','CPF','TPF','SSR' 
    ];
    protected $table = 'tbl137';
    protected $primaryKey = 'id';
	public $timestamps = false;
}
