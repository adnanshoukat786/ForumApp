<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Category extends Model
{
	//public $timestamps  = false;
	//const CREATED_AT = 'created_at';
	//const UPDATED_AT = 'updated_at';
	protected $table = 'categories';
    public function posts() {
        return $this->hasMany('Post');
    }
}
