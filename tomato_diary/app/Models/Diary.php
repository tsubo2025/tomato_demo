<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Diary extends Model
{
    use HasFactory;
    protected $table = 'tomato_diary';
    protected $fillable = ['date', 'weather', 'note', 'tomato_count'];

    protected $casts = [
        'date' => 'datetime',
    ];

    //1つの日記に対して複数の写真を持つ
    public function photos()
    {
        return $this->hasMany(DiaryPhoto::class, 'diary_id'); //DiaryPhotoモデルと関連付け連携
    }
}
