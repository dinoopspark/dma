@extends('layouts.general')

@section('title', 'Profile')

@section('main')


    <div class="row">
        <div class="col-sm-3">
            <label class="control-label" for="name">Name</label>
        </div>

        <div class="col-sm-9">
            {{ $user->name}}
        </div>

    </div>


    <div class="row">
        <div class="col-sm-3">
            <label class="control-label" for="username">Username</label>
        </div>

        <div class="col-sm-9">
            {{ $user->username}}
        </div>
    </div>

    <div class="row">
        <div class="col-sm-3">
            <label class="control-label" for="username">email</label>
        </div>

        <div class="col-sm-9">
            {{ $user->email}}
        </div>
    </div>

    <div class="row">
        <div class="col-sm-3">
            <label class="control-label" for="username">Phone</label>
        </div>

        <div class="col-sm-9">
            {{ $user->phone}}
        </div>
    </div>


    <div class="form-group">
        <div class="col-sm-offset-3 col-sm-9">
            {{ link_to_route('users.edit', 'Edit', array($user->id)) }}
        </div>
    </div>

@stop