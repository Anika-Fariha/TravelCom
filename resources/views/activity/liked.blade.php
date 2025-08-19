@extends('layouts.app')
@section('content')
<h2>Posts I Liked</h2>
@forelse($posts as $post)
  <article>
    <strong>{{ $post->user->name }}</strong> • {{ $post->created_at->diffForHumans() }}
    <h5>{{ $post->title }}</h5>
    <p>{{ $post->content }}</p>
  </article>
@empty
  <p>You haven’t liked any posts yet.</p>
@endforelse
{{ $posts->links() }}
@endsection
