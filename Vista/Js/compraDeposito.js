$(document).ready(function () {
  localStorage.setItem("arregloCancelar", JSON.stringify([]));//Se inicializa el arreglo vacio en el localstorage
  //Lógica botones Cancelar
  $(".cancelar").click(function (e) {
    e.preventDefault();
    var iditem = $(this).attr('id');//Se obtiene el idcompraitem
    arregloCancelar = JSON.parse(localStorage.getItem("arregloCancelar"));//Se obtiene el arreglo del local storage 
    arregloCancelar.push(iditem);//Se le agrega el idcompraitem
    localStorage.setItem("arregloCancelar", JSON.stringify(arregloCancelar));//Se carga de nuevo al local storage
    $("#fila_" + iditem).css("background-color", "FF7A7A");//Se cambia el color de la fila que contiene al item cancelado
    var boton = $(this);
    //Se crea el boton revertir
    var botonRevertir = $('<button>', {
      class: 'btn btn-info revertir',
      html: '<i class="bi bi-arrow-counterclockwise"></i>',
      //Logica de click del boton revertir
      click: function () {
        arregloCancelar = JSON.parse(localStorage.getItem("arregloCancelar"));//Obtiene el arreglo de idcompraitems cancelados
        indice = arregloCancelar.indexOf(iditem);//Se busca el idcompraitem del boton cancelar clickeado
        if (indice != -1) {//Si está en el arreglo (siempre estará ya que se agrega al clickear cancelar, y el boton revertir no aparece si no se clickea el boton cancelar)
          arregloCancelar.splice(indice, 1);//Lo quita del arreglo
          localStorage.setItem("arregloCancelar", JSON.stringify(arregloCancelar));//Se carga de nuevo el arreglo de idcompraitems al local storage
        }
        boton.show();//Muestra nuevamente el boton cancelar
        botonRevertir.hide();//Esconde el boton revertir
        $("#fila_" + iditem).css("background-color", "white");//Cambia el color a la fila
      }
    })
    boton.parent().append(botonRevertir);//Se agrega el boton revertir al DOM
    boton.hide();//Se esconde el boton cancelar
  }
  );
  // Lógica Procesar compra
  $('#enviar').click(function () { // Manejador de evento click
    arregloCancelar = localStorage.getItem("arregloCancelar");
    $.ajax({
      url: "../compra/accionVerCompra.php",
      method: "POST",
      data: {
        procesarVenta: arregloCancelar,
        idcompra: $("#respuesta").attr('class')
      },
      success: function (response) {
        $("#successModal").modal("show");
      }
    })
  });

  $(document).ready(function () {
    $('.entregado').click(function (event) {
      event.preventDefault();
      var idCompra = $(this).data('id');
      $.ajax({
        url: 'accionVerCompra.php', // URL del servidor
        type: 'POST', // Método de solicitud
        data: { idcompraEnviar: idCompra }, // Datos a enviar
        success: function (response) {
          $("#successModal").modal("show");
        }
      })
    });
  });

  $('#successModal').on('hidden.bs.modal', function () {
    window.history.back();
  });

});