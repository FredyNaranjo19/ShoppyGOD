<div class="container-redes">
<!--------------------------- FACEBOOK -------------------------->
<?php
if ($respuestaRedesSocial != false) {
  
  if ($respuestaRedesSocial["estadoMessenger"] == "habilitado") {
?>

  <a title="Enviar mensaje de Messenger" alt="">
      <div id="fb-root" ></div>
      <script>
        window.fbAsyncInit = function() {
            FB.init({
              xfbml            : true,
              version          : 'v7.0'
            });
          };

          (function(d, s, id) {
          var js, fjs = d.getElementsByTagName(s)[0];
          if (d.getElementById(id)) return;
          js = d.createElement(s); js.id = id;
          js.src = 'https://connect.facebook.net/es_LA/sdk/xfbml.customerchat.js';
          fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));
      </script>
      <!-- Your Chat Plugin code -->
      <div class="fb-customerchat"
          attribution=setup_tool
          page_id="<?php echo $respuestaRedesSocial['id_page'] ?>"
          theme_color="<?php echo $respuestaRedesSocial['color'] ?>"
          logged_in_greeting="<?php echo $respuestaRedesSocial['entrada'] ?>"
          logged_out_greeting="<?php echo $respuestaRedesSocial['salida'] ?>">
      </div>
  </a>
  <?php
    }
  
    if ($respuestaRedesSocial["estadoWhats"] == "habilitado") {
  ?>
  <a href="https://api.whatsapp.com/send?phone=+52<?php echo $respuestaRedesSocial['numero'] ?>&text=<?php echo $respuestaRedesSocial['textoWhats'] ?>" target="_blank">
    <img src="../items/img/whatss.png" title="Enviar mensaje de WhatsApp" alt="">
    <!-- <i class="fa fa-whatsapp"></i> -->
  </a>
  <?php
    }

  }
  ?>
  

</div>