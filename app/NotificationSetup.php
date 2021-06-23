<?php
  
namespace App;
  
use Illuminate\Database\Eloquent\Model;
   
class NotificationSetup extends Model
{
	protected $fillable = [
        'sms_id', 'sms_text'
    ];
    protected $table = 'notification';
    protected $primaryKey = 'id';
	public $timestamps = false;
}
