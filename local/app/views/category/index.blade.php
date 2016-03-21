@extends('layouts.dashboard')


@section('title', 'Categories')

@section('main')

<div class="right_col" role="main">
    <p>{{ link_to_route('category.create', 'Create category [+]')}}</p>

    @if ($category->count())
    <table class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>Category name</th>
                <th>Created By</th>
                <th>Action</th>
            </tr>
        </thead>

        <tbody>

            @foreach ($category as $cat)
            <tr>
                <td>{{ link_to_route('category.edit', $cat->title, array($cat->id)) }}</td>
                <td>{{ get_user_by_id($cat->created_by) }}</td>
                <td>    
                    <i class="fa fa-trash row-delete" data-action="category_delete" data-id="{{ $cat->id }}"></i>
                </td>
            </tr>
            @endforeach

        </tbody>

    </table>

    @else
    <p>There are no records founds.</p>
    @endif

    <div class="row">
        <div class="col-md-12">
            <div class="pull-right">{{ $category->links(); }}</div>
        </div>
    </div>



</div>


@stop