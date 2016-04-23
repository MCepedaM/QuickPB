@extends('admin.templates.main')
@section('title', 'Pagos')

@section('content')
<div class="row">
<div class="col-md-6 col-md-offset-3">
  <!-- panel facturacion -->
  <div class="panel panel-default">     
    <!-- Default panel contents -->
    <div class="panel-heading">Datos de Pago</div>
    <div class="panel-body">
      {!! Form::open(['route'=> 'pays.payment', 'id'=>'card-form', 'method' => 'POST', 'class' => 'login']) !!}

      <!--form action="" method="POST" id="card-form"-->
        <span class="card-errors"></span>
        <div class="form-row">
          <label>
            <span>Nombre del tarjetahabiente</span>
            <input type="text" class="form-control" name="name" size="20" data-conekta="card[name]"/>
          </label>
        </div>
        <div class="form-row">
          <label>
            <span>Número de tarjeta de crédito</span>
            <input type="text" class="form-control" size="20" name="number" data-conekta="card[number]" value="4242424242424242" />
          </label>
        </div>
        <div class="form-row">
          <label>
            <span>CVC</span>
            <input type="text" class="form-control" size="4" name="cvc" data-conekta="card[cvc]"/>
          </label>
        </div>        
          <div class="form-row">
            <label>
              <span>Fecha de expiración (MM/AAAA)</span>  
              <div class="form-inline">
                <input type="text" class="form-control" size="2" name="exp_month" data-conekta="card[exp_month]"/>          
                <span>/</span>
                <input type="text" class="form-control" size="4" name="exp_year" data-conekta="card[exp_year]"/>
              </div>
           </label>             
          </div>                    
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
              <button type="submit" class="btn btn-default"><i class="fa fa-credit-card" aria-hidden="true"></i> Pagar </button>
            </div>
        </div>
      <!--/form-->

      {!! Form::close() !!}
    </div>
  </div>
</div>
</div>
<!-- Scripts de conekta -->
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script type="text/javascript" src="https://conektaapi.s3.amazonaws.com/v0.3.2/js/conekta.js"></script>

<script type="text/javascript">
 
 // Conekta Public Key
  Conekta.setPublishableKey('key_O814sePy3koMWXxtU8CHsDQ');
 
 // Aqui se envia y valida el token.
$(function () {
  $("#card-form").submit(function(event) {
    var $form = $(this);

    // Previene hacer submit más de una vez
    $form.find("button").prop("disabled", true);
    Conekta.token.create($form, conektaSuccessResponseHandler, conektaErrorResponseHandler);
   
    // Previene que la información de la forma sea enviada al servidor
    return false;
  });
});


var conektaSuccessResponseHandler = function(token) {
  var $form = $("#card-form");

  /* Inserta el token_id en la forma para que se envíe al servidor */
  $form.append($("<input type='hidden' name='conektaTokenId'>").val(token.id));
 
  /* and submit */
  $form.get(0).submit();
};


var conektaErrorResponseHandler = function(response) {
  var $form = $("#card-form");
  
  /* Muestra los errores en la forma */
  $form.find(".card-errors").text(response.message);
  $form.find("button").prop("disabled", false);
};

</script>

@endsection