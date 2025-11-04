<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

public function up(): void
{
    Schema::create('projects', function (Blueprint $table) {
        $table->id();
        $table->string('title');
        $table->string('icon')->nullable();
        $table->text('description');
        $table->json('technologies')->nullable();
        $table->string('demo_link')->nullable();
        $table->string('source_code')->nullable();
        $table->timestamps();
    });
}

};
