$(function(){

    /*setInterval(function(){
        $.ajax({
            type:"post",
            dataType:"json",
            url:"procesaDatos.php",
            data:{"accion":"eliminar-producto"}
        });
    },100)*/

    //TIPO DE PRODUCTO
    $("#btnNuevoTipoProducto").click(function(){
        $.ajax({
            type : "post",
            dataType : 'json',
            data : {
                "accion" : "ingresar-tipoProducto",
                "tipoProducto" : $("#tipoProducto").val(),
                "unidadMedida" : $("#unidadMedida").val()
            },
            url : "procesaDatos.php",
            success : function(resp){
                if(resp.ok){
                    $("#confirmaNuevoTipo").modal('show');
                } else{
                    $("#errorNuevoTipo").modal('show');
                }
            },
            error : function(err){
            }
        });
    });

    //PRODUCTO
    $("#btnNuevoProducto").click(function(){
        if($("#tipo").val() == ""){
            alert("Debe seleccionar un tipo de producto");
            return;
        }

        if($("#nombre").val() == ""){
            alert("Debe digitar un nombre de producto");
            return;
        }

        if($("#descripcion").val() == ""){
            alert("Debe debe digitar una descripcion del producto");
            return;
        }

        if($("#cantidad").val() == ""){
            alert("Debe digitar una cantidad de producto");
            return;
        }

        var frm = $("#frmNuevoProducto");
        $.ajax({
            type : "post",
            dataType : 'json',
            data : frm.serialize()+"&accion=ingresar-producto",
            url : "procesaDatos.php",
            success : function(resp){
                if(resp.ok){
                    $("#confirmaNuevoProducto").modal('show');
                } else{
                    $("#errorNuevoProducto").modal('show');
                }
            },
            error : function(err){
            }
        });
    });

   //USUARIO
    $("#btnLogin").click(function(){
        var form = $("#frmLogin");
        $.ajax({
            type : "post",
            dataType : 'json',
            data : form.serialize()+"&accion=login",
            url : "procesaDatos.php",
            success : function(resp){
                if(resp.ok){
                    window.location.replace("menu-principal.php");
                } else{
                    $("#errorLoginUsuario").modal('show');
                }
            },
            error : function(err){
            }
        });
    });


   $("#btnNuevoUsuario").click(function(){
        //VALIDAR CLAVE
        var clave = $("#clave").val();
        var clave2 = $("#clave2").val();
    if (clave !==clave2){
        alert("Las claves no coinciden");
        return;
    }
    var form = $("#frmNuevoUsuario");
    $.ajax({
        type : "post",
        dataType : 'json',
        data : form.serialize()+"&accion=registro",
        url : "procesaDatos.php",
        success : function(resp){
            if(resp.ok){
                $("#confirmaNuevoUsuario").modal('show');
            } else{
                $("#errorNuevoUsuario").modal('show');
            }
        },
        error : function(err){
        }
    });
   });

});