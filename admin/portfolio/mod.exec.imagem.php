<?php


 if (isset($_FILES)) {

  include_once "_inc/class.upload.php";
   $sqlImagem = '';
   $w=$pos=0;




    if(isset($_FILES['imagem0'])) {



         $sql_smod = "SELECT rpi_pos FROM ".TABLE_PREFIX."_r_${var['pre']}_imagem WHERE rpi_${var['pre']}_id=? ORDER BY rpi_pos DESC LIMIT 1";
         $qry_smod = $conn->prepare($sql_smod);
         $qry_smod->bind_param('i',$res['item']);
         $qry_smod->execute();
         $qry_smod->bind_result($pos);
         $qry_smod->fetch();
         $qry_smod->close();
         $pos = ($pos<>0)?$pos=$pos+1:$pos;



             $sql= "INSERT INTO ".TABLE_PREFIX."_r_${var['pre']}_imagem 

              (rpi_${var['pre']}_id,
               rpi_imagem,
               rpi_pos
               )
              VALUES
              (?,
               ?,
               ?)";
             $qry=$conn->prepare($sql);
             $qry->store_result();



         for ($i=0;$i<=count($_FILES);$i++) {


             if (isset($_FILES['imagem'.$i]['name']) && is_file($_FILES['imagem'.$i]['tmp_name']) ) {


         $filename = $res['item'].'_'.rand();
         $handle = new Upload($_FILES['imagem'.$i]);

         // then we check if the file has been uploaded properly
         // in its *temporary* location in the server (often, it is /tmp)
         if ($handle->uploaded) {
           $handle->file_new_name_body  = $filename;
           $handle->Process($var['path_original']);
           if (!$handle->processed) echo 'error : ' . $handle->error;

           $handle->file_new_name_body  = $filename;
           $handle->image_resize        = true;
           #$handle->image_ratio_x        = true;
           $handle->image_ratio_crop    = true;
           $handle->image_x             = $var['imagemWidth'];
           $handle->image_y             = $var['imagemHeight'];
           $handle->process($var['path_imagem']);
           if (!$handle->processed) echo 'error : ' . $handle->error;

           $handle->file_new_name_body  = $filename;
           $handle->image_resize        = true;
           #$handle->image_ratio_x        = true;
           $handle->image_ratio_crop    = true;
           $handle->image_x             = $var['thumbWidth'];
           $handle->image_y             = $var['thumbHeight'];
           $handle->process($var['path_thumb']);
           if (!$handle->processed) echo 'error : ' . $handle->error;


             $imagem = $handle->file_dst_name;


         $qry->bind_param('isi', $res['item'],$imagem,$pos); 
         $qry->execute();
               }
            }

          $pos++;
         }



         $qry->close();


     }




    if(isset($_FILES['makingoff'])) {


       if (isset($_FILES['makingoff']['name']) && is_file($_FILES['makingoff']['tmp_name']) ) {


         $filename = $res['item'].'_'.rand();
         $handle = new Upload($_FILES['makingoff']);

         if ($handle->uploaded) {
           $handle->file_new_name_body  = $filename;
           $handle->Process($var['path_makingoff']);
           if (!$handle->processed) echo 'error : ' . $handle->error;

           $makingoff = $handle->file_dst_name;


        }

      } else $makingoff='';



       if(!empty($makingoff)) {

           $sqlmaking= "UPDATE ".TABLE_PREFIX."_portfolio SET ${var['pre']}_makingoff=? WHERE ${var['pre']}_id=?";

            if($qrymaking=$conn->prepare($sqlmaking)) {

              $qrymaking->bind_param('si', $makingoff, $res['item']);
              $qrymaking->execute();
              $qrymaking->close();

            } else echo $conn->error;

       }



    }




}
