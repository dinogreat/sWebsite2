<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    // Table Name
    protected $table = 'posts';
    // Primary Key
    public $primaryKey = 'id';
    // TimeStamps
    public $timeStamps = true;

    public $tiemStatmp = "tue";

    public $newparam = "newparama";

    public $psaasl ="sdfsdf";

    public $tanat = "tanat";

    public $tanat3 ="tanat2";

    public $tanat4 = "dfd";

    public function user(){
        return $this->belongsTo('App\User');
    }
}

