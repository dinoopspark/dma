<?php

class Category extends Eloquent {

    protected $table = 'category';
    protected $guarded = array("id");
    protected $fillable = array(
        "title", // tile for the category
        "description", // description for the category
        "field_set", // json string containg the column name and other attributes
        "db_count", // Quantity of sample DB
        "created_by", // User id
    );
    public static $category_create_form = array(
        'form_id' => 'create_category',
        'route' => 'category.store',
        'submit' => 'Submit',
        'cancel' => true,
        'fields' => array(
            array(
                'type' => 'text',
                'label' => 'DB list name',
                'name' => 'title',
            ),
            array(
                'type' => 'textarea',
                'label' => 'Description',
                'name' => 'description',
            ),
            array(
                'type' => 'text',
                'label' => 'Quantity of sample DB',
                'name' => 'db_count',
            ),
            array(
                'type' => 'html',
                'content' => '<fields ng-repeat="(key, field) in fields" itemset="fields" item="field" key="key"></fields>
                                <div class="col-md-offset-3 col-md-6 col-sm-6 col-xs-12">
                                <input type="hidden" name="field_set" value="{{fields}}">
                                <button type="button" ng-click="addField()" class="btn btn-default">(+)</button>
                              </div>',
            ),
        ),
    );
    
    public static $rules_category_create = array(
        'title' => 'required|unique:category'
    );
    public static $rules_category_update = array(
        'title' => 'required|unique:category,id'
    );

    public static function format_table_name($title) {
        $table_name = strtolower($title);
        $table_name = preg_replace('/[\W]+/i', '_', $table_name);
        return $table_name;
    }

    public static function get_table_sql($title, array $fields) {

        $table_name = self::format_table_name($title);

        $field = "id int(11) NOT NULL AUTO_INCREMENT, ";
        foreach ($fields as $value) {
            $field .= "$value varchar(255), ";
        }

        $field .= "PRIMARY KEY(id)";
        $sql = "CREATE TABLE $table_name ($field)";
        return $sql;
    }

    public static function get_field_set($id) {
        return self::where('id', $id)->select('field_set')->get();
        
    }

}
