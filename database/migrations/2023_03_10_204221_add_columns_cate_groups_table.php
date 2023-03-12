<?php

use App\Models\CateGroup;
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
        Schema::table('cate_groups', function (Blueprint $table) {
            $table->string('reference_name')->after('slug')->nullable();
        });

        $records = CateGroup::all();
        foreach ($records as $record) {
            switch ($record->name) {
                case 'RAM':
                case 'Screen':
                case 'HDD':
                case 'SSD':
                    $record->reference_name = ucfirst(strtolower($record->name)) . 'Group';
                    $record->save();
                    break;
                default:
                    $record->reference_name = $record->name;
                    $record->save();
                    break;
            }
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
};
