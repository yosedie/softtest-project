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
        if(!Schema::hasTable('question_book_pdfs')){
        Schema::create('question_book_pdfs', function (Blueprint $table) {
            $table->id();
            $table->string('course_id');
            $table->string('file_name');
            $table->timestamps();
        });
    }
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('question_book_pdfs');
    }
};
