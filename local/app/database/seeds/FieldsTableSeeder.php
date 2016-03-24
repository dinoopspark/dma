<?php

class FieldsTableSeeder extends Seeder {

    public function run() {


        User::create(array(
            'username' => 'admin',
            'password' => Hash::make('admin321'),
            'email' => 'admin@mail.com',
            'name' => 'Super Admin',
            'phone' => '+91 256 369 99',
            'role' => 'sup_admin',
        ));

        User::create(array(
            'username' => 'manager',
            'password' => Hash::make('manager321'),
            'email' => 'manager@mail.com',
            'name' => 'Sub Admin',
            'phone' => '+91 556 356 99',
            'role' => 'sub_admin',
        ));

        Category::create(array(
            'title' => 'Hit',
            'description' => 'Banjo cornhole seitan viral letterpress. Vinyl beard next level stumptown hammock before they sold out cronut actually sartorial hoodie meh, portland street art skateboard',
            'field_set' => '[{"field_name":"mike","review_file":"1","all_db":"1"},{"field_name":"bio","review_file":"0","all_db":"1"},{"field_name":"Block","review_file":"0","all_db":"0"}]',
            'db_count' => 10,
            'created_by' => 2,
        ));
    }

}
