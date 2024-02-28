<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'comments';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['content', 'user_id', 'blog_id', 'user_avatar', 'user_name', 'level'];

    public function getAvatarSrcAttribute()
    {
        return $this->user_avatar ? asset('upload/user/avatar/' . $this->user_avatar) : '';
    }

    public function parent()
    {
        return $this->belongsTo(Comment::class, 'level');
    }

    public function children()
    {
        return $this->hasMany(Comment::class, 'level');
    }
}
