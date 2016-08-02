@extends("dashboard.layouts.app")

@section("content")
    <div class="container">
        <section class="dashboard">
            <h3 class="title-1">Dashboard</h3>
            <hr>
            <div class="clearfix items">
                <div class="item">
                    <header>
                        <div class="item-title">Total</div>
                    </header>
                    <main>
                        <div class="amount">$ 30 000 <span>.00</span></div>
                    </main>
                </div>
                <div class="item">
                    <header>
                        <div class="item-title">Alcancias</div>
                    </header>
                    <main>
                        <div class="amount">15</div>
                    </main>
                </div>
                <div class="item">
                    <header>
                        <div class="item-title">Total de Usuarios</div>
                    </header>
                    <main>
                        <div class="amount">200</div>
                    </main>
                </div>
                <div class="item">
                    <header>
                        <div class="item-title">Coperacha Promedio</div>
                    </header>
                    <main>
                        <div class="amount">$ 150 <span>.00</span></div>
                    </main>
                </div>
            </div>
        </section>
    </div>
@stop