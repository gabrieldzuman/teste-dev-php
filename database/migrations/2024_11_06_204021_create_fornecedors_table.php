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
        Schema::create(table: 'fornecedors', callback: function (Blueprint $table): void {
            $table->id();
            $table->string(column: 'nome')->nullable();
            $table->string(column: 'nome_empresa')->nullable();
            $table->string(column: 'documento')->unique(); 
            $table->string(column: 'contato')->nullable();
            $table->string(column: 'endereco')->nullable();
            $table->timestamps();
        });
    }    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fornecedors');
    }
};
