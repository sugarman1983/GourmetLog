<!-- layouts.app.blade.phpのレイアウト継承 -->
@extends('layouts.app')

<!-- サイドバーの読み込み -->
@include('common.sidebar')

@section('content_header')
    <h1>お店 編集 確認</h1>
@stop

<!-- メイン部分 -->
@section('content')

<div>
    <div>
        <h3>確認</h3>

        <div>
            <form action="{{ route('edit.upload', ['id' => $id]) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div>
                    <div class="form-group">
                        <label for="name">店名：</label>
                        {{ $input["name"] }}
                    </div>

                    <div class="form-group">
                        <label for="name_katakana">店名 フリガナ：</label>
                        {{ $input["name_katakana"] }}
                    </div>


                    <div class="form-group mb-3">
                        <label for="category-id">カテゴリー：</label>
                        @foreach ($categories as $category)
                            @if ($category->id === (int)$input["category_id"])
                                {{ $category->name }}
                            @endif
                        @endforeach
                    </div>

                    <div class="form-group mb-3">
                        <label for="thumbnail">料理画像：</label>
                        @if ( isset($image_name))
                            <img src="{{ asset('storage/tmp/' . $image_name) }}" alt="料理画像" height="200">
                        @endif
                    </div>

                    <div class="form-group mb-3">
                        <label for="url">Google Map URL：</label>
                        {{ $input["map_url"] }}
                    </div>

                    <div class="form-group mb-3">
                        <label for="phone">電話番号：</label>
                        {{ $input["phone_number"] }}
                    </div>
                </div>

                <div>
                    <input type="submit" name="back" value="修正する">
                    <input type="submit" value="送信">
                </div>
            </form>
        </div>
    </div>
</div>
@endsection