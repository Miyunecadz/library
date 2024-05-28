<?php

use App\Models\Rent;
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
    Schema::create('rents', function (Blueprint $table) {
      $table->id();
      $table->foreignId('user_id');
      $table->foreignId('book_id');
      $table->date('due_date');
      $table->string('status')->default(Rent::STATUS_PENDING);
      $table->text('reason')->nullable();
      $table->date('return_date')->nullable();
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('rents');
  }
};
