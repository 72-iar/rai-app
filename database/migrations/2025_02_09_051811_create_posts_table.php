<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->string('title'); // Post title
            $table->enum('type', ['news', 'update', 'task'])->default('news'); // Post type
            $table->text('message'); // Post content
            $table->foreignId('author_id')->constrained('users')->onDelete('cascade'); // User foreign key
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('posts');
    }
};
