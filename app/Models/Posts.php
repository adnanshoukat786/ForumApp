<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Posts extends Model
{
	protected $table = 'posts';
    public function category() {
		return $this->belongsTo('App\Models\Category', 'category_id', 'id');
    }

    public function comments() {
        return $this->hasMany('App\Models\Comments', 'post_id', 'id');
    }
	
	public function user() {
        return $this->belongsTo('App\User', 'user_id', 'id');
    }
}
