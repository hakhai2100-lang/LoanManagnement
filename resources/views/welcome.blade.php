@extends('layouts.app')

@section('main')

<div class="card">

    <div class="card-header">
        <h3 class="card-title">Laravel Assignment</h3>
    </div>

    <div class="card-body">

        <h4>Customer Module</h4>

        <a href="{{ route('customers.index') }}" class="btn btn-primary">
            Customer List
        </a>

        <a href="{{ route('customers.create') }}" class="btn btn-success">
            Create Customer
        </a>

        <hr>

        <h4>Post Module</h4>

        <a href="{{ route('posts.index') }}" class="btn btn-primary">
            Post List
        </a>

        <a href="{{ route('posts.create') }}" class="btn btn-success">
            Create Post
        </a>

    </div>

</div>

@endsection