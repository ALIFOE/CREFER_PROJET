<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('admin_notification_emails', function (Blueprint $table) {
            $table->id();
            $table->string('email')->unique();
            $table->boolean('formations')->default(true);
            $table->boolean('orders')->default(true);
            $table->boolean('devis')->default(true);
            $table->boolean('services')->default(true);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('admin_notification_emails');
    }
};
