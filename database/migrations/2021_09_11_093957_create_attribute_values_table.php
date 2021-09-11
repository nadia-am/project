<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAttributeValuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attribute_values', function (Blueprint $table) {
            $table->id();
            $table->string('value');

            $table->foreignId('attribute_id')
                ->constrained('attributes')
                ->onDelete('cascade');

            $table->timestamps();
        });
        Schema::create('attribute_product', function (Blueprint $table) {
            $table->foreignId('product_id')
                ->constrained('products')
                ->onDelete('cascade');

            $table->foreignId('value_id')
                ->constrained('attribute_values')
                ->onDelete('cascade');

            $table->foreignId('attribute_id')
                ->constrained('attributes')
                ->onDelete('cascade');

            $table->primary(['product_id','value_id','attribute_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('attribute_product');
        Schema::dropIfExists('attribute_values');
    }
}
