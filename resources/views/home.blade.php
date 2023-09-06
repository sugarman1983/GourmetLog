<!-- layouts.app.blade.phpのレイアウト継承 -->
@extends('layouts.app')

<!-- サイドバーの読み込み -->
@include('common.sidebar')

<!-- メイン部分 -->
@section('content')
<div>
    <div>
        <div>
            {{ \Carbon\Carbon::now()->format('m月d日') }}
            <p>こんにちは{{ $user->name }}さん</p>
        </div>
        
        <h3>[ What's New ]</h3>
        <table id="restaurants" class="table table-hover text-nowrap">
            <thead>
            </thead>
            <tbody>
                @foreach ($restaurants as $restaurant)
                    <tr>
                        <td><p>{{ $restaurant->updated_at }}</p></td>
                        <td><p>{{ $restaurant->name }}</p></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
