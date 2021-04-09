<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Term extends BaseModel
{
    protected $table = 'terms';
    protected static $table_static = 'terms';
    protected $guarded = ['id'];
    protected $dates = ['deleted_at'];
    public function userUpdated()
    {
        return $this->hasOne('App\User', 'id', 'updated_user');
    }

    public function userCreated()
    {
        return $this->hasOne('App\User', 'id', 'created_user');
    }

    public function getFullTextTermAttribute(){

        $q = '<ul><li><span style="font-size: 11pt; font-family: arial, helvetica, sans-serif;">'  . preg_replace('/(<p>)/', "", $this->description.'</span>' ). '</li></ul>';
        return $q;
    }

    public function getFullTextTermENAttribute(){

        $q = '<ul><li><span style="font-size: 11pt; font-family: arial, helvetica, sans-serif;">' . preg_replace('/(<p>)/', "", $this->description_en.'</span>' ) . '</li></ul>';

        return $q;
    }
}
