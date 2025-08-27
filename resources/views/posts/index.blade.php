@extends('layouts.app')

@section('content')
<div class="container py-4">

  <h2 class="mb-4 text-center">🌍 Travel Posts</h2>

  <!-- Create Post -->
  <article class="card p-4 mb-5 shadow-sm">
    <h4 class="mb-3">✏️ Create a new post</h4>
    <form method="POST" action="{{ route('posts.store') }}" enctype="multipart/form-data">
      @csrf

      <div style="display: flex; gap: 15px; flex-wrap: wrap;">
        <!-- Title -->
        <label style="flex:1; min-width:200px">
          Title 
          <input type="text" name="title" value="{{ old('title') }}" class="form-control">
        </label>

        <!-- Destination -->
        <label style="flex:1; min-width:200px">
          Destination 
          <input type="text" name="destination" value="{{ old('destination') }}" class="form-control">
        </label>

        <!-- Content -->
        <label style="flex:2; min-width:300px">
          Content
          <textarea name="content" required class="form-control" rows="3" style="resize:none;">{{ old('content') }}</textarea>
        </label>

        <!-- Image -->
        <label style="flex:1; min-width:200px">
          Image (optional)
          <input type="file" name="image" class="form-control">
        </label>
      </div>

      <button type="submit" class="btn btn-primary mt-3">Post</button>
      @error('content')<small class="text-danger">{{ $message }}</small>@enderror
    </form>
  </article>

<!-- Posts Loop -->
@foreach($posts as $post)
<article class="card mb-4 shadow-sm">
  <div class="card-body">

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-2">
      <strong>{{ $post->user->name }}</strong>
      <small class="text-muted">{{ $post->created_at->diffForHumans() }}</small>
    </div>

    <!-- Title -->
    @if($post->title)
      <h5 class="card-title">{{ $post->title }}</h5>
    @endif

    <!-- Destination -->
    @if($post->destination)
      <p class="text-muted mb-2">📍 Destination: {{ $post->destination }}</p>
    @endif

    <!-- Content -->
    <p class="card-text mb-3">{{ $post->content }}</p>

    @if($post->image)
      <div class="mb-3">
        <<img src="{{ $post->image_url }}" >
" 
            alt="Post Image" 
            style="
              width: 100%;       /* make it full width of the card */
              max-width: 100%;   /* ensure it doesn't overflow */
              height: auto;      /* maintain aspect ratio */
              display: block;    /* remove inline spacing */
              margin: 0 auto;    /* center if smaller */
              border-radius: 8px;
            ">
      </div>
    @endif


    <!-- Like & Delete -->
    <div class="mb-2 d-flex gap-2">
      <form method="POST" action="{{ route('posts.like', $post) }}" style="display:inline">
        @csrf
        <button type="submit" class="btn btn-sm btn-outline-primary">
          {{ $post->isLikedBy(auth()->user()) ? '💔 Unlike' : '❤️ Like' }} ({{ $post->likes->count() }})
        </button>
      </form>

      @can('delete', $post)
      <form method="POST" action="{{ route('posts.destroy', $post) }}" style="display:inline" onsubmit="return confirm('Delete this post?')">
        @csrf @method('DELETE')
        <button type="submit" class="btn btn-sm btn-outline-danger">🗑️ Delete</button>
      </form>
      @endcan
    </div>

    <!-- Comments -->
    <details>
      <summary class="mb-2">💬 Comments ({{ $post->comments->count() }})</summary>
      <ul class="list-unstyled ps-3">
        @foreach($post->comments as $c)
          <li class="mb-1 border-start ps-2">
            <strong>{{ $c->user->name }}</strong>: {{ $c->content }}
            <small class="text-muted"> • {{ $c->created_at->diffForHumans() }}</small>
            @if($c->user_id === auth()->id())
              <form method="POST" action="{{ route('comments.destroy', $c) }}" style="display:inline">
                @csrf @method('DELETE')
                <button type="submit" class="btn btn-sm btn-link text-danger">Delete</button>
              </form>
            @endif
          </li>
        @endforeach
      </ul>

      <!-- Add Comment -->
      <form method="POST" action="{{ route('posts.comments.store', $post) }}" class="mt-2">
        @csrf
        <div class="input-group">
          <input name="content" required class="form-control" placeholder="Write a comment...">
          <button type="submit" class="btn btn-success">Comment</button>
        </div>
        @error('content')<small class="text-danger">{{ $message }}</small>@enderror
      </form>
    </details>

  </div>
</article>
@endforeach
