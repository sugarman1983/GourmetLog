<!-- layouts.app.blade.phpのレイアウト継承 -->
@extends('layouts.app')

<!-- サイドバーの読み込み -->
@include('common.sidebar')

<!-- メイン部分 -->
@section('title', 'カテゴリー管理')

@section('content_header')
    <h1>カテゴリー管理</h1>
@stop

@section('content')
<!-- カテゴリー登録用パネル… -->
<div class="panel-body">
    <!-- バリデーションエラーの表示 -->
    @include('common.errors')

    <!-- 新カテゴリーフォーム -->
    <form action="{{ url('categories/cat_add') }}" method="POST" class="form-horizontal">
        {{ csrf_field() }}

        <!-- カテゴリー名 -->
        <div class="form-group mb-5">
            <label for="name" class="col-sm-3 control-label">新規カテゴリー</label>

            <div class="row">
                <div class="col-sm-6">
                    <input type="text" name="name" id="name" class="form-control">
                </div>

                <!-- カテゴリー追加ボタン -->
                <div class="col-sm-offset-3 col-sm-6">
                    <button type="submit" class="btn btn-primary">
                        <i class="fa fa-plus"></i> 登録
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>

<!-- カテゴリー一覧表示 -->
    <div class="">
        <table id="categories" class="table table table-striped table-hover text-nowrap">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>カテゴリー</th>
                    <th>編集</th>
                    <th>削除</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($categories as $category)
                    <tr>
                        <td>{{ $category->id }}</td>
                        <td>{{ $category->name }}</td>
                        <td>
                            <a href="{{ url('categories/edit/'.$category->id) }}" class="btn btn-primary">
                                <i class="fas fa-edit"></i> 編集
                            </a>
                        </td>
                        <td>
                            <form action="{{url('categories/delete/'.$category->id)}}" method="POST">
                                @csrf
                                <input type="submit" value="削除" class="btn btn-danger" onclick='return confirm("本当に削除してもよろしいですか？");'>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div>
            {{ $categories->links() }}
        </div>
    </div>
@endsection