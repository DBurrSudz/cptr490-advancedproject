<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJobsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create("jobs", function (Blueprint $table) {
            $table->bigIncrements("id");
            $table->string("title");
            $table->longText("description");
            $table->dateTime("date_posted")->nullable();
            $table->boolean("approved")->default(false);
            $table->boolean("paid")->default(false);
            $table->string("rate")->nullable();
            $table
                ->foreignId("user_id")
                ->constrained()
                ->cascadeOnDelete();
            $table
                ->foreignId("admin_id")
                ->nullable()
                ->constrained()
                ->nullOnDelete();
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
        Schema::dropIfExists("jobs");
    }
}
