<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
class SmsLog extends Model
{
    protected $table = 'sms_log';
    protected static $table_static = 'sms_log';
    protected $guarded = ['id'];
    protected $dates = ['deleted_at'];
    
}
