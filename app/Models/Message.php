<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;



class Message extends Model
{

    protected $fillable = ['content', 'sender_id', 'receiver_id'];

    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function reader()
    {
        return $this->belongsTo(User::class, 'reader_id');
    }
}
