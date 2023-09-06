<!-- layouts.app.blade.phpのレイアウト継承 -->
@extends('layouts.app')

<!-- サイドバーの読み込み -->
@include('common.sidebar')

@section('content_header')
    <h1>お店 編集 完了</h1>
@stop

<!-- メイン部分 -->
@section('content')

<div>
    <div>
        <h3>完了</h3>
        <p>更新しました</p>

        <a href="/restaurants">お店リストに戻る</a>
    </div>
</div>
@endsection