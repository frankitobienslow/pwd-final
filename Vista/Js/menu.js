
    function RealizaMenu(valor){
        var parametros = {
                "menurol" : valor
        };
        $.ajax({
                data:  parametros,
                url:   '../estructura/accionEstructura.php',
                type:  'post',
                success:  function (response) {
                        $("#resultadoMenu").html(response);
                }
        });
    };
