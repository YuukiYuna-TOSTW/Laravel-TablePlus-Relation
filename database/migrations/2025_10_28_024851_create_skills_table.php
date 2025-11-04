<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

public function up(): void
{
    Schema::create('skills', function (Blueprint $table) {
        $table->id();
        $table->string('category'); // Technical / Professional
        $table->string('name');
        $table->integer('level'); // misal 90 untuk 90%
        $table->timestamps();
    });
}

};
