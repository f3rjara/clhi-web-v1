<script>
//ALERTA INICIAL CON SWWET ALERT SOBRE BIENVENIDA
function alertainicial()				
{  
    swal({ title: "Bienvenido...!",text: "Herrameintas informáticas UDENAR",icon: "success", timer: 2000, buttons: false,});  
    
}
// OCULTA O MUESTRA FORMULARIOS INICIALES DE CARGA
function formulariosiniciales()
{
    $('#mostrar').show();
    $('#registrar').hide();
    $('.form_login').hide();
    $('[data-toggle="tooltip"]').tooltip(); 
}

// BOTON LLAMAR A MOSTAR LOGIN
function mostarloginindex()
{
    $('.form_login').show(); //muestro mediante id
    $('#mostrar').hide();
    $('#registrar').show();
    $('.form_consulta').hide();
    swal("Completa Todos los campos");
}

// BOTON LLAMAR A MOSTAR CONSUTA NOTAS INDEX
function mostrarconsultaindex()
{
    $('.form_login').hide(); //oculto mediante id	
    $('#mostrar').show();
    $('#mostrar').addClass("btn-success");
    $('#registrar').hide();
    $('.form_consulta').show();
}

function solicita_consulta()
{
    var codigo = $('#codigoe').val();    

    if (codigo == ""){
        $('#codigoe').focus(); 
        swal({ title: "Falta algo...",text: "Debemos conocer quien eres!",icon: "warning", timer: 2000, buttons: false,});  
                    
    }
    else {        
        $.ajax(
        {
            url: 'log/logines.php',
            method: 'POST',
            data: {
                consulta: 1,
                codigoePHP: codigo
            },
            success: function(response) { 
                $("#respuesta").html(response);               
            },
            dataType: 'text'
        }
        );
    }  
        
    
}


function iniciar_sesion()
{
    var usuario = $('#usuario').val();
    var clave = $('#clave').val();   

    if (usuario == "" || clave == "" ){
        $('#usuario').focus(); 
        swal({ title: "Falta algo..!",text: "Debemos conocer quien eres!",icon: "warning", timer: 2000, buttons: false,}); 
    }
    else {        
        $.ajax(
        {
            url: 'log/logindo.php',
            method: 'POST',
            data: {
                consulta: 1,
                usuarioPHP: usuario,
                clavePHP: clave
            },
            success: function(response) { 
                $("#respuesta").html(response);               
            },
            dataType: 'text'
        }
        );
    }  
}

function mostarmenu()
{    
    $('nav').toggleClass('mostrar');    
}

function cerrarmenu()
{
    $('nav').toggleClass('mostrar');    
}



</script>
