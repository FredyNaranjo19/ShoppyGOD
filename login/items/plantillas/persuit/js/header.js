/*===========================================
=            BUSCADOR DE TIENDA             =
===========================================*/

$(document).ready(function(){
    $(".formBusqueda").keypress(function(e) {
        //no recuerdo la fuente pero lo recomiendan para
        //mayor compatibilidad entre navegadores.
        var code = (e.keyCode ? e.keyCode : e.which);
        var busqueda = $(".formBusqueda").val();


        if(code==13){
            if (busqueda != "") {
				window.location = "index.php?ruta=extraccion&&s36a7r5c43=3&&found789="+busqueda+"&&bhsdh=prod147yt";
			}
        }
    });
});

$(document).on("click",".btnSearchModal", function(){

    var busqueda = $("#SearchModalInput").val();

    if (busqueda != "") {
        window.location = "index.php?ruta=extraccion&&s36a7r5c43=3&&found789="+busqueda+"&&bhsdh=prod147yt";
    }
})

/*=====  End of BUSCADOR DE TIENDA   ======*/

/*=========================================
=            DESGLOSE DE MENU             =
=========================================*/

$(".submenu").click(function(){
    $(this).children(".dropdown-menu").slideToggle();
})

$(".dropdown-menu").click(function(p){
    p.stopPropagation();
})

/*=====  End of DESGLOSE DE MENU   ======*/