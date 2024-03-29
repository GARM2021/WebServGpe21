<?php  /**   *  Implementacion de algoritmo AES   *  @author: Mercadotecnia, Ideas y Tecnologia   *  @date  : 2014   *   *  Ejemplo de uso:   *  <code>   *  <?php   *     include('/AESEncriptacion.php');   *     $key              = '605bd70efed2c6374823b54bbc560b58'; //Llave de 128 bits la cual se le proporcionará al comercio en formato hexadecimal con longitud de 32 caracteres   *     $textoOriginal    = 'Este es el texto a procesar';   *     $cadenaEncriptada = AESEncriptacion::encriptar($textoOriginal, $key);   *     $cadenaOriginal   = AESEncriptacion::desencriptar($cadenaEncriptada, $key);   *  ?>   *  </code>   */
    class AESEncriptacion{    
      public static function encriptar($plaintext, $key128)      {
                  dump($plaintext);
                  $plaintext = AESEncriptacion::pkcs5_pad($plaintext, mcrypt_get_block_size(MCRYPT_RIJNDAEL_128,MCRYPT_MODE_CBC));        $cipher = mcrypt_module_open(MCRYPT_RIJNDAEL_128, '', MCRYPT_MODE_CBC, '');        $iv_size = mcrypt_enc_get_iv_size($cipher);        $iv = mcrypt_create_iv($iv_size, MCRYPT_DEV_URANDOM);        if (mcrypt_generic_init($cipher, hex2bin($key128), $iv) != -1){        	$cipherText = mcrypt_generic($cipher, $plaintext );	        mcrypt_generic_deinit($cipher);	        $b64ciphertext = base64_encode($iv.$cipherText);			return $b64ciphertext;        }   
                  dump($plaintext);
                  return "";      
                }


      public static function desencriptar($encodedInitialData, $key){        $encodedInitialData =  base64_decode($encodedInitialData);        $iv = substr($encodedInitialData,0,16);        $encodedInitialData = substr($encodedInitialData,16); //mb_substr no funciona en algunas versiones de php        $cypher = mcrypt_module_open(MCRYPT_RIJNDAEL_128, '', MCRYPT_MODE_CBC, '');        if (mcrypt_generic_init($cypher, hex2bin($key), $iv) != -1){          $decrypted = mdecrypt_generic($cypher, $encodedInitialData);          mcrypt_generic_deinit($cypher);          mcrypt_module_close($cypher);          return AESEncriptacion::pkcs5_unpad($decrypted);        }		return AESEncriptacion::pkcs5_unpad($decrypted);      }
              }
      private static function pkcs5_pad ($text, $blocksize)      {  
              $pad = $blocksize - (strlen($text) % $blocksize);   
              return $text . str_repeat(chr($pad), $pad);
      }

      private static function pkcs5_unpad($text)      { 
        
        $pad =  2;
        
        //$pad = ord($text{strlen($text)-1});      
      
      if ($pad > strlen($text)) return false;        if (strspn($text, chr($pad), strlen($text) - $pad) != $pad) return false;        return substr($text, 0, -1 * $pad);      }    
      
    }