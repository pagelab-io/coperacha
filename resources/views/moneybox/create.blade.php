@extends("layouts.content")

@section("page-content")
    <section class="block register" id="register">
        <div class="holder">
            <div class="container-fluid">

                <div class="header-block">
                    <h2>Información</h2>
                </div>

                <div class="content-block">

                    <div class="row">
                        <div class="col-sm-12">
                            <div>Llena por favor los siguientes datos:</div>
                        </div>
                    </div>

                    <form action="#" class="form">

                        <div class="form-group">
                            <label for="">Selecciona la categoría para la alcancía:</label>
                            <div class="radio">
                                <label for="birth"><input id="birth" type="radio" name="category">Cumpleaños</label>
                            </div>
                            <div class="radio">
                                <label for="party"><input id="party" type="radio" name="category">Festejos</label>
                            </div>

                        </div>

                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <input id="name" name="name" type="text" class="form-control" placeholder="Nombre de la alcancía">
                                </div>
                                <div class="form-group">
                                    <input id="company" name="company" type="text" class="form-control" placeholder="Nombre de quién la organiza">
                                </div>
                                <div class="form-group">
                                    <input id="file" name="file" type="file">
                                </div>

                                <div class="form-group">
                                    <textarea id="description" name="description"  class="form-control" rows="4" placeholder="Descripción"></textarea>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <input id="quantity" name="quantity" type="number" class="form-control" placeholder="Cantidad que desea reunir">
                                </div>
                                <div class="form-group">
                                    <input id="ended" name="ended" type="date" class="form-control" placeholder="Fecha límite para reunir los fondos">
                                </div>
                            </div>
                        </div>

                    </form>

                </div>
            </div>
        </div>
    </section>

@endsection

@section('js')

@endsection