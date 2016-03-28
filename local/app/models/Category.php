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
            $field .= "`$value` varchar(255), ";
        }

        $field .= "PRIMARY KEY(id)";
        $sql = "CREATE TABLE `$table_name` ($field)";
        return $sql;
    }

    public static function create_table($table_name, $fields) {

        // sample inputs
        // $table_name = 'col';
        // $fields = self::read_json();
        
        if(!is_array($fields)){
            return false;
        }
        
        $sql = "SHOW TABLES LIKE '$table_name'";
        $check_table = DB::select($sql);

        if (count($check_table)) {
            
            //get existing table column name
            $column_name_sql = "SELECT `COLUMN_NAME` FROM `INFORMATION_SCHEMA`.`COLUMNS` WHERE `TABLE_SCHEMA`='laravel_dma' AND `TABLE_NAME`='$table_name';";
            $column_name_result = DB::select($column_name_sql);
            $column_names = array();
            
            foreach ($column_name_result as $key => $value) {
                $column_names[] = $value->COLUMN_NAME;
            }
            
            $new_columns = array_diff($fields, $column_names);
            $drop_columns = array_diff($column_names, $fields);

            if (count($new_columns)) {

                // Found Changes
                array_walk($new_columns, function(&$value, $key) {
                    $value = "`$value` varchar(255)";
                });

                $new_columns_sql_part = implode(',', $new_columns);
                $alter_table_sql = "ALTER TABLE `$table_name` ADD COLUMN ($new_columns_sql_part)";
                DB::statement($alter_table_sql);
            }

            if (count($drop_columns)) {
                
                $drop_columns = array_diff($drop_columns, array('id'));
                
                foreach ($drop_columns as $value) {
                    $drop_column_sql = "ALTER TABLE $table_name DROP COLUMN `$value`";
                    DB::statement($drop_column_sql);
                }
            }
        } else {
            // no table exist with the name create new one
            $create_table_sql = self::get_table_sql($table_name, $fields);
            DB::statement($create_table_sql);
        }
        
    }

    public static function read_json($json) {

        //sample input 
        //$json = '[{"field_name":"bio","review_file":"0","all_db":"1"},{"field_name":"hiy","review_file":"0","all_db":"0"}]';

        $json_arr = json_decode($json);
        
        if(!is_array($json_arr)){
            return false;
        }
        

        $fields = array();
        foreach ($json_arr as $key => $value) {
            $fields[] = $value->field_name;
        }
        return $fields;
    }

    public static function get_field_set($id) {
        return self::where('id', $id)->select('field_set')->get();
    }

}
