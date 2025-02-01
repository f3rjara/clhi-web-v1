
<!-- **************** Copyright  **************** -->
<section>
<div>
    © 2018 Copyright:
    <a href="https://www.youtube.com/playlist?list=PLZcNRnHxdf3Qr2w7DH9CF0sOQGevzGMpO" target="_blank" title="Proyecto realizaso por @f3rjara">Fernando Jaramillo | <b style="font-family: 'Yatra One', cursive;" >@f3rjara</b>  </a>
</div>
</section>
<hr>
<!-- *************  /Copyright  ***************** -->
<?php

include ('log/cnxlo.php');

//CONSULTAR GRUPOS
                        
$GruposDocente2 = mysqli_query($conex,
"SELECT * FROM grupo, docente 
WHERE grupo.id_docente = docente.id_docente
AND docente.id_docente = '1085277365'" ); 

while($RCGD2 = mysqli_fetch_array($GruposDocente2))
{
$id_Grupo =$RCGD2['id_grupo'];
$detalleGrupo2 = $RCGD2['detalle'];

echo $id_Grupo."<br>";
echo $detalleGrupo2."<br>";

}

<?php
                            //CONSULTAR GRUPOS
                        
                            $GruposDocente2 = mysqli_query($conex,
                            "SELECT * FROM grupo, docente 
                            WHERE grupo.id_docente = docente.id_docente
                            AND docente.id_docente = '".$_SESSION['docente']."'" ); 
                            
                            while($RCGD2 = mysqli_fetch_array($GruposDocente2)) {
                            $id_Grupo =$RCGD2['id_grupo'];
                            $detalleGrupo2 = $RCGD2['detalle'];
                            //echo '<script>alert('.$id_Grupo.')</script>'; 
                            if($id_Grupo == $DetalleGruposDocente[$i][0] ) {
                            ?> <option class="black-text" value="<?php echo $id_Grupo; ?>" selected> Grupo: <?php echo $detalleGrupo2; ?></option> <?PHP
                            }
                            else {
                            ?> <option class="black-text" value="<?php echo $id_Grupo; ?>" ><?php echo $detalleGrupo2; ?></option> <?PHP
                            }    
                            }
                            ?>


                            
                            
                           
                          
<div class="input-field col s12">
<select class="center" name="id_CatActivi" required>

<?php
//CONSULTAR
$CategoriasActividad = mysqli_query($conex,
"SELECT * FROM categoriaactividad" ); 
while($RCCA2 = mysqli_fetch_array($CategoriasActividad))
{
$id_categoriaActividad =$RCCA2['id_categoriaActividad'];
$CategoriaActividad =$RCCA2['categoriaActividad'];

if($id_categoriaActividad == $Id_TipoActividad ){
echo '<option class="black-text" selected value="'.$id_categoriaActividad.'">'.utf8_encode($CategoriaActividad).'</option>';
}
else{
echo '<option class="black-text"  value="'.$id_categoriaActividad.'">'.utf8_encode($CategoriaActividad).'</option>';
}       
}
?>

</select>
<label>Seleccione Tipo Actividad</label>
</div>
                            
                           
                          
    <form class="row" method="post" action="paneldoc.php" enctype="multipart/form-data">
                        
                        <input type="number" value="<?php echo $Id_TipoActividad; ?>" name="Id_TipoActividad" hidden />
                        
                        <div class="input-field col s12 m3">
                        
                        <?php echo $HayCategoria; ?>
                        </div> 
                        
                        <div class="input-field col s12 m3">
                           
                            <select name="fernando" required>
                              <option value="" disabled selected>Choose your option</option>
      <option value="1">Option 1</option>
      <option value="2">Option 2</option>
      <option value="3">Option 3</option>
                            

                            </select>
                            <label>Seleccione el grupo</label>
                            </div>
                            
                        <div class="input-field col s12 m3">
                        <input type="text" value="papa" name="id_CatActivi" />
                        </div>
                        
                           
                            
                       <div class="collapsible-header">
                <i class="material-icons">exposure</i>
                <b><?php echo htmlentities($RCactividad);?></b> &nbsp;
                <b class="greentools-text">|| Plazo: </b> &nbsp;<b><?php echo $RCfechaplazo;?></b>
                </div>
                
                <div class="collapsible-body white">
                <b class="greentools-text">Modalidad :</b>&nbsp; 
                <b><?php echo $RCmodalidad;?> </b> <br>
                <b class="greentools-text">Descripción :</b>&nbsp; 
                <b><?php echo uft8_encode($RCdescripcion);?> </b> <br>
                <a href="<?php echo $RClink_actividad;?>" target="_blank" class="btn bluetools white-text"><b>Ver</b></a>
                
                </div>
                        
                        
                         
                        </form>
                            
                           
                          
                          
                <tr>
                    <td><?php echo $RCactividad;?></td>                    
                    <td width="50%"><?php echo $RCdescripcion;?></td>                    
                    <td><?php echo $RCfechaplazo;?></td>                    
                    <td><?php echo $RCmodalidad;?></td>                    
                    <td><a href="<?php echo $RClink_actividad;?>" target="_blank" class="btn bluetools white-text"><b>Ver</b></a></td>                    
                </tr>
                
               