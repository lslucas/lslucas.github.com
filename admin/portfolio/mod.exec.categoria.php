<?php

if (isset($_POST['cat_id'])) {


   $sql_dmod = "DELETE FROM ".TABLE_PREFIX."_r_${var['pre']}_categoria WHERE rpc_${var['pre']}_id=?";
   $qry_dmod = $conn->prepare($sql_dmod);
   $qry_dmod->bind_param('i',$res['item']);
   $qry_dmod->execute();
   $qry_dmod->close();



   $sql_smod = "SELECT rpc_pos FROM ".TABLE_PREFIX."_r_${var['pre']}_categoria WHERE rpc_${var['pre']}_id=? ORDER BY rpc_pos DESC LIMIT 1";
   $qry_smod = $conn->prepare($sql_smod);
   $qry_smod->bind_param('i',$res['item']);
   $qry_smod->execute();
   $qry_smod->bind_result($pos);
   $qry_smod->fetch();
   $qry_smod->close();
   $pos = ($pos<>0)?$pos=$pos+1:$pos;



       $sql= "INSERT INTO ".TABLE_PREFIX."_r_${var['pre']}_categoria 

                  (rpc_${var['pre']}_id,
                   rpc_cat_id,
                   rpc_pos
                   )
                  VALUES
                  (?,
                   ?,
                   ?)";
       $qry=$conn->prepare($sql);
       $qry->store_result();



	for ($i=0;$i<=count($_POST['cat_id']);$i++) {


	    if (isset($_POST['cat_id'][$i]) && !empty($_POST['cat_id'][$i]) ) {

	     $cat_id = $_POST['cat_id'][$i];

	     $qry->bind_param('iii', $res['item'],$cat_id,$pos); 
	     $qry->execute();

	    }


	}

    $qry->close();
    $pos++;

}

