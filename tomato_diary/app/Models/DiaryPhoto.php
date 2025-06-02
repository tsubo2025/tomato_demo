<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DiaryPhoto extends Model
{
    use HasFactory;
    protected $table = 'tomato_photos';
    protected $fillable = ['diary_id', 'photo_path'];
    //写真は1つの日記に属する
    public function diary()
    {
        return $this->belongsTo(\App\Models\Diary::class); //Diaryモデルと関連付け連携
    }
}
