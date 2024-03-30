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
        Schema::create('movies', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('avatar')->nullable();
            $table->string('name_call')->nullable();
            $table->foreignId('studio_id')->constrained('studios');
            $table->date('date_aired');
            $table->foreignId('status_id')->constrained('statuses');
            $table->float('scores')->nullable();
            $table->float('rating')->nullable();
            $table->integer('duration')->nullable();
            $table->foreignId('quality_id')->constrained('qualities');
            $table->integer('views')->nullable();
            $table->integer('vote')->nullable();
            $table->integer('star')->nullable();
            $table->foreignId('type_id')->constrained('film_formats');
            $table->boolean('isDelete')->default(false);
            $table->timestamps();
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('movies');
    }
};
