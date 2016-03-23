<?php

class MarkTableSeeder extends Seeder {

    public function run() {

        Schema::table('marks', function($table) {
            $table->increments('id');
            $table->integer('category_id');
            $table->char('field_name', 255);
            $table->tinyInteger('review_file', 2);
            $table->tinyInteger('all_db', 2);
        });
    }

}
