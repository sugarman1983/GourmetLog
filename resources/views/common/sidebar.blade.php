@section('sidebar')
    <div class="sidebar bg-info vh-100 p-2">
        <a class="navbar-brand" href="{{ url('/home') }}">
            {{ config('app.name', 'Gourmet Log') }}
        </a>
        <hr>
        <p class="text-white">MENU</p>
        <hr>

        <ul class="list-unstyled list-group">
            <li>
                <a href="{{ route('restaurants.index') }}" class="list-group-item-info list-group-item-action text-white" style="text-decoration:none;">お店リスト</a>
            </li>
            <li>
                <a href="{{ route('form.show') }}" class="list-group-item-info list-group-item-action text-white" style="text-decoration:none;">お店 新規登録</a>
            </li>
            <li>
                <a href="{{ route('categories.index') }}" class="list-group-item-info list-group-item-action text-white" style="text-decoration:none;">カテゴリー管理</a>
            </li>
        </ul>

        <ul class="list-unstyled list-group">            
            <li class="nav-item dropdown text-white">
                <a id="navbarDropdown" class="list-group-item-info list-group-item-action text-white nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                    {{ Auth::user()->name }}
                </a>

                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="{{ route('logout') }}"
                        onclick="event.preventDefault();
                            document.getElementById('logout-form').submit();">
                        {{ __('Logout') }}
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </div>
            </li>
        </ul>
    </div>
@endsection