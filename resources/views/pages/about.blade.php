@extends("layouts.content")

@section("page-content")
    <section class="block intro2" id="intro">
        <div class="holder">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="header-block">
                            <h2 class="title">¿Qué es Coperacha?</h2>
                        </div>
                        <div class="content-block">
                            <div style="text-align: justify" class="text-justify">
                                <p>Coperacha es un servicio de gestión de dinero comunitario que sirve para hacer regalos o transferencias entre amigos. <br> La recaudación de dinero en efectivo entre amigos para comprar un regalo en común puede ser cansado y conlleva mucho tiempo y energía. Coperacha te permite administrar la recaudación del dinero por medio de Internet sin la necesidad de que una sola persona se encargue personalmente, como suele ocurrir con frecuencia.</p>
                                <p> Coperacha facilita la recaudación de dinero ya que los usuarios pueden crear alcancías virtuales personalizadas con su grupo de amigos, familia o compañeros de trabajo. Una vez recaudado el dinero en <a href="{{url("/")}}">Coperacha.com.mx,</a> lo puedes transferir a la cuenta bancaria que se desee. </p>
                                <p>En este caso, la «web» aplica una comisión por gestión del cinco por ciento sobre el capital que se transfiera. O puedes utilizarlo comprando un regalo en la pagina de nuestros socios comerciales de manera gratis.</p>
                            </div>
                            <br><br>
                            <a class="button btn btn-primary small"
                               ng-click="showModal('/moneybox/create')">Crear mi Alcancía</a>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="video">
                            <div class="embed-responsive embed-responsive-16by9">
                                <iframe class="embed-responsive-item" src="https://player.vimeo.com/video/142285041?title=0&byline=0&portrait=0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
                            </div>
                            <br>
                            <a class="btn-share-fb" href="javascript:void(0)" onclick="shareHowWorks()">
                                <span>Compartir en</span>
                                <img src="images/facebook-logo.png" alt="">
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection