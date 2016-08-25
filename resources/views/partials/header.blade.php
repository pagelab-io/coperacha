<!-- Content Header -->
<header class="content-header">
    <div class="container-fluid">
        <header class="toolbar">
            <div class="left-items">
                @if(!Auth::guest())
                    <a class="back-link" href="{{route('moneybox.dashboard')}}">< Volver a mis alcancías</a>
                @endif
            </div>
            <div class="middle-items">
                <h1>{{ $pageTitle }}</h1>
            </div>
        </header>
    </div>
</header>