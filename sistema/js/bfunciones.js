/****************scrip para agregar una fotografia en nuevo producto*************/

$(document).ready(function(){

    //--------------------- SELECCIONAR FOTO PRODUCTO ---------------------
    $("#foto").on("change",function(){
    	var uploadFoto = document.getElementById("foto").value;
        var foto       = document.getElementById("foto").files;
        var nav = window.URL || window.webkitURL;
        var contactAlert = document.getElementById('form_alert');
        
            if(uploadFoto !='')
            {
                var type = foto[0].type;
                var name = foto[0].name;
                if(type != 'image/jpeg' && type != 'image/jpg' && type != 'image/png')
                {
                    contactAlert.innerHTML = '<p class="errorArchivo">El archivo no es válido.</p>';                        
                    $("#img").remove();
                    $(".delPhoto").addClass('notBlock');
                    $('#foto').val('');
                    return false;
                }else{  
                        contactAlert.innerHTML='';
                        $("#img").remove();
                        $(".delPhoto").removeClass('notBlock');
                        var objeto_url = nav.createObjectURL(this.files[0]);
                        $(".prevPhoto").append("<img id='img' src="+objeto_url+">");
                        $(".upimg label").remove();
                        
                    }
              }else{
              	alert("No selecciono foto");
               $("#img").remove();
              }              
    });
//funcion para remover la foto
    $('.delPhoto').click(function(){
    	$('#foto').val('');
    	$(".delPhoto").addClass('notBlock');
    	$("#img").remove();

      //remueve la foto al darle a la X y la sustituye por la de defecto

      if ($("#foto_actual") && $("#foto_remove")){
        $("#foto_remove").val('img_producto.png');

      }

    });


/****************************************************************************************/
/*************************agregar producto en la lista de produto************************/

$('.addproduct').click(function(event) {
    /* Act on the event */
    event.preventDefault()
    var producto = $(this).attr('product');
    var action = 'infoproducto';

   $.ajax({
       url: 'ajax_agregar_producto.php',
       type: 'POST',
       async: true,
       data: {action:action,producto:producto},

       success : function(response){
/*convertimos el formato json a un objeto,esto viene del procedimiento automatico de la base de datos*/
        if (response != 'error') {
          var info = JSON.parse(response);
          // $('#producto_id').val(info.codproducto);
          // $('.nombre_producto').html(info.descripcion);
          //html del modal que va a agregar los productos y existencia
          $('.body_modal').html('<form action="" method="post" name="form_add_product" id="form_add_product" onsubmit="event.preventDefault(); sendDataProduct();">'+
                                  '<h1><i class="fas fa-cubes" style="font-size: 45pt;"></i><br>Agregar Productos</h1>'+
                                  '<h2 class="nombre_producto">'+info.descripcion+'</h2><br>'+
                                  '<input type="number" name="cantidad" id="texcantidad" placeholder="cantidad de producto"required><br>'+
                                  '<input type="text" name="precio" id="texprecio" placeholder="precio" required>'+
                                  '<input type="hidden" name="producto_id" id="producto_id" value="'+info.codproducto+'" required>'+
                                  '<input type="hidden" name="action" value="addProduct" required>'+
                                  '<div class="alert alertaddproduct"></div>'+
                                  '<button type="submit" class="btn_new"><i class="fas fa-plus"></i> Agregar</button>'+
                                  '<a href="#" class="btn_ok closemodal" onclick="closemodal();"><i class="fas fa-ban"></i> Cerrar</a>'+
                                  '</form>');
                                  
                                  
        }
       },

       error : function(error) {
           console.log(error);


       }

       });

   

       $('.modal').fadeIn();

    });


/****************************************************************************************/
//*******************modal eliminar productos********************************************/
$('.del_producto').click(function(event) {
    /* Act on the event */
    event.preventDefault()
    var producto = $(this).attr('product');
    var action = 'infoproducto';

   $.ajax({
       url: 'ajax_agregar_producto.php',
       type: 'POST',
       async: true,
       data: {action:action,producto:producto},

       success : function(response){
/*convertimos el formato json a un objeto,esto viene del procedimiento automatico de la base de datos*/
        if (response != 'error') {
          var info = JSON.parse(response);
          // $('#producto_id').val(info.codproducto);
          // $('.nombre_producto').html(info.descripcion);
          //html del modal que va a agregar los productos y existencia
          $('.body_modal').html('<form action="" method="post" name="form_del_product" id="form_del_product" onsubmit="event.preventDefault(); delDataProduct();">'+
                                  '<h1><i class="fas fa-cubes" style="font-size: 45pt;"></i><br>Eliminar Productos</h1>'+
                                  '<p>¿Esta seguro de borrar estos Datos?</p>'+
                                  '<h2 class="nombre_producto">'+info.descripcion+'</h2><br>'+
                                  '<input type="hidden" name="producto_id" id="producto_id" value="'+info.codproducto+'" required>'+
                                  '<input type="hidden" name="action" value="delProduct" required>'+
                                  '<div class="alert alertaddproduct"></div>'+
                                  '<a href="#" class="btn_cancel" onclick="closemodal();">Cancelar</a>'+
                                  '<input type="submit" value="Aceptar" class="btn_ok">'+
                                  '</form>');
                                  
                                  
        }
       },

       error : function(error) {
           console.log(error);


       }

       });

   

       $('.modal').fadeIn();

    });

//buscador de los proveedores de la lista_productos

$('#search_proveedor').change(function(e) {
    e.preventDefault();
    var sistema = getUrl();
    location.href = sistema+'buscar_productos.php?proveedor='+$(this).val();
})


});
/****************************************************************************************/
//*******************modal para enviar productos********************************************/

function getUrl() {
    var loc = window.location;
    var pathName = loc.pathname.substring(0, loc.pathname.lastIndexOf('/') + 1);
    return loc.href.substring(0, loc.href.length - ((loc.pathname + loc.search + loc.hash).length - pathName.length));
}






function sendDataProduct(){

  $('.alertaddproduct').html('');

  $.ajax({
       url: 'ajax_agregar_producto.php',
       type: 'POST',
       async: true,
       data: $('#form_add_product').serialize(),//evian los input de todo el objeto del formulario

       success : function(response){
        // es la alerta a la hora de agregar un producto
              if (response == 'error') {
                $('.alertaddproduct').html('<p> error al agregar el producto.</p>')
              }else{
              //si el usuario agrega un nuevo valor de la base de datos bienen unos valores que convertimos en JSON
                var info = JSON.parse(response);
              //esta parte me actualiza de manera automatica al agregar un nuevo valor  los productos
              //sin nesesida de actualizar o recargar la pagina
              //enviamos los datos a las clases row  
                $('.row'+info.producto_id+' .cell_precio').html(info.nuevo_precio);
                $('.row'+info.producto_id+' .cell_existencia').html(info.nueva_existencia);
                //limpiamos los datos que el usuario acabo de mandar a traves del modal
                $('#texcantidad').val('');
                $('#texprecio').val('');
                $('.alertaddproduct').html('<p> producto guardado correctamente.</p>');
              }
       },

       error : function(error) {
                console.log(error);
       }

       });

}
/****************************************************************************************/
//*******************modal para eliminar productos********************************************/
function delDataProduct(){
  var pr = $('#producto_id').val();
  $('.alertaddproduct').html('');

  $.ajax({
       url: 'ajax_agregar_producto.php',
       type: 'POST',
       async: true,
       data: $('#form_del_product').serialize(),//evian los input de todo el objeto del formulario

       success : function(response){

        console.log(response);
        // es la alerta a la hora de agregar un producto
              if (response == 'error') {
                $('.alertaddproduct').html('<p> error al Eliminar el producto.</p>')
              }else{
              
              //esta parte me actualiza de manera automatica al agregar un nuevo valor  los productos
              //sin nesesida de actualizar o recargar la pagina
              //enviamos los datos a las clases row  
                $('.row'+pr).remove();
                $('#form_del_product .btn_ok').remove();
                $('.alertaddproduct').html('<p> producto Eliminado correctamente.</p>');
              }
       },

       error : function(error) {
                console.log(error);
       }

       });

}
function closemodal(){

    $('.alertaddproduct').html('');
    $('#texcantidad').val('');
    $('#texprecio').val('');  
    $('.modal').fadeOut(); 
}

