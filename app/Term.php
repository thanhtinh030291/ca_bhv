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

        $q = [  
                'name' => $this->name,
                'content' => '<p style="text-align: justify;"><span style="font-family: arial, helvetica, sans-serif;">' .$this->name ." ". preg_replace('/(<p>)/', "", $this->description.'</span>', 1)
            ];
        return $q;
    }

    public function getFullTextTermENAttribute(){

        $q = [  
                'name' => $this->name,
                'content' => '<p style="text-align: justify;"><span style="font-family: arial, helvetica, sans-serif;">' .$this->name ." ". preg_replace('/(<p>)/', "", $this->description_en.'</span>', 1)
            ];
        return $q;
    }
}
