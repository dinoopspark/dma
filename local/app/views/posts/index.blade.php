@extends('layouts.general')


@section('title', 'Posts')

@section('main')

<p>{{ link_to_route('posts.create', 'Create Post [+]')}}</p>

@if ($posts->count())

<table class="table table-striped table-bordered">
    <thead>
        <tr>
            <th>id</th>
            <th>Post Title</th>
            <th colspan="2">Action</th>
        </tr>
    </thead>

    <tbody>
        
        @foreach ($posts as $post)
        <tr>
            <td>{{ $post->id }}</td>
            <td>{{ $post->post_title }}</td>
            <td>{{ link_to_route('posts.edit', 'Edit', array($post->id), array('class' => 'btn btn-info')) }}</td>
            <td>
                {{ Form::open(array('method' => 'DELETE', 'route' => array('posts.destroy', $post->id))) }}
                {{ Form::submit('Delete', array('class' => 'btn btn-danger')) }}
                {{ Form::close() }}
            </td>
        </tr>
        @endforeach

    </tbody>

</table>
@else
There are no posts
@endif
{{ $posts->links(); }}
@endsection