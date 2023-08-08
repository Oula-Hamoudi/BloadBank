<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
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
        Schema::create('notdonatedreasons', function (Blueprint $table) {
            $table->id();
            $table->text('name');
            $table->timestamps();
        });

        DB::table('notdonatedreasons')->insert(
            array(
                'name' => 'Donated By Outside'
         
            )
        );
        DB::table('notdonatedreasons')->insert(
            array(
              
                'name' => 'Blood was not needed'
                
            )
        );
        DB::table('notdonatedreasons')->insert(
            array(
               
                'name' => 'Blood did not cross mathed'
            )
        );
        
        DB::table('notdonatedreasons')->insert(
            array(
                'name' => 'Donor Personal Problem'
            )
        );

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('notdonatedreasons');
    }
};
