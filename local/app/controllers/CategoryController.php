<?php

include app_path() . '/includes/PHPExcel/Classes/PHPExcel.php';
include app_path() . '/includes/Excel.php';

class CategoryController extends \BaseController {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {

        if (!User::hasrole("view_category_list")) {
            return Redirect::to('admin/profile');
        }

        $category = Category::paginate(10);
        return View::make('category.index', compact('category'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create() {

        $form = Category::$category_create_form;

        $form['fields'][] = array(
            'type' => 'hidden',
            'name' => 'created_by',
            'value' => get_current_user_id(),
        );

        $form = FormController::prepare_form($form);
        return View::make('category.create', compact('form'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store() {
        $input = Input::all();

        $validation = Validator::make($input, Category::$rules_category_create);

        if ($validation->passes()) {

            // Create Dynamic Table 
            if (isset($input['field_set'])) {
                $input['table_name'] = 'imp_' . Category::format_table_name($input['title']);
                $fields = Category::read_json($input['field_set']);
                Category::create_table($input['table_name'], $fields);
            }

            $category = Category::create($input);

            return Redirect::route('category.index');
        }

        return Redirect::route('category.create')
                        ->withInput()
                        ->withErrors($validation)
                        ->with('message', 'There were validation errors.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id) {
        if (!User::hasrole('category_edit')) {
            return Redirect::to('admin/profile');
        }

        $category = Category::find($id);
        if (is_null($category)) {
            return Redirect::route('category.index');
        }

        $form = Category::$category_create_form;

        $form['fields'][] = array(
            'type' => 'hidden',
            'name' => 'created_by',
            'value' => get_current_user_id(),
        );


        $form = FormController::prepare_form($form);

        $form['form_id'] = 'category_edit';
        $form['route'] = 'category.update';
        $form['method'] = 'PATCH';
        $form['model'] = $category;

        return View::make('category.edit', compact('form'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id) {
        $input = Input::all();
        $validation = Validator::make($input, Category::$rules_category_update);

        if ($validation->passes()) {
            
            $category = Category::find($id);
            
            // Update Dynamic Table 
            if (isset($input['field_set'])) {
                $input['table_name'] = 'imp_' . Category::format_table_name($input['title']);
                $fields = Category::read_json($input['field_set']);
                Category::create_table($input['table_name'], $fields);
            }

            $category->update($input);

            return Redirect::route('category.edit', $id)
                            ->withInput()
                            ->withErrors($validation);
        }

        return Redirect::route('category.edit', $id)
                        ->withInput()
                        ->withErrors($validation)
                        ->with('message', 'There were validation errors.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id) {
        
    }

    // Custom functions

    public static function ajax_delete($input) {

        if (User::hasrole('category_delete')) {

            $id = $input['model_id'];
            $action = $input['action'];

            if ($action == 'category_delete') {
                Category::find($id)->delete();
                echo true;
                die();
            }
        }
        echo false;
        die();
    }

    public static function ng_get_field_set($id) {
        $fields = Category::get_field_set($id);
        echo json_encode($fields);
        die();
    }

    public static function cold() {

//        $fields = self::read_json();
//        $fields = array(
//            array('Hood', 'nib', 'log'),
//            array('jok', 'yii', 'laravel', 'white'),
//        );
//
//
//        self::export($fields);

        $excelFile = app_path() . '/includes/hitg.xlsx';

        $excel = new Excel($excelFile);
        $content = $excel->toArray();
        echo '<pre>', print_r($content), '</pre>';
        exit();

        $objReader = PHPExcel_IOFactory::createReader('Excel2007');
        $objPHPExcel = $objReader->load($excelFile);

//Itrating through all the sheets in the excel workbook and storing the array data
        foreach ($objPHPExcel->getWorksheetIterator() as $worksheet) {
            $arrayData[$worksheet->getTitle()] = $worksheet->toArray();
        }

        echo '<pre>', print_r($arrayData), '</pre>';
        exit();
    }

    public static function export($export_data) {
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->getActiveSheet()->fromArray($export_data, NULL, 'A1');
        $objPHPExcel->getActiveSheet()->setTitle('sheet 1');
        $objPHPExcel->setActiveSheetIndex(0);

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="01simple.xlsx"');
        header('Cache-Control: max-age=0');

// If you're serving to IE over SSL, then the following may be needed
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
        header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
        header('Pragma: public'); // HTTP/1.0


        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        // $objWriter->save(app_path() . '/includes/hitg.xlsx');
        $objWriter->save('php://output');
    }

}
