<div class="login-box">
  <div class="login-logo">
    <a href="./"><b>Yira</b></a>
  </div>
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">

      <form action="#" method="POST">

        <div class="input-group mb-3">
          <input type="email" class="form-control" name="emailDashboard" placeholder="Email">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" class="form-control" name="passwordDashboard" placeholder="Password">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-8">
          </div>

          <div class="col-4">
            <button type="submit" class="btn btn-primary btn-block">Iniciar</button>
          </div>
        </div>
        <?php
          $iniciar = new ControladorUsuarios();
          $iniciar -> ctrIngresarDashboard();
        ?>
      </form>

    </div>
  </div>
</div>