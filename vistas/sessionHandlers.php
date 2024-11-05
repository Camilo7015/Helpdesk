<?php

/*#############################################################################
Session table format:  
  id - varchar(40), not null, primary key  
  contenido - text, null  
  timestamp - int, not null
#############################################################################*/
include "../../clases/Conexion.php";

global $conexion;
$conexion = mysql_connect($servidor, $usuario, $password);
mysql_select_db($db, $conexion);

function custom_session_open($save_path, $session_name){  
  return(true);
} 

function custom_session_close(){  
  #do garbage collection  
  return custom_session_gc(get_cfg_var("session.gc_maxlifetime"));
}

function custom_session_read($id){  
  global $conexion;  
  $result = @mysql_query("SELECT contenido FROM " . t_session . " WHERE id='" . mysql_real_escape_string($id, $conexion) . "'", $conexion);  
  if ($row = @mysql_fetch_assoc($result))  {    
    @mysql_query("UPDATE " . t_session . " SET timestamp=" . time() . " WHERE id='" . mysql_real_escape_string($id, $conexion) . "'", $conexion);    
    return((string)$row['contenido']);  
  }  
  return("");
} 

function custom_session_write($id, $sess_data){  
  global $conexion;  
  $result = @mysql_query("SELECT COUNT(*) AS nr FROM " . t_session . " WHERE id='" . mysql_real_escape_string($id, $conexion) . "'", $conexion);  
  $count = @mysql_fetch_assoc($result);  
  if ($count['nr'] > 0)  {    
    $sql = "UPDATE " . t_session;    
    $sql .= " SET contenido='" . mysql_real_escape_string($sess_data, $conexion) . "'";    
    $sql .= ", timestamp=" . time();    
    $sql .= " WHERE id='" . mysql_real_escape_string($id, $conexion) . "'";    
    @mysql_query($sql, $conexion);  
  }  
  else  {    
    $sql = "INSERT INTO " . t_session;    
    $sql .= " (id, contenido, timestamp)";    
    $sql .= " VALUES ";    
    $sql .= "('" . mysql_real_escape_string($id, $conexion) . "',";    
    $sql .= " '" . mysql_real_escape_string($sess_data, $conexion) . "', ";    
    $sql .= time() . ")";    
    @mysql_query($sql, $conexion);  
  }  
  return true;
}  

function custom_session_destroy($id){  
  global $conexion;  
  @mysql_query("DELETE FROM " . t_session . " WHERE id='" . mysql_real_escape_string($id, $conexion) . "'", $conexion);  
  return(true);
}

function custom_session_gc($maxlifetime){  
  global $conexion;  
  $cur = time();  
  $exp = $cur - $maxlifetime; 
  # this assumes that $maxlifetime is in seconds  
  @mysql_query("DELETE FROM " . t_session . " WHERE timestamp < {$exp}", $conexion);  
  return(true);
} 

function get_user_count($mins){  
  global $conexion;   
  $cur = time();  
  $limit = $cur - ($mins * 60);  
  $result = @mysql_query("SELECT COUNT(*) AS nr FROM " . t_session . " WHERE timestamp >= {$limit}", $conexion);  
  $row = @mysql_fetch_assoc($result);  
  return $row['nr'];
}

session_set_save_handler(
  "custom_session_open",
  "custom_session_close",
  "custom_session_read",            
  "custom_session_write",             
  "custom_session_destroy",             
  "custom_session_gc"
); 


session_start();
$_SESSION['1'] = 1;// proceed to use sessions normally
?>