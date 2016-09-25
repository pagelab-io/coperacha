<html>
    <head>
        <link href="{{asset('/css/coperacha.css')}}" rel="stylesheet">
    </head>
    <body>
        <div class="popup-wrapper" id="alert-modal-coperacha" style="display: block;">
            <div class="alert-modal">

                <!-- header -->
                <div class="popup-header">
                    <span id="alert-title">Confirmación de pago por @if($method=="oxxo") OXXO @else SPEI @endif</span>
                </div>
                <!-- body -->
                <div class="popup-body">
                    <div class="email-login">
                        <div id="alert-content">

                            @if($method=="oxxo")
                                <p>Se ha generado un nuevo cargo, puedes ir a tu tienda OXXO mas cercana y hacer tu pago con los siguientes datos:</p>
                                <br>
                                <img src="https://s3.amazonaws.com/cash_payment_barcodes/{{$url}}">
                                <br>
                                <span>{{$barcode}}</span>
                                <br><br>
                                <span class="info-alert">Nota: al realizar tu pago, recibirás un correo de confirmación de pago</span>
                            @else
                                <p>Se ha generado un nuevo cargo, puedes ir a realizar tu pago con los siguientes datos:</p>
                                <br>
                                <span> No. Clabe: {{$clabe}}</span>
                                <br><br>
                                <span class="info-alert">Nota: al realizar tu pago, recibirás un correo de confirmación de pago</span>
                            @endif
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </body>
</html>