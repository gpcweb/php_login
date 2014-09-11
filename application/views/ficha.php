
  <div class="contenido">
          <form method="post" id="form_registro" name="form_registro" action="" enctype="multipart/form-data">
	       <fieldset>   
           <legend>FICHA DE USUARIO</legend>  
               <table>
                <p class="centrado"> <img src="<? echo base_url('uploads/'.$lista['nombre_archivo'].''); ?>"  /> </p>
               <tr>
               <td> <label for="rut"> <p> RUT :</p></label></td>
               <td> <? echo $lista['rut']; ?></td>
               </tr>
               
               <tr>
               <td> <label for="nombre"> <p> Nombre:</p></label></td>
               <td> <? echo $lista['nombre']; ?></td>
               </tr>
               
               <tr>
               <td> <label for="apellidos"> <p> Apellidos:</p></label></td>
               <td> <? echo $lista['apellidos']; ?></td>
               </tr>
               
               <tr>
               <td> <label for="email"> <p> Email:</p></label></td>
               <td> <? echo $lista['email']; ?></td>
               </tr>
               
               <tr>
               <td> <label for="fecha_nac"> <p> Fecha Nac:</p></label></td>
               <td> <? echo $lista['fecha_nac']; ?></td>
               </tr>
               
               <tr>
               <td> <label for="fono"> <p> Telefono:</p></label></td>
               <td> <? echo $lista['fono']; ?></td>
               </tr>
               
               
               
               </table>
                              
            </fieldset>
         </form>
         
        </div>