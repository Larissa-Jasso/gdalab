<?php

use App\Models\Commune;
use App\Models\Region;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->string('dni',45)->primary()->nullable(false);
            $table->foreignIdFor(Region::class);
            $table->foreignIdFor(Commune::class);
            $table->string('email',120)->unique()->nullable(false);
            $table->string('name',45)->nullable(false);
            $table->string('last_name',45)->nullable(false);
            $table->string('address',255)->nullable(false);
            $table->enum('status', ['A', 'I', 'trash'])->nullable(false)->default('A');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('customers');
    }
};
