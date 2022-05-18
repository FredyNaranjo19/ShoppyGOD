var datos = new FormData();
datos.append("pruebacron", pruebacron);
$.ajax({
    url: '../items/mvc/ajax/dashboard/pruebacron.ajax.php',
    method: "POST",
    data: datos,
    cache: false,
    contentType: false,
    processData: false,
    dataType: "json",
    success: function(){
       
    }
})