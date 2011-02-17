<?php


class Password {

  /*
   * author Lucas Serafim, lslucas@gmail.com
   * www.lucasserafim.com.br
   * licence: open for all ;)
   *
   * This class verify php version and suport for mcrypt
   * if not suport mcrypt use md5, if php version is lower 5.0.0 not use binary format
   *
   ####usage
   *$pass = new Password;
   *var_dump($pass->hash('mypassword'));
   *ou var_dump($pass->hash('mypassword', 'md5', 'my salt'));
   */


  private $_input, $_key, $_type, $encrypted_data;



  //clean vars
  public function __destruct() {
    unset($encrypted_data, $_input, $_type, $_key);
  }



  /*
   *generate the password with parameters
   @params: password, function to use: mcrypt (default) or md5, key or your salt (I use server_name with default)
   @return string
   */
  public function hash($_input, $_type='mcrypt', $_key=$_SERVER['SERVER_NAME']) {


      /*
       *if exists mcrypt and $_type is mcrypt
       */
      if( function_exists('mcrypt') && $_type=='mcrypt' ) {

          $td = mcrypt_module_open(MCRYPT_TWOFISH256, '', 'ofb', '');
          $iv = mcrypt_create_iv (mcrypt_enc_get_iv_size($td), MCRYPT_BLOWFISH);

          mcrypt_generic_init($td, $_key, $iv);
          $encrypted_data = mcrypt_generic($td, $_input);
          mcrypt_generic_deinit($td);
          mcrypt_module_close($td);


      //else use md5
      } else {

        if(version_compare(PHP_VERSION, '5.0.0', '>='))
          $bool = true;
        else $bool = false;


          $encrypted_key  = md5($_key, $bool).md5($_input, $bool);
          $encrypted_data = md5($encrypted_key, $bool);

      }


    // return generated password
    // enjoy
    return $encrypted_data;

  }



}


