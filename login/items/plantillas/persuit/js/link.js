$(document).on("click", ".btnPDF", function(){

	window.open("");
})


/*======================================================================
=            VALIDACION DE URL PARA HABILITAR BOTON DE PAGO            =
======================================================================*/

$(document).on("change", "#urlLinkComprobante", function(){

  var contenido = $(this).val();

  if (contenido != "") {

    $(".btnSubirPagoLink").prop("disabled", false);

  } else {

    $(".btnSubirPagoLink").prop("disabled", "disabled");

  }

})

/*=====  End of VALIDACION DE URL PARA HABILITAR BOTON DE PAGO  ======*/



/*========================================================
=            GUARDAR COMPROBANTE DE PAGO LINK            =
========================================================*/

document.getElementById("btnLinkComprobante").onclick = function (e) {

	var input = document.createElement('input');
	input.type = 'file';

	input.onchange = e => {
	  files = e.target.files;
	  reader = new FileReader();
	  reader.onload = function () {
	      document.getElementById("viewLinkComprobante").src = reader.result;
	  }
	  reader.readAsDataURL(files[0]);
	  ComprobanteLinkPago();
	}
	input.click();
      
}

function ComprobanteLinkPago(){

    var folio = $("#procesarPagoFolio").val();
    var ImgName = "";

    ImgName = ImgName.concat( "ComprobantePago-" + folio );

    var uploadTask = firebase.storage().ref('comprobantes/' + ImgName).put(files[0]);

      uploadTask.on('state_changed', function (snapshot) {
                  var progress = (snapshot.bytesTransferred / snapshot.totalBytes) * 100;
                  // if (parseFloat(progress) == 100) {
                  // 	// alert("llego");
                  // 	$(".btnGuardarComrpobanteEfectivo").show("slow");
                  // }
                  document.getElementById('DtxtCarga').innerHTML = 'Subiendo: ' + progress + '%';
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

            $("#urlLinkComprobante").val(ImgUrl);

            $(".btnSubirPagoLink").prop("disabled", false);
            // alert("Imagen subida correctamente");
            // document.getElementById('txtCarga').innerHTML = 'Exitoso!';
        });
      });

}

/*=====  End of GUARDAR COMPROBANTE DE PAGO LINK  ======*/

/*================================================================
=            MOSTRAR PDF DE DEPOSITO DE PAGO POR LINK            =
================================================================*/

$(document).on("click", ".btnPDFLink", function(){

  var empresa = $("#procesarEmpresa").val();
  var monto = $("#procesarPagoTotal").val();
  var folio = $("#procesarPagoFolio").val();

  // alert(empresa+" "+monto+" "+folio);
  window.open(GlobalURL+'items/extensiones/TCPDF-master/pdf/deposito.php?emp='+empresa+'&&m0n='+monto+'&&f01i0='+folio);

}) 

/*=====  End of MOSTRAR PDF DE DEPOSITO DE PAGO POR LINK  ======*/
