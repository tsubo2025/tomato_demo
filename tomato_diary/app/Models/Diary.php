<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Diary extends Model
{
    use HasFactory;
    protected $fillable = ['date', 'weather', 'description', 'tomato_count'];
    //1つの日記に対して複数の写真を持つ
    public function photos()
    {
        return $this->hasMany(DiaryPhoto::class);//DiaryPhotoモデルと関連付け連携
    }
}
