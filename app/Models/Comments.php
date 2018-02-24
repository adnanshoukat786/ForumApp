<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Comments extends Model
{
	protected $table = 'comments';
    public function category() {
		return $this->belongsTo('category');
    }
	public function posts() {
        return $this->hasMany('App\Models\Posts', 'post_id ', 'id');
    }
	
	public function user() {
        return $this->belongsTo('App\User', 'user_id', 'id');
    }
}
