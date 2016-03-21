@extends('layouts.general')


@section('title', 'Edit product')

@section('main')

{{ Form::model($product, array('method' => 'PATCH', 'route' => array('products.update', $product->id), 'class'=>'form-horizontal')) }}
<div class="product-edit">
    <div class="form-group">
        {{ Form::label('title', 'Title', array('class' => 'col-sm-2 control-label')) }}
        <div class="col-sm-10">
            {{ Form::text('title', NULL, array('class' => 'form-control')) }}
        </div>
    </div>

    <div class="form-group">
        {{ Form::label('description', 'Description', array('class' => 'col-sm-2 control-label')) }}
        <div class="col-sm-10">
            {{ Form::textarea('description', NULL, array('class' => 'form-control')) }}
        </div>
    </div>

    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            {{ Form::submit('Save', array('class' => 'btn btn-default')) }}
            {{ link_to_route('products.index', 'Cancel', NULL, array('class' => 'btn btn-default')) }}
        </div>
    </div>
</div>

{{ Form::close() }}

@if ($errors->any())
<ul>
    {{ implode('', $errors->all('<li class="error">:message</li>')) }}
</ul>
@endif

@stop