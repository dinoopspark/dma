@extends('layouts.general')


@section('title', 'Products')

@section('main')

<p>{{ link_to_route('products.create', 'Create Product [+]')}}</p>

@if ($products->count())

<table class="table table-striped table-bordered">
    <thead>
        <tr>
            <th>id</th>
            <th>Product Title</th>
            <th colspan="2">Action</th>
        </tr>
    </thead>

    <tbody>
        
        @foreach ($products as $product)
        <tr>
            <td>{{ $product->id }}</td>
            <td>{{ $product->title }}</td>
            <td>{{ link_to_route('products.edit', 'Edit', array($product->id), array('class' => 'btn btn-info')) }}</td>
            <td>
                {{ Form::open(array('method' => 'DELETE', 'route' => array('products.destroy', $product->id))) }}
                {{ Form::submit('Delete', array('class' => 'btn btn-danger')) }}
                {{ Form::close() }}
            </td>
        </tr>
        @endforeach

    </tbody>

</table>
@else
There are no products
@endif
{{ $products->links(); }}
@endsection