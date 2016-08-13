@extends("layouts.master")

@section("content")
    <!-- Content Header -->
    <header class="content-header">
        <div class="container-fluid">
            <h1>{{ $pageTitle }}</h1>
        </div>
    </header>

    @yield("page-content")

@endsection