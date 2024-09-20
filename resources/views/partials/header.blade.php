<nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
    <div class="container">
        <img class="p-2" src="{{ Vite::asset('resources/images/favicon.svg') }}" alt="logo_BoolBnB" width="40px">
        <a class="navbar-brand" href="{{ url('api/vue-apartments') }}">
            {{ config('app.name', 'Laravel') }}
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Left Side Of Navbar -->
            <ul class="navbar-nav me-auto">

                @auth
                <li>
                    <a class="nav-link" href="{{ route('myapp') }}" aria-current="page">
                        I miei appartamenti
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active mx-2 position-relative" href="{{ route('admin.messages.index') }}">
                        <i class="fa-solid fa-envelope"></i>
                        @if(isset($unreadMessagesCount) && $unreadMessagesCount > 0)
                            <span class="position-absolute top-2 start-100 translate-middle badge rounded-pill bg-danger" style="font-size: 0.6rem;">
                                {{ $unreadMessagesCount }}
                                <span class="visually-hidden">unread messages</span>
                            </span>
                        @endif
                    </a>
                </li>



                <li>
                    <a class="nav-link active mx-2" href="{{ route('admin.apartments.deleteindex') }}"
                        aria-current="page">
                        <i class="fa-solid fa-trash-can"></i>
                    </a>
                </li>
                @endauth
            </ul>

            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav ms-auto">
                <!-- Authentication Links -->
                @guest
                @else
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            {{ Auth::user()->name }} {{ Auth::user()->surname }}
                        </a>
                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="/home">
                                Pagina utente
                            </a>
                            <a class="dropdown-item" href="{{ route('logout') }}"
                                onclick="event.preventDefault();
                                            document.getElementById('logout-form').submit();">
                                {{ __('Esci') }}
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </div>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>
