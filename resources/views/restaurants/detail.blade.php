<!-- layouts.app.blade.phpのレイアウト継承 -->
@extends('layouts.app')

<!-- サイドバーの読み込み -->
@include('common.sidebar')

<!-- メイン部分 -->
@section('title', 'お店詳細')

@section('content_header')
    <h1>{{ $restaurant->name }} 詳細</h1>
@stop

@section('content')
<!-- レストラン詳細情報 -->
<div class="panel panel-default">
    <div>フリガナ: {{ $restaurant->name_katakana }}</div>
    @foreach ($restaurant->categories as $category)
        <div><p>カテゴリー: {{ $category->name }}</p></div>
    @endforeach
    <div>
        <p>写真: </p>
        @if ( isset($restaurant->food_picture))
            <img src="{{ asset('storage/pict/' . $restaurant->food_picture) }}" alt="food_picture" height="200">
        @endif
    </div>
    <div>
        <p>Google Map:
        @if ( isset($restaurant->map_url))
            <a href="{{ $restaurant->map_url }}">{{ $restaurant->map_url }}</a>
        @endif
        </p>
    </div>
    <div><p>レビュー: <?php echo number_format( $restaurant->users()->wherePivot('review', '!=', null)->avg('review'), 1); ?></p></div>
    <div><p>コメント件数: {{ $restaurant->users()->wherePivot('comment', '!=', null)->count() }}</p></div>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="panel-body">
        <table class="table table-striped table-hover restaurant-table">

            <!-- テーブルヘッダ -->
            <thead>
                <th>ユーザー</th>
                <th>レビュー</th>
                <th>コメント</th>
            </thead>

            <!-- テーブル本体 -->
            <tbody>
                @foreach ($restaurant->users as $user)
                        <tr>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->pivot->review }}</td>
                            <td>{{ $user->pivot->comment }}</td>
                        </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div>
        <form action="{{ route('comment', ['id' => $id]) }}" method="POST" enctype="multipart/form-data">
        @csrf
            <div class="form-group mb-3">
                <label for="review">レビュー(最高:５/ 最低:１)<span class="text-danger">*</span></label>
                <select class="form-select" id="review" name="review">
                    <option selected>レビューを選択してください</option>
                    <option value="5">★★★★★</option>
                    <option value="4">★★★★</option>
                    <option value="3">★★★</option>
                    <option value="2">★★</option>
                    <option value="1">★</option>
                </select>
            </div>

            <div class="form-group mb-3">
                <label for="comment">コメント<span class="text-danger">*</span></label>
                <textarea class="form-control" rows="3" id="comment" name="comment"></textarea>
            </div>
            <div>
            <button type="submit" class="btn btn-primary">コメントを追加する</button>
        </div>
    </form>

    <button type="button" class="btn btn-secondary" onclick="location.href='/restaurants'">お店リストに戻る</button>

</div>
@endsection