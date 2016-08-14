@extends("layouts.content")

@section("page-content")
    <section class="block register moneybox" id="register">
        <div class="holder">
            <div class="container-fluid">

                <div class="header-block">
                    <div class="title"><h2>Información</h2></div>
                    <div class="stages-control"></div>
                </div>

                <div class="content-block">
                    <form action="#" class="form register moneybox">
                        <div class="form-group">
                            <p class="text-info">Llena por favor los siguientes datos:</p>
                        </div>
                        <div class="form-group category">
                            <label>Selecciona la categoría para la alcancía:</label>
                            <div class="category-items">

                                @foreach($categories as $category)
                                    <div class="radio-item">
                                        <img src="{{$category->path}}" alt="{{$category->name}}">
                                        <label for="birth"><input id="birth" type="radio" name="category"> {{$category->name}}</label>
                                    </div>
                                @endforeach
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
                                    <textarea id="description" name="description"  class="form-control" rows="3" placeholder="Descripción"></textarea>
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

                        <div class="form-group clearfix">
                            <div class="pull-right">
                                <a class="btn btn-primary" href="{{route('moneybox.step-2')}}">Siguiente ></a>
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