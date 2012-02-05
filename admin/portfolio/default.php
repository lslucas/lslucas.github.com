<?php

  if (isset($_POST['act'])) {
  include_once 'mod.exec.php';

   } else
   if (isset($_GET['insert']) XOR isset($_GET['update'])) {
    include_once 'form.php';

     } elseif (isset($_GET['delete'])) {
      include_once 'mod.delete.php';

       } elseif (isset($_GET['delete_imagem'])) {
      	include_once 'mod.r_port_imagem.delete.php';

         } elseif (isset($_GET['delete_makingoff'])) {
          include_once 'mod.r_port_makingoff.delete.php';

             } elseif (isset($_GET['status'])) {
              include_once 'mod.status.php';

                } else {
                 include_once 'list.php';

                }

?>
