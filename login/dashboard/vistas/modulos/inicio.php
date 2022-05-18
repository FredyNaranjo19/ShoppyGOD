<script>
    console.log("Inicio");
</script>
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-9">
          <!-- <h1 style="">
            ¡Bienvenido a!
          </h1>   -->
          <h1>¡Bienvenido a! <spam class="textbienvenida"><?php echo $_SESSION["nombreEmpresa_dashboard"] ?></spam></h1>
        </div>
        <div class="col-sm-2">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="inicio">Inicio</a></li>
          </ol>
        </div>
      </div>
    </div>
  </section> 
  
  <section class="content">
    <div class="container-fluid">
        <div class="row">

            

          <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box2">
              <span class="info-box-icon2"><i class="fas fa-gifts"></i></span>

              <div class="info-box-content2">
                <span class="info-box-text2">Total Productos</span>
                <?php
                  $item = "id_empresa";
                  $valor = $_SESSION["idEmpresa_dashboard"];

                  $respuesta = Controladorinicio::ctrMostrartotalproductos($item, $valor);
                ?>
                <span class="info-box-number2"style="color:#00b4d8ff;"><?php echo $respuesta[0]; ?></span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          
          
          <!-- /.col -->
          <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box2">
              <span class="info-box-icon2"><i class="fas fa-shopping-bag"></i></span>

              <div class="info-box-content2">
                <span class="info-box-text2 ">Productos Tienda virtual</span>
                <?php
                    
                   $respuesta = Controladorinicio::ctrprodentv($valor);
                   //var_dump($fecha);
                ?>
                <span class="info-box-number2" style="color:#00b4d8ff;"><?php echo $respuesta[0]; ?></span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
        </div>  
    </div>

    
  </section>

<style>
  .info-box2 {
    box-shadow: 0 0 1px rgba(0, 0, 0, 0.125), 0 1px 3px rgba(0, 0, 0, 0.2);
    border-radius: 0.25rem;
    background: #00060c;
    color: white;
    display: -ms-flexbox;
    display: flex;
    margin-bottom: 1rem;
    min-height: 80px;
    padding: .5rem;
    position: relative;
    width: 100%;
  }
  .info-box2 .progress-description2,
.info-box2 .info-box-text2 {
  display: block;
  overflow: hidden;
  text-overflow: ellipsis;
  white-space: nowrap;
}
.info-box2 .info-box-icon2 {
  border-radius: 0.25rem;
  -ms-flex-align: center;
  align-items: center;
  display: -ms-flexbox;
  display: flex;
  font-size: 1.875rem;
  -ms-flex-pack: center;
  justify-content: center;
  text-align: center;
  width: 70px;
}
.info-box2 .info-box-content2 {
  display: -ms-flexbox;
  display: flex;
  -ms-flex-direction: column;
  flex-direction: column;
  -ms-flex-pack: center;
  justify-content: center;
  line-height: 120%;
  -ms-flex: 1;
  flex: 1;
  padding: 0 10px;
}
.info-box2 .info-box-number2 {
  display: block;
  margin-top: .25rem;
  font-weight: 900;
}
.textbienvenida{
    font-size: 2.5rem;
    font-weight: bold;
}
</style>