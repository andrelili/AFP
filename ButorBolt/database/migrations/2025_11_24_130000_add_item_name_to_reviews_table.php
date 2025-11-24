<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('reviews')) {
            return;
        }

        if (!Schema::hasColumn('reviews', 'item_name')) {
            Schema::table('reviews', function (Blueprint $table) {
                $table->string('item_name')->nullable()->after('item_id');
            });
        }

        $products = [
            1 => 'Skandináv kanapé',
            2 => 'Tölgyfa étkezőasztal',
            3 => 'Fa ágykeret',
            4 => 'Irodaszék',
            5 => 'Komód 4 fiók, fehér',
            6 => 'Étkezőszékek (2 db)',
            7 => 'TV-szekrény tölgyből',
            8 => 'Állólámpa',
        ];

        foreach ($products as $id => $name) {
            DB::table('reviews')
                ->where('item_id', $id)
                ->whereNull('item_name')
                ->update(['item_name' => $name]);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (!Schema::hasTable('reviews')) {
            return;
        }

        if (Schema::hasColumn('reviews', 'item_name')) {
            Schema::table('reviews', function (Blueprint $table) {
                $table->dropColumn('item_name');
            });
        }
    }
};
