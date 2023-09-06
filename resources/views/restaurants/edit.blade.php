<!-- layouts.app.blade.phpのレイアウト継承 -->
@extends('layouts.app')

<!-- サイドバーの読み込み -->
@include('common.sidebar')

@section('content_header')
    <h1>お店 編集</h1>
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
            <form action="{{ url('/restaurants/edit/'.$restaurant->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div>
                    <div class="form-group">
                        <label for="name">店名<span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="店名" value="{{ $restaurant->name }}">
                    </div>

                    <div class="form-group">
                        <label for="name_katakana">店名 フリガナ<span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="name_katakana" name="name_katakana" placeholder="フリガナ" value="{{ $restaurant->name_katakana }}">
                    </div>


                    <div class="form-group mb-3">
                        <div>
                            <label for="category-id">カテゴリー<span class="text-danger">*</span></span></label>
                        </div>
                        @foreach ($categories as $category)
                        <div class="form-check form-check-inline">
                            @if ($restaurant->categories->contains($category->id))
                            <input class="form-check-input" type="radio" name="category_id" value="{{ $category->id }}" checked>
                            <label for="flexRadioDefault" class="form-check-label">
                                {{ $category->name }}
                            </label>
                            @else
                            <input class="form-check-input" type="radio" name="category_id" value="{{ $category->id }}">
                            <label for="flexRadioDefault" class="form-check-label">
                                {{ $category->name }}
                            </label>
                            @endif
                        </div>
                        @endforeach
                    </div>

                    <div class="form-group mb-3">
                        <label for="thumbnail">写真</label>
                        <div>
                            @if ( isset($restaurant->food_picture))
                                <img src="{{ asset('storage/pict/' . $restaurant->food_picture) }}" alt="food_picture" height="200">
                            @endif
                        </div>
                        <input type="file" class="form-control" id="food_picture" name="food_picture">
                    </div>

                    <div class="form-group mb-3">
                        <label for="url">Google Map URL</label>
                        @if ( isset($restaurant->map_url))
                            <input type="url" class="form-control" id="url" name="map_url" value="{{ $restaurant->map_url }}">
                        @else
                            <input type="url" class="form-control" id="url" name="map_url">
                        @endif
                    </div>

                    <div class="form-group mb-3">
                        <label for="phone">電話番号</label>
                        @if ( isset($restaurant->phone_number))
                            <input type="tel" class="form-control" id="phone" name="phone_number" value="{{ $restaurant->phone_number }}">
                        @else
                            <input type="tel" class="form-control" id="phone" name="phone_number">
                        @endif
                    </div>
                </div>

                <div>
                    <button type="button" class="btn btn-secondary" onclick="location.href='/restaurants'">キャンセル</button>
                    <button type="submit" class="btn btn-primary">確認画面へ</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection