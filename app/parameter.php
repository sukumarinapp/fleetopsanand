<?php
  
namespace App;
  
use Illuminate\Database\Eloquent\Model;
   
class parameter extends Model
{
    protected $fillable = [
        'CWI_Z', 'CWI_d', 'CCEI_a','CCEI_b','CCEI_taSe','CCEI_n','CCEI_Xb','CCEI_Sxx','FPR','NWM'
    ];

    protected $table = 'tbl494';
    
    protected $primaryKey = 'id';

    public $timestamps = false;

}