<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('documents', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('file_path');
            $table->string('file_name');
            $table->bigInteger('file_size')->default(0);
            $table->string('file_type')->nullable();
            $table->string('category')->default('general');
            $table->boolean('is_public')->default(false);
            $table->unsignedBigInteger('uploaded_by')->nullable();
            $table->integer('downloads')->default(0);
            $table->json('tags')->nullable();
            $table->timestamps();

            $table->index(['is_public', 'category']);
            $table->index('created_at');
        });
    }

    public function down()
    {
        Schema::dropIfExists('documents');
    }
};