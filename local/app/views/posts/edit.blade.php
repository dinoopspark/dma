@extends('layouts.general')


@section('title', 'Edit post')

@section('main')

{{ Form::model($post, array('method' => 'PATCH', 'route' => array('posts.update', $post->id), 'class'=>'form-horizontal')) }}
<div class="post-edit">
    <div class="form-group">
        {{ Form::label('post_title', 'Title', array('class' => 'col-sm-2 control-label')) }}
        <div class="col-sm-10">
            {{ Form::text('post_title', NULL, array('class' => 'form-control')) }}
        </div>
    </div>

    <div class="form-group">
        {{ Form::label('post_content', 'Post Content', array('class' => 'col-sm-2 control-label')) }}
        <div class="col-sm-10">
            {{ Form::textarea('post_content', NULL, array('class' => 'form-control')) }}
        </div>
    </div>

    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            {{ Form::submit('Save', array('class' => 'btn btn-default')) }}
            {{ link_to_route('posts.index', 'Cancel', NULL, array('class' => 'btn btn-default')) }}
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