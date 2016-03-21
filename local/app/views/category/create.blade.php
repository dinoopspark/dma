@extends('layouts.dashboard')

@section('title', 'Create new category')

@section('main')

<div class="right_col" role="main">


    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Create new category</h2>
                    <div class="clearfix"></div>
                </div>
                

                @include('generate.form', $form)

            </div>
        </div>
    </div>
    
</div>


@stop