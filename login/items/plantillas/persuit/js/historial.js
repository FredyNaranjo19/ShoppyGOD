/*===========================================================
=            MOSTRAR MODAL DE AGREGAR COMENTARIO            =
===========================================================*/

$(document).on("click", ".btnComentarioProducto", function(){

	var idProducto = $(this).attr("idProducto");

	$("#idProductoComentario").val(idProducto);	

  $("#modalAgregarComentario").modal("show");
  
})

/*=================================================
=            MODAL SUBIR FICHA DE PAGO            =
=================================================*/

$(document).on("click",".btnVaucherEfectivo",function(){
	var folio = $(this).attr("folio");
	var monto = $(this).attr("monto");
	$("#eFolioPago").val(folio);

	$("#nMonto").val(monto);
	$("#nMonto").prop("readonly","readonly");

})

/*===========================================
=            COMPROBANTE DE PAGO            =
===========================================*/

$(document).on("click", "#btnComprobantePagoNew", function(e){

    var input = document.createElement('input');
    input.type = 'file';
    input.accept = ".jpg, .png";

    input.onchange = e => {
        files = e.target.files;

        ImageTools.resize(files[0], {  
            width: 420, // maximum width
            height: 420 // maximum height
        }, function(blob, didItResize) {
            // didItResize will be true if it managed to resize it, otherwise false (and will return the original file as 'blob')
            document.getElementById('previsualizarPagoNew').src = window.URL.createObjectURL(blob);
            // you can also now upload this blob using an XHR.
            ComprobantePago(blob);
        });

    }
    input.click();

})

function ComprobantePago(blob){

    var folio = $("#eFolioPago").val();
    var ImgName = "";

    ImgName = ImgName.concat( "ComprobantePago-" + folio );

    var uploadTask = firebase.storage().ref('comprobantes/' + ImgName).put(blob);

      uploadTask.on('state_changed', function (snapshot) {
                  var progress = (snapshot.bytesTransferred / snapshot.totalBytes) * 100;
                  document.getElementById('txtCargaHistorial').innerHTML = 'Subiendo: ' + progress + '%';
                  if (parseFloat(progress) == 100) {
                  	// alert("llego");

                  	$(".btnGuardarComrpobanteEfectivo").show("slow");
                  }
                  
      },
              // Handle unsuccessful uploads
      function (error) {
                  alert("Hubo un error al subir imagen");

      },
              // Subir link y nombre a base de datos
      function () {
        uploadTask.snapshot.ref.getDownloadURL().then(function (url) {
            ImgUrl = url;

            firebase.database().ref('comprobantesp/' + ImgName).set({
                Name: ImgName,
                Link: ImgUrl
            });

            $("#nTicketCompra").val(ImgUrl);
            // alert("Imagen subida correctamente");
            document.getElementById('txtCargaHistorial').innerHTML = 'Exitoso!';
        });
      });

}

/*================================================
=            LINK DE RASTREO DE ENVIO            =
================================================*/

$(document).on("click","#rastreoLabelFedex", function(){

	var rastreo = $(this).html();

	window.open("https://www.fedex.com/apps/fedextrack/index.html?tracknumbers="+rastreo+"&cntry_code=mx");
})

/*=====  End of LINK DE RASTREO DE ENVIO  ======*/