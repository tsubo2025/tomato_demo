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
        Schema::create('tomato_diary', function (Blueprint $table) {
            $table->id();
            $table->date('date'); //カレンダーで選択した日付
            $table->string('weather'); //天気
            $table->text('note'); //日記の内容
            $table->integer('tomato_count'); //トマトの個数
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tomato_diary');
    }
};
