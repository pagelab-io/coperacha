function Utils()
{

    /**
     * return a formatted date in YYYY-mm-dd format
     * input: 1990-March-1
     * output: 1990-03-01
     *
     * @param str
     * @returns {string}
     */
    this.formatDate = function (str)
    {
        var dates   = str.split('-');
        var year    = dates[0];
        var month   = dates[1];
        var day     = dates[2];
        return year+"-"+this.getMonth(month)+"-"+this.getDay(day);
    };

    /**
     * Get the month string and return the month in two digits
     * input: March
     * output: 03
     *
     * @param month
     * @return {string}
     */
    this.getMonth = function (month)
    {
        var numberOfMonth = "00";
        switch (month) {
            case "ENERO" : numberOfMonth = "01"; break;
            case "FEBRERO" : numberOfMonth = "02"; break;
            case "MARZO" : numberOfMonth = "03"; break;
            case "ABRIL" : numberOfMonth = "04"; break;
            case "MAYO" : numberOfMonth = "05"; break;
            case "JUNIO" : numberOfMonth = "06"; break;
            case "JULIO" : numberOfMonth = "07"; break;
            case "AGOSTO" : numberOfMonth = "08"; break;
            case "SEPTIEMBRE" : numberOfMonth = "09"; break;
            case "OCTUBRE" : numberOfMonth = "10"; break;
            case "NOVIEMBRE" : numberOfMonth = "11"; break;
            case "DICIEMBRE" : numberOfMonth = "12"; break;
            default: numberOfMonth = "01"; break;
        }
        return numberOfMonth;
    };

    /**
     * Get the day an check if is a one digit number, then return the number in two positions
     * input: 1
     * output: 01
     *
     * @param day
     * @return {string}
     */
    this.getDay = function (day)
    {
        return (day < 10) ? "0"+day : day;
    };

    this.showLoader = function()
    {
        var loader = document.createElement('div');
        loader.className = 'loader';
        document.body.appendChild(loader);
    };

    this.hideLoader = function(){
        var loader = document.getElementsByClassName('loader')[0];
        document.body.removeChild(loader);
    };

    this.showAlert = function(small)
    {
        var alert = null;
        if(small)
            alert = document.getElementById('small-alert-modal-coperacha');
        else
            alert = document.getElementById('alert-modal-coperacha');
        alert.style.display = 'block';
    };

    this.hideAlert = function(small)
    {
        var alert = null;
        if(small)
            alert = document.getElementById('small-alert-modal-coperacha');
        else
            alert = document.getElementById('alert-modal-coperacha');
        alert.style.display = 'none';
    };

    this.setAlertTitle = function(text)
    {
        document.getElementById('alert-title').innerHTML=text;
    };

    this.initAlertEvents = function()
    {
        var _this = this;

        if (document.getElementById('close-alert-1')) {
            document.getElementById('close-alert-1').addEventListener('click', function () {
                _this.hideAlert();
            });
        }
        if (document.getElementById('close-alert-2')) {
            document.getElementById('close-alert-2').addEventListener('click', function () {
                _this.hideAlert();
            });
        }
        if (document.getElementById('close-alert-3')) {
            document.getElementById('close-alert-3').addEventListener('click', function () {
                _this.hideAlert(true);
            });
        }
        if (document.getElementById('close-alert-4')) {
            document.getElementById('close-alert-4').addEventListener('click', function () {
                _this.hideAlert(true);
            });
        }

        document.addEventListener('keyup', function(e){
            if (e.keyCode == 27) {
                if (document.getElementById('alert-modal-coperacha').style.display == 'block' && document.getElementById('login-modal-coperacha').style.display == 'block') {
                    console.log(1);
                    _this.hideAlert();
                }else{
                    if(document.getElementById('login-modal-coperacha').style.display == 'block') {
                        console.log(2);
                        document.getElementById('login-modal-coperacha').style.display = 'none';
                        var element = $.find('.dialog-view');
                        $(element).attr('data-redirect-to', '');
                    } else if(document.getElementById('alert-modal-coperacha').style.display == 'block') {
                        console.log(3);
                        _this.hideAlert();
                    }
                }

                if (document.getElementById('small-alert-modal-coperacha').style.display == 'block') {
                    _this.hideAlert(true);
                }
            }
        });
    };

    this.setValidationError = function(message)
    {
        this.setAlertTitle("Coperacha - Alerta");
        document.getElementById('alert-content').innerHTML="" +
        "<p>Uno de los campos es inválido, verifica que la información es correcta : <br><b>"+message+"<b><p>";
        this.showAlert();
    };

    this.setPaymentCardForm = function()
    {
        this.setAlertTitle("Datos de tarjeta");
        document.getElementById('alert-content').innerHTML = ''+
            '<form id="card-form">'+
                '<span class="card-errors"></span>'+
                '<div class="form-row">'+
                    '<label>'+
                        '<span class="col-xs-12 col-sm-6">Nombre del tarjetahabiente</span>'+
                        '<input class="col-xs-12 col-sm-6" type="text" data-conekta="card[name]" placeholder="Ejemplo: Martín Hernandez" ng-model="card_name"/>'+
                    '</label>'+
                '</div>'+
                '<div class="form-row">'+
                    '<label>'+
                        '<span class="col-xs-12 col-sm-6">Número de tarjeta de crédito/débito</span>'+
                        '<input class="col-xs-12 col-sm-6" type="text" data-conekta="card[number]" placeholder="No. de la tarjeta (16 dígitos)"/>'+
                    '</label>'+
                '</div>'+
                '<div class="form-row">'+
                    '<label>'+
                        '<span class="col-xs-12 col-sm-6" >CVC</span>'+
                        '<input class="col-xs-12 col-sm-6" type="text" size="4" data-conekta="card[cvc]" placeholder="No. CVC (3 dígitos)"/>'+
                    '</label>'+
                    '</div>'+
                    '<div class="form-row">'+
                    '<label>'+
                        '<span  class="col-xs-12 col-sm-6">Fecha de expiración (MM/AAAA)</span>'+
                        '<input class="col-xs-5 col-sm-2" type="text" data-conekta="card[exp_month]" placeholder="01"/>'+
                        '<span  class="col-xs-1 col-sm-1">/</span>'+
                        '<input class="col-xs-5 col-sm-3" type="text"  data-conekta="card[exp_year]" placeholder="2020"/>'+
                    '</label>'+
                '</div>'+
            '</form>';
        this.showAlert();
        Conekta.setPublishableKey('key_H1uvmkmUNYtHN915aFyf4dg'); // dev
        //Conekta.setPublishableKey('key_S9e4ohwobhaSA9cyqzy3YfA'); // prod
    };

    this.isNullOrEmpty = function(value){

        if(typeof value == 'number')
            return value == 0;

        if(typeof value == 'string')
            return value == "";

        if(typeof value == 'object')
            return value == null;

    };

    this.isValidEmail = function(value)
    {
        return /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,4})+$/.test(value);
    };

    this.validLength = function(value, length)
    {
      return value.length == length;
    };

    this.minLength = function(value, length)
    {
        return value.length >= length;
    };

    this.maxLength = function(value, length)
    {
        return value.length <= length;
    };

    this.isValidNumber = function(value)
    {
        return /^[0-9]+([.][0-9]+)?$/.test(value)
    };

    this.isValidDate = function(value)
    {
        return /^\d{2}-\d{2}-\d{4}$/.test(value);
    };

    this.isValidPhone = function(value)
    {
        return /^\d{10}?$/.test(value)
    };

    this.invertirFecha = function(fecha)
    {
        var x = fecha.split('-');
        return x[2]+"-"+x[1]+"-"+x[0];
    };

    this.getLocation = function()
    {
        return window.location;
    }

}
