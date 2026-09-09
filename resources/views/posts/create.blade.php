@extends('layouts.app')

@section('main')

<div class="d-flex justify-content-between align-items-center mb-3">
    <h1>Create Post</h1>

    <a href="{{ route('posts.index') }}" class="btn btn-secondary">
        Back
    </a>
</div>

<div class="card">

    <div class="card-header">
        <h3 class="card-title">Create New Post</h3>
    </div>

    <form action="{{ route('posts.store') }}" method="POST">

        @csrf

        <div class="card-body">

            <div class="mb-3">
                <label class="form-label">Title</label>

                <input
                    type="text"
                    name="title"
                    class="form-control"
                    value="{{ old('title') }}">
            </div>

            <div class="mb-3">
                <label class="form-label">Content</label>

                <textarea
                    name="content"
                    class="form-control"
                    rows="5">{{ old('content') }}</textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">Author</label>

                <input
                    type="text"
                    name="author"
                    class="form-control"
                    value="{{ old('author') }}">
            </div>

            <div class="mb-3">
                <label class="form-label">Status</label>

                <select
                    name="status"
                    class="form-select">

                    <option value="Published"
                        {{ old('status') == 'Published' ? 'selected' : '' }}>
                        Published
                    </option>

                    <option value="Draft"
                        {{ old('status') == 'Draft' ? 'selected' : '' }}>
                        Draft
                    </option>

                </select>
            </div>

        </div>

        <div class="card-footer">

            <button type="submit" class="btn btn-success">
                Save Post
            </button>

            <a href="{{ route('posts.index') }}"
               class="btn btn-secondary">
                Cancel
            </a>

        </div>

    </form>

</div>

@endsection