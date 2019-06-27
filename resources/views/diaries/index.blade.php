<!-- テンプレートエンジンというものがあって、いわゆる書きやすくするもので
その中にbladeっていうテンプレートエンジンを使用している -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="/css/app.css">
    <title>一覧表示画面</title>
</head>
<body>
    @extends('layouts.app')

    @section('title')
    投稿一覧
    @endsection

    @section('content')

    <a href="{{ route('diary.create') }}" class="btn btn-primary btn-block">
    新規投稿
　　</a>

    @foreach ($diaries as $diary)
        <div style="width: 200px; display: inline-block;" class="m-4 p-4 border border-primary">
            <p>編集者：{{ $diary->user->name }}</p>
            <p>{{ $diary->title }}</p>
            <p>{{ $diary->body }}</p>
            <p>{{ $diary->created_at }}</p>

        @if (Auth::check() && Auth::user()->id === $diary->user_id)
                <a class="btn btn-success" href="{{ route('diary.edit', ['id' => $diary->id]) }}">編集</a>
                <form action="{{ route('diary.destroy', ['id' => $diary->id]) }}" method="POST" class="d-inline">
                    @csrf
                    @method('delete')
                    <button class="btn btn-danger">削除</button>
                </form>
        @endif
        <div class=" mt-3 ml-3">
        @if (Auth::check() && $diary->likes->contains(function ($user) {
       return $user->id === Auth::user()->id;
             }))
        <i class="fas fa-heart fa-lg text-danger js-dislike"></i>
        @else
        <i class="far fa-heart fa-lg text-danger js-like"></i>
        @endif
            <input class="diary-id" type="hidden" value="{{ $diary->id }}">
            <span class="js-like-num">{{ $diary->likes->count() }}</span>
        </div>

        </div>
      @endforeach
    @endsection
</body>
</html>
