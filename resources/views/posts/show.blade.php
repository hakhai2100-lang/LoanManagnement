@extends('layouts.app')

@section('main')

<div class="d-flex justify-content-between align-items-center mb-3">

    <h1>Post Details</h1>

    <a href="{{ route('posts.index') }}" class="btn btn-secondary">
        Back to Post List
    </a>

</div>

<div class="card">

    <div class="card-header">
        <h3 class="card-title">Post Information</h3>
    </div>

    <div class="card-body">

        <table class="table table-bordered">

            <tr>
                <th width="200">Title</th>
                <td>{{ $post->title }}</td>
            </tr>

            <tr>
                <th>Content</th>
                <td>{{ $post->content }}</td>
            </tr>

            <tr>
                <th>Author</th>
                <td>{{ $post->author }}</td>
            </tr>

            <tr>
                <th>Status</th>
                <td>
                    @if($post->status == 'Published')
                        <span class="badge bg-success">
                            Published
                        </span>
                    @else
                        <span class="badge bg-warning">
                            Draft
                        </span>
                    @endif
                </td>
            </tr>

        </table>

    </div>

</div>

@endsection