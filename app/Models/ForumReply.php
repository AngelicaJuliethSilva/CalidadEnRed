<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ForumReply extends Model
{
    use HasFactory;
    protected $fillable = ['content', 'user_id', 'topic_id'];

    /**
     * Relación con el modelo ForumTopic.
     */
    public function topic()
    {
        return $this->belongsTo(ForumTopic::class, 'topic_id');
    }

    /**
     * Relación con el modelo User.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
