<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Author;
return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->foreignIdFor(Author::class)->constrained()->cascadeOnDelete();
            $table->string('isbn')->unique();
            $table->text('description')->nullable();
            $table->decimal('price',8,2)->nullable();
            $table->string('genre')->nullable();
            $table->date('published_at')->nullable();
            $table->integer('total_copies')->default(1);
            $table->integer('available_copies')->default(1);
            $table->string('cover_image')->nullable();
            $table->enum('status',['available','not_available'])->default('available');


            $table->timestamps();

            //performance

            $table->index(['title','author_id']);
            $table->index('isbn');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};
