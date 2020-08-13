<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->string("itemName",'256');
            $table->string("itemCode","256");
            $table->text("itemImage");
            $table->integer("itemPrice");
            $table->integer("itemWarranty");
            $table->string("itemCategory");
            $table->text("itemBarcode");
            $table->integer("itemQty");
            $table->integer("itemStatus");
            $table->text("itemDescription");
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
        Schema::dropIfExists('items');
    }
}
