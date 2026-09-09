@extends('layouts.app')

@section('main')

<div class="d-flex justify-content-between align-items-center mb-3">
    <h1>Edit Post</h1>

    <a href="{{ route('posts.index') }}" class="btn btn-secondary">
        Back
    </a>
</div>

<div class="card">

    <div class="card-header">
        <h3 class="card-title">Edit Post</h3>
    </div>

    <form action="{{ route('posts.update', $post->id) }}" method="POST">

        @csrf
        @method('PUT')

        <div class="card-body">

            <div class="mb-3">
                <label class="form-label">Title</label>

                <input
                    type="text"
                    name="title"
                    class="form-control"
                    value="{{ $post->title }}">
            </div>

            <div class="mb-3">
                <label class="form-label">Content</label>

                <textarea
                    name="content"
                    class="form-control"
                    rows="5">{{ $post->content }}</textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">Author</label>

                <input
                    type="text"
                    name="author"
                    class="form-control"
                    value="{{ $post->author }}">
            </div>

            <div class="mb-3">
                <label class="form-label">Status</label>

                <select
                    name="status"
                    class="form-select">

                    <option value="Published"
                        {{ $post->status == 'Published' ? 'selected' : '' }}>
                        Published
                    </option>

                    <option value="Draft"
                        {{ $post->status == 'Draft' ? 'selected' : '' }}>
                        Draft
                    </option>

                </select>
            </div>

        </div>

        <div class="card-footer">

            <button type="submit" class="btn btn-warning">
                Update Post
            </button>

            <a href="{{ route('posts.index') }}"
               class="btn btn-secondary">
                Cancel
            </a>

        </div>

    </form>

</div>

@endsection