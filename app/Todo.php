<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Todo extends Model
{
    use SoftDeletes;

    protected $fillable = ['title','user_id'];


    protected $dates = ['deleted_at'];
    
    public function getByUserId($id)
    {
        // dd($id);
        // dd($this->where('user_id', $id)->get());
        return $this->where('user_id', $id)->get();
    }
}


