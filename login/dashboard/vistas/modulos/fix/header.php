<nav class="main-header navbar navbar-expand navbar-white navbar-light" style="border-bottom: 0px">

  <ul class="navbar-nav">
    <li class="nav-item">
      <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
    </li>
  </ul>

  <ul class="navbar-nav ml-auto">
    <li id="cerrar_sesion" class="nav-item dropdown">
      <a class="nav-link" data-toggle="dropdown" href="#">
        <i class="fas fa-th-large"></i>
        <span id="notif" class="badge badge-danger navbar-badge notifi" style='visibility: hidden;'>!</span>
      </a>
      <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
        <?php
          if ($_SESSION["rol_principal"] == "Administrador") {
        ?>

          <a href="administracion" class="dropdown-item">
            <i class="fas fa-warehouse mr-2"></i> Administración
          </a>
          
          <a href="mis-compras" class="dropdown-item">
            <i class="fas fa-shopping-basket mr-2"></i> Mis compras <spam id="notif2" class="btn-danger notifibutton" style="color:white; padding: 0 0.15rem; border-radius: 0.15rem;visibility: hidden;">Renovar</spam>
          </a>

        <?php
          }
        ?>

        <a  href="end-close" class="dropdown-item">
          <i class="fas fa-user mr-2"></i> Cerrar Sesión
        </a>
      </div>
    </li>
  </ul>
  
</nav>
<style>
  .notifi{
    animation-name: notification;
    animation-duration: 1.5s;
    animation-iteration-count: infinite;
    animation-direction: alternate;

  }
  @keyframes notification{
    0%{
      transform: scale(1) rotate(0deg);
    }
    25%{
      transform: scale(1.5) rotate(-25deg);
    }
    50%{
      transform: scale(1.5) rotate(25deg);
    }
   
    100%{
      transform: scale(1) rotate(0deg);
    }
  }
  .notifibutton{
    animation-name: notificationbutton;
    animation-duration: 1.5s;
    animation-iteration-count: infinite;


  }
  @keyframes notificationbutton{
    0%{
      transform: scale(1);
    }
    20%{
      transform: scale(1.05);
    }
    40%{
      transform: scale(1);
    }
    60%{
      transform: scale(1.05);
    }
    100%{
      transform: scale(1);
    }
  
  }
</style>