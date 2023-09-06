<!-- layouts.app.blade.phpのレイアウト継承 -->
@extends('layouts.app')

<!-- サイドバーの読み込み -->
@include('common.sidebar')

@section('content_header')
    <h1>お店 新規登録</h1>
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
            <form action="{{ route('form.post') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div>
                    <div class="form-group">
                        <label for="name">店名<span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="店名" value="{{ old('name') }}">
                    </div>

                    <div class="form-group">
                        <label for="name_katakana">店名 フリガナ<span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="name_katakana" name="name_katakana" placeholder="フリガナ" value="{{ old('name_katakana') }}">
                    </div>


                    <div class="form-group mb-3">
                        <div>
                            <label for="category-id">カテゴリー<span class="text-danger">*</span></label>
                        </div>
                        @foreach ($categories as $category)
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" id="category_id" name="category_id" value="{{ $category->id }}" @if( $category->id === (int)old('category_id')) checked @endif>
                            <label for="flexRadioDefault" class="form-check-label">{{ $category->name }}</label>
                        </div>
                        @endforeach
                    </div>

                    <div class="form-group mb-3">
                        <label for="thumbnail">料理画像</label>
                        <input type="file" class="form-control" id="food_picture" name="food_picture" value="{{ old('food_picture') }}">
                    </div>

                    <div class="form-group mb-3">
                        <label for="url">Google Map URL</label>
                        <input type="url" class="form-control" id="url" name="map_url" value="{{ old('map_url') }}">
                    </div>

                    <div class="form-group mb-3">
                        <label for="phone">電話番号</label>
                        <input type="tel" class="form-control" id="phone_number" name="phone_number" value="{{ old('phone_number') }}">
                    </div>

                    <div class="form-group mb-3">
                        <label for="review">レビュー(最高:５/ 最低:１)<span class="text-danger">*</span></label>
                        <select class="form-select" id="review" name="review">
                            <option selected>レビューを選択してください</option>
                            <option value="5" @if(5 === (int)old('review')) selected @endif>★★★★★</option>
                            <option value="4" @if(4 === (int)old('review')) selected @endif>★★★★</option>
                            <option value="3" @if(3 === (int)old('review')) selected @endif>★★★</option>
                            <option value="2" @if(2 === (int)old('review')) selected @endif>★★</option>
                            <option value="1" @if(1 === (int)old('review')) selected @endif>★</option>
                        </select>
                    </div>

                    <div class="form-group mb-3">
                        <label for="comment">コメント<span class="text-danger">*</span></label>
                        <textarea class="form-control" rows="3" id="comment" name="comment">{{ old('comment') }}</textarea>
                    </div>
                </div>

                <div>
                    <button type="submit" class="btn btn-primary">確認画面へ</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection