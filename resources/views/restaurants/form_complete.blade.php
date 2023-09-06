<!-- layouts.app.blade.phpのレイアウト継承 -->
@extends('layouts.app')

<!-- サイドバーの読み込み -->
@include('common.sidebar')

@section('content_header')
    <h1>お店 新規登録 完了</h1>
@stop

<!-- メイン部分 -->
@section('content')

<div>
    <div>
        <h3>完了</h3>
        <p>登録しました</p>

        <a href="/restaurants">お店リストに戻る</a>
    </div>
</div>
@endsection