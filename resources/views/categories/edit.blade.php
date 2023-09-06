<!-- layouts.app.blade.phpのレイアウト継承 -->
@extends('layouts.app')

<!-- サイドバーの読み込み -->
@include('common.sidebar')

@section('content_header')
    <h1>No.{{ $category->id }} カテゴリー 編集</h1>
@stop

<!-- メイン部分 -->
@section('content')

<div>
    <div>
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div>
            <form action="{{ url('/categories/edit/'.$category->id ) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="py-3">
                    <div class="form-group">
                        <label for="name">カテゴリー名<span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ $category->name }}">
                    </div>

                    
                </div>

                <div class="py-3">
                    <button type="button" class="btn btn-secondary" onclick="location.href='/categories'">キャンセル</button>
                    <button type="submit" class="btn btn-primary">修正</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection