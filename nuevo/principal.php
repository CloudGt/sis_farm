<?php date_default_timezone_set('America/Guatemala'); 
   session_start();
   require('conexion/conexion.php');
   
   $usr = $_SESSION['username'];
   
   
   ?>
<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="utf-8">
      <title>Sistema de Control APDAHUM</title>
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <link rel="stylesheet" href="../bootstrap/css/diaco.css">
      <link rel="stylesheet" href="../bootstrap/css/bootstrapmin.css">
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
      <script src="https://npmcdn.com/tether@1.2.4/dist/js/tether.min.js"></script>
      <script src="https://npmcdn.com/bootstrap@4.0.0-alpha.5/dist/js/bootstrap.min.js"></script>
      <script src="../bootstrap/jquery/jquery-ui/jquery-ui.js"></script>
      <script src="../bootstrap/datepicker/jquery.js"></script>
      <link rel="stylesheet" href="../bootstrap/jquery/jquery-ui/jquery-ui.min.css">
      <link rel="stylesheet" type="text/css" href="../DataTables/datatables.min.css"/>
      <script type="text/javascript" src="../DataTables/datatables.min.js"></script>
      <script type="text/javascript">
         $(document).ready(function(){
         
         
         

         
         $("#mimenu a").each(function(){
                  var href = $(this).attr("id");
                  
                  $(this).click(function(){
                     $("#contenidos").load(href);
                     
                  });
               });
         
         });
         
         
         
         
         
      </script>
   </head>
   <body id="myPage"  data-spy="scroll" data-target=".navbar" data-offset="60">
      <nav class="navbar navbar-inverse">
         <div class="container-fluid">
            <div class="navbar-header">
               <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
               <span class="icon-bar"></span>
               <span class="icon-bar"></span>
               <span class="icon-bar"></span>                        
               </button>
               <a class="navbar-brand" href="#myPage">Sistema de Control APDAHUM </a>
            </div>
            <div class="collapse navbar-collapse" id="myNavbar">
               <ul class="nav navbar-nav navbar-right">
                  <li><span >
                     <?php 
                        if (!isset($_SESSION['this_cookie'])) {
                        
                        }else{
                          $nombre=($_SESSION["username"]);
                              //print_r($nombre);
                          echo "<div class=\"login\"> Bienvenido: $nombre <br><i class=\"fa fa-sign-out\" aria-hidden=\"true\"></i>
                          <a href='logout.php' target='_parent' >SALIR</a></span><br><i class=\"fi-x-circle\"></i>
                          <a href='cambio_password.php' target='_parent'>Cambiar Contraseña</a></div>"; 
                          echo "";
                          $dia_numero= date("d");
                          $dia_letras = date('D');
                        }
                        ?></span>
                  </li>
               </ul>
            </div>
         </div>
      </nav>
      <!-- Menu Vertical -->
      <div class="col-xs-3 col-md-3 col-xl-3">
      <nav>
         
            <?php 
               $query = "SELECT * FROM menu where Padre = 0";
               $resultado = mysqli_query($conexion,$query);
               
                
               
               if (!$resultado) {
                 die("No se encontraron Datos");
               }else{
                   $x = 0;
                       while($data = mysqli_fetch_assoc($resultado)){
                             
                              echo '
                                 <div class="panel-group">
                                     <div class="panel panel-default">
                                       <div class="panel-heading">
                                         <h4 class="panel-title">
                                           <a data-toggle="collapse" href="#collapse'.$x.'">'.$data['Descr'].'</a>';
                              $query2 = "SELECT Id_Menu,replace(Descr, ' ', '') as SinEspacios,Descr,Padre,Pagina FROM menu where Padre = ".$data['Id_Menu'];
                              $result = mysqli_query($conexion,$query2);
                              if(mysqli_num_rows($result) > 0) {
                                               echo '
                                               </h4>
                                                   </div>
                                                        <div id="collapse'.$x.'" class="panel-collapse collapse " >
                                                             <div id = "mimenu" class="panel-body">
                                                               <ul class="list-group">
                                                               ';
                                                               while($query2 = mysqli_fetch_assoc($result)){
                                                                  echo ' <li class="list-group-item"><a id = "../'.$query2['Pagina'].'"  >'.$query2['Descr'].' </a></li>';
                                                                }   
                                                              echo '</ul>
                                                           </div>';
                                                            mysqli_free_result($result);
                                                           echo '</div>
                                                       </div>
                                                 </div>';
                                         
                               }
                        $x+=1;  
               
               
               }
               }
               mysqli_free_result($resultado);
               
               
               
               
               ?>
               </nav>
         </div>
      
    
      <!-- */************************************* -->
      <div class="col-xs-8 col-md-8 col-xl-8" id="contenidos">
         <!-- <img src="IMAGENES\fondo sistema ariane.JPG" style="padding-left:25%; padding-top:10%;"> -->
      </div>
      <!--   <pre> 
         <?php 
            print_r($_SESSION);
            
            ?>
         </pre> --> 
      </div>
   </body>
</html>