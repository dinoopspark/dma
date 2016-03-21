<?php

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
            Category::create($input);

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
            $category->update($input);
            return Redirect::route('category.index');
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

}
