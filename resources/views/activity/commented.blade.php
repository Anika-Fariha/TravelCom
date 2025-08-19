@extends('layouts.app')
@section('content')
<h2>Posts I Commented On</h2>
@forelse($posts as $post)
  <article>
    <strong>{{ $post->user->name }}</strong> • {{ $post->created_at->diffForHumans() }}
    <h5>{{ $post->title }}</h5>
    <p>{{ $post->content }}</p>
  </article>
@empty
  <p>You haven’t commented on any posts yet.</p>
@endforelse
{{ $posts->links() }}
@endsection
