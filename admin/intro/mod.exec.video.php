<?php


 if (isset($_FILES)) {

  include_once "_inc/class.upload.php";
   $sqlImagem = '';
   $w=$pos=0;




    if(isset($_FILES['video'])) {


       if (isset($_FILES['video']['name']) && is_file($_FILES['video']['tmp_name']) ) {


         $filename = $res['item'].'_'.rand();
         $handle = new Upload($_FILES['video']);

         if ($handle->uploaded) {
           $handle->file_new_name_body  = $filename;
           $handle->Process($var['path_video']);
           if (!$handle->processed) echo 'error : ' . $handle->error;

           $video = $handle->file_dst_name;


        }

      } else $video='';



       if(!empty($video)) {

           $sqlmaking= "UPDATE ".TABLE_PREFIX."_intro SET ${var['pre']}_video=? WHERE ${var['pre']}_id=1";

            if($qrymaking=$conn->prepare($sqlmaking)) {

              $qrymaking->bind_param('s', $video);
              $qrymaking->execute();
              $qrymaking->close();

            } else echo $conn->error;

       }



    }


}
