@extends('layouts.dashboard')


@section('title', 'Users')

@section('main')

<div class="right_col" role="main">
    <p>{{ link_to_route('users.create', 'Create User [+]')}}</p>

    @if ($users->count())
    <table class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>Username</th>
                <th>Name</th>
                <th>Email</th>
                <th>Role</th>
                <th>Action</th>
            </tr>
        </thead>

        <tbody>

            @foreach ($users as $user)
            <tr>
                <td>{{ link_to_route('users.edit', $user->username, array($user->id)) }}</td>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ User::$system_roles[$user->role]['name'] }}</td>
                <td>    
                    <i class="fa fa-trash row-delete" data-id="{{ $user->id }}" data-action="user_delete"></i>
                </td>
            </tr>
            @endforeach

        </tbody>

    </table>

    @else
    <p>There are no users</p>
    @endif
    
    <div class="row">
        <div class="col-md-12">
            <div class="pull-right">{{ $users->links(); }}</div>
        </div>
    </div>
    
    

</div>
@stop