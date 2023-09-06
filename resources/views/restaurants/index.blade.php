<!-- layouts.app.blade.phpのレイアウト継承 -->
@extends('layouts.app')

<!-- サイドバーの読み込み -->
@include('common.sidebar')

<!-- メイン部分 -->
@section('content')

<!-- レストラン一覧表示 -->
@if (count($restaurants) > 0)
<div>
    <div>
        お店リスト
    </div>

    <form class="form-inline my-2 my-lg-0 ml-2">
        <div class="form-group">
            <input type="search" class="form-control mr-sm-2" name="search"  value="{{request('search')}}" placeholder="キーワードを入力" aria-label="検索...">
        </div>
        <input type="submit" value="検索" class="btn btn-info">
    </form>

    <div class="panel-body">
        <table class="table table-striped table-hover restaurant-table">

            <!-- テーブルヘッダ -->
            <thead>
                <th>ID</th>
                <th>店名</th>
                <th>カテゴリー</th>
                <th>平均レビュー</th>
                <th>コメント件数</th>
                <th>詳細</th>
                <th>編集</th>
                <th>削除</th>
            </thead>

            <!-- テーブル本体 -->
            <tbody>
                @foreach ($restaurants as $restaurant)
                    <tr>
                        <td>{{ $restaurant->id }}</td>
                        <td>{{ $restaurant->name }}</td>
                        @foreach ($restaurant->categories as $category)
                            <td>{{ $category->name }}</td>
                        @endforeach
                        <td><?php echo number_format( $restaurant->users()->wherePivot('review', '!=', null)->avg('review'), 1); ?></td>
                        <td>{{ $restaurant->users()->wherePivot('comment', '!=', null)->count() }}</td>
                        <td>
                            <a href="{{ url('restaurants/detail/'.$restaurant->id) }}" class="btn btn-primary">
                                <i class="fas fa-info-circle"></i> 詳細
                            </a>
                        </td>
                        <td>
                            <a href="{{ url('restaurants/edit/'.$restaurant->id) }}" class="btn btn-primary">
                                <i class="fas fa-edit"></i> 編集
                            </a>
                        </td>
                        <td>
                            <!-- レストラン削除ボタン -->
                                <form action="{{url('/restaurants/delete/'.$restaurant->id)}}" method="POST">
                                    @csrf
                                    <input type="submit" value="削除" class="btn btn-danger" onclick='return confirm("本当に削除してもよろしいですか？");'>
                                </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div>
            {{ $restaurants->links() }}
        </div>
    </div>
</div>
@endif
@endsection