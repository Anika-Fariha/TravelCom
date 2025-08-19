@extends('layouts.app')
@section('content')
<h2>Travel Posts</h2>

<article>
  <h4>Create a new post</h4>
  <form method="POST" action="{{ route('posts.store') }}">
    @csrf

    <div style="display: flex; gap: 15px; align-items: flex-start;">
      <!-- Title -->
      <label style="flex: 1;">
        Title (optional)
        <input type="text" name="title" value="{{ old('title') }}" style="width:100%;">
      </label>

      <!-- Destination -->
      <label style="flex: 1;">
        Destination (optional)
        <input type="text" name="destination" value="{{ old('destination') }}" placeholder="Cox's Bazar" style="width:100%;">
      </label>

      <!-- Content (wide horizontally, not tall) -->
      <label style="flex: 2;">
        Content
        <textarea name="content" required style="width:100%; height:60px; resize:none;">{{ old('content') }}</textarea>
      </label>
    </div>

    <button type="submit" style="margin-top:15px;">Post</button>
    @error('content')<small style="color:red">{{ $message }}</small>@enderror
  </form>
</article>

@foreach($posts as $post)
<article>
  <header>
    <strong>{{ $post->user->name }}</strong>
    <small> • {{ $post->created_at->diffForHumans() }}</small>
  </header>
  <h5>{{ $post->title }}</h5>
  @if($post->destination)
  <small>Destination: {{ $post->destination }}</small>
  @endif
  <p>{{ $post->content }}</p>

  <form method="POST" action="{{ route('posts.like', $post) }}" style="display:inline">
    @csrf
    <button type="submit">{{ $post->isLikedBy(auth()->user()) ? 'Unlike' : 'Like' }} ({{ $post->likes->count() }})</button>
  </form>

  @can('delete', $post)
  <form method="POST" action="{{ route('posts.destroy', $post) }}" style="display:inline" onsubmit="return confirm('Delete this post?')">
    @csrf @method('DELETE')
    <button type="submit">Delete</button>
  </form>
  @endcan

  <details>
    <summary>Comments ({{ $post->comments->count() }})</summary>
    <ul>
      @foreach($post->comments as $c)
        <li>
          <strong>{{ $c->user->name }}</strong>:
          {{ $c->content }}
          <small> • {{ $c->created_at->diffForHumans() }}</small>
          @if($c->user_id === auth()->id())
          <form method="POST" action="{{ route('comments.destroy', $c) }}" style="display:inline">
            @csrf @method('DELETE')
            <button type="submit">Delete</button>
          </form>
          @endif
        </li>
      @endforeach
    </ul>

    <form method="POST" action="{{ route('posts.comments.store', $post) }}">
      @csrf
      <label>Add a comment
        <input name="content" required>
      </label>
      <button type="submit">Comment</button>
      @error('content')<small style="color:red">{{ $message }}</small>@enderror
    </form>
  </details>
</article>
@endforeach

{{ $posts->links() }}
@endsection
