<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Comment extends Model
{
    use HasFactory;
    protected $table = 'comments';
    protected $fillable = [
        'id',
        'user_id',
        'post_id',
        'content',
        ];


        /**
         * Get the user that owns the Comment
         *
         * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
         */
        public function user(): BelongsTo
        {
            return $this->belongsTo(User::class, 'user_id', 'id');
        }

        /**
         * Get the post that owns the Comment
         *
         * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
         */
        public function post(): BelongsTo
        {
            return $this->belongsTo(Post::class, 'post_id', 'id');
        }

}
