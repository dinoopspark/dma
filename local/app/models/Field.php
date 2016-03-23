<?php

class Field extends Eloquent {

    protected $table = 'fields';
    public $timestamps = false;
    protected $guarded = array("id");
    protected $fillable = array(
        "category_id", // To find the category of the specified field
        "field_name", // Table column name
        "review_file", // 0 or 1 to check weather review file checkbox checked or not
        "all_db", // 0 or 1 to check weather All DB checkbox checked or not
    );
}