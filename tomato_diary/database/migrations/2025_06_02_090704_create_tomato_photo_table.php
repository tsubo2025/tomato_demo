<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tomato_photo', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tomato_diary_id')->constrained('tomato_diary');//tomato_diaryテーブルのidを参照,関連付け

            $table->onDelete('cascade');//日記が削除されたら写真も削除される
            $table->string('photo_path');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tomato_photo');
    }
};
