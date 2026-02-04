<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReadingSessionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reading_sessions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('book_id')->constrained()->onDelete('cascade');
            $table->integer('reading_time_seconds')->default(0)->comment('Duração da leitura em segundos');
            $table->integer('current_page')->nullable()->comment('Página atual onde parou');
            $table->timestamp('started_at')->nullable()->comment('Início da sessão de leitura');
            $table->timestamp('finished_at')->nullable()->comment('Fim da sessão de leitura');
            $table->timestamps();

            $table->index(['user_id', 'book_id', 'created_at']);
            $table->index(['book_id','created_at']);
            $table->index('started_at');            
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reading_sessions');
    }
}
