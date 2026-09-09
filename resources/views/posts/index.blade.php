@extends('layouts.app')

@section('main')

<div class="d-flex justify-content-between align-items-center mb-3">
    <h1>Post List</h1>

    <a href="{{ route('posts.create') }}" class="btn btn-success">
        Create Post
    </a>
</div>

<div class="row mb-3">

    <div class="col-md-6">
        <div class="small-box text-bg-primary">
            <div class="inner">
                <h3>{{ $totalPosts }}</h3>
                <p>Total Posts</p>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="small-box text-bg-success">
            <div class="inner">
                <h3>{{ $publishedPosts }}</h3>
                <p>Published Posts</p>
            </div>
        </div>
    </div>

</div>

<form action="{{ route('posts.index') }}" method="GET">

<div class="row mb-3">

    <div class="col-md-4">
        <input
            type="text"
            name="search"
            class="form-control"
            placeholder="Search Title / Author"
            value="{{ request('search') }}">
    </div>

    <div class="col-md-2">
        <button type="submit" class="btn btn-primary">
            Search
        </button>

        <a href="{{ route('posts.index') }}"
           class="btn btn-secondary">
            Reset
        </a>
    </div>

</div>

</form>

<div class="card">

<div class="card-body">

<table class="table table-bordered table-striped">

<thead>

<tr>
    <th>ID</th>
    <th>Title</th>
    <th>Content</th>
    <th>Author</th>
    <th>Status</th>
    <th width="180">Action</th>
</tr>

</thead>

<tbody>

@forelse($posts as $post)

<tr>

    <td>{{ $post->id }}</td>
    <td>{{ $post->title }}</td>
    <td>{{ $post->content }}</td>
    <td>{{ $post->author }}</td>

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

    <td>

        <a href="{{ route('posts.show', $post->id) }}"
           class="btn btn-info btn-sm">
            View
        </a>

        <a href="{{ route('posts.edit', $post->id) }}"
           class="btn btn-warning btn-sm">
            Edit
        </a>

        <form action="{{ route('posts.destroy', $post->id) }}"
              method="POST"
              class="d-inline">

            @csrf
            @method('DELETE')

            <button type="submit"
                    class="btn btn-danger btn-sm"
                    onclick="return confirm('Delete this post?')">
                Delete
            </button>

        </form>

    </td>

</tr>

@empty

<tr>
    <td colspan="6" class="text-center">
        No Posts Found.
    </td>
</tr>

@endforelse

</tbody>

</table>

@if ($posts->hasPages())

<div class="mt-3">

    {{-- Previous --}}
    @if ($posts->onFirstPage())
        <span>Previous</span>
    @else
        <a href="{{ $posts->previousPageUrl() }}">Previous</a>
    @endif

    &nbsp;

    {{-- Page Numbers --}}
    @for ($i = 1; $i <= $posts->lastPage(); $i++)

        @if ($i == $posts->currentPage())
            <strong>[{{ $i }}]</strong>
        @else
            <a href="{{ $posts->url($i) }}">{{ $i }}</a>
        @endif

        &nbsp;

    @endfor

    {{-- Next --}}
    @if ($posts->hasMorePages())
        <a href="{{ $posts->nextPageUrl() }}">Next</a>
    @else
        <span>Next</span>
    @endif

    <br><br>

    Showing {{ $posts->firstItem() }}
    to {{ $posts->lastItem() }}
    of {{ $posts->total() }} results

</div>

@endif

</div>

</div>

@endsection