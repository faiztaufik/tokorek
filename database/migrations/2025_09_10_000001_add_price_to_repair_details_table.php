<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('repair_details', function (Blueprint $table) {
            $table->integer('price')->after('service_id');
        });

        // fill existing records
        $repairDetails = \App\Models\RepairDetail::all();
        foreach ($repairDetails as $detail) {
            $detail->price = $detail->service->price;
            $detail->save();
        }
    }

    public function down(): void
    {
        Schema::table('repair_details', function (Blueprint $table) {
            $table->dropColumn('price');
        });
    }
};
