<?php

    include "Conexion.php";

    class Usuarios extends Conexion {
        public function loginUsuario($usuario) {
            // Establece la conexión a la base de datos
            $conexion = Conexion::conectar();
        
            // Consulta SQL para verificar si el usuario existe
            $sql = "SELECT * FROM t_usuarios WHERE usuario = '$usuario'";
            $respuesta = mysqli_query($conexion, $sql);
        
            // Verifica si se encontró al menos un registro
            if (mysqli_num_rows($respuesta) > 0) {
                $datosUsuario = mysqli_fetch_array($respuesta);
        
                // Verifica si el usuario está activo
                if ($datosUsuario['activo'] == 1) {
                    // Almacena datos del usuario en la sesión
                    $_SESSION['usuario']['nombre'] = $datosUsuario['usuario'];
                    $_SESSION['usuario']['id'] = $datosUsuario['id_usuario'];
                    $_SESSION['usuario']['rol'] = $datosUsuario['id_rol'];
                    return 1;  // Retorna 1 si el usuario está activo
                } else {
                    return 0;  // Retorna 0 si el usuario no está activo
                }
            } else {
                return 0;  // Retorna 0 si el usuario no existe
            }
        }
        

        public function tokenG($id_session){
            $conexion = Conexion::conectar();
            $sql = "INSERT INTO t_asignacion (id_session)
                    VALUES(?)";
            $query = $conexion->prepare($sql);



        }

        public function agregarNuevoUsuario($datos){
            $conexion = Conexion::conectar();
            $idPersona = self::agregarPersona($datos);

            if ($idPersona > 0) {
                $sql = "INSERT INTO t_usuarios (id_rol,
                                                id_persona,
                                                usuario,
                                                password,
                                                ubicacion)
                        VALUES (?, ?, ?, ?, ?)";
                $query = $conexion->prepare($sql);
                $query->bind_param("iisss", $datos['idRol'],
                                            $idPersona,
                                            $datos['usuario'],
                                            $datos['password'],
                                            $datos['ubicacion']);
                $respuesta = $query->execute();
                return $respuesta;                                    
            } else {
                return 0;
            }


        }

        public function agregarPersona($datos) {
            $conexion = Conexion::conectar();
            $sql = "INSERT INTO t_persona (paterno,
                                            materno,
                                            nombre,
                                            fecha_nacimiento,
                                            sexo,
                                            telefono,
                                            correo)
                    VALUES (?, ?, ?, ?, ?, ?, ?)";
            $query = $conexion->prepare($sql);
            $query->bind_param("sssssss",$datos['paterno'],
                                        $datos['materno'],
                                        $datos['nombre'],
                                        $datos['fechanacimiento'],
                                        $datos['sexo'],
                                        $datos['telefono'],
                                        $datos['correo']);
            $respuesta = $query->execute();
            $idPersona = mysqli_insert_id($conexion);
            $query->close();
            return $idPersona;
        }

        public function obtenerDatosUsuario($idUSuario) {
            $conexion = Conexion::conectar();
            
            $sql = "SELECT 
                        usuarios.id_usuario AS idUsuario,
                        usuarios.usuario As nombreUsuario,
                        roles.nombre AS rol,
                        usuarios.id_rol AS idRol,
                        usuarios.ubicacion AS ubicacion,
                        usuarios.activo AS estatus,
                        usuarios.id_persona AS idPersona,
                        persona.nombre AS nombrePersona,
                        persona.paterno AS paterno,
                        persona.materno AS materno,
                        persona.fecha_nacimiento AS fechanacimiento,
                        persona.sexo AS sexo,
                        persona.correo AS correo,
                        persona.telefono AS telefono
                    FROM
                        t_usuarios AS usuarios
                            INNER JOIN
                        t_cat_roles AS roles ON usuarios.id_rol = roles.id_rol
                            INNER JOIN
                        t_persona AS persona ON usuarios.id_persona = persona.id_persona
                            AND usuarios.id_usuario = '$idUSuario'";
            $respuesta = mysqli_query($conexion, $sql);
            $usuario = mysqli_fetch_array($respuesta);
            
            $datos = array(
                'idUsuario' => $usuario['idUsuario'],
                'nombreUsuario' => $usuario['nombreUsuario'],
                'rol' => $usuario['rol'],
                'idRol' => $usuario['idRol'],
                'ubicacion' => $usuario['ubicacion'],
                'estatus' => $usuario['estatus'],
                'idPersona' => $usuario['idPersona'],
                'nombrePersona' => $usuario['nombrePersona'],
                'paterno' => $usuario['paterno'],
                'materno' => $usuario['materno'],
                'fechaNacimiento' => $usuario['fechanacimiento'],
                'sexo' => $usuario['sexo'],
                'correo' => $usuario['correo'],
                'telefono' => $usuario['telefono']
            );

            return $datos;
        }

        public function loginSession($datos){
            $conexion = Conexion::conectar();
            
        }

        public function actualizarUsuario($datos) {
            $conexion = Conexion::conectar();
            $exitoPersona = self::actualizarPersona($datos);

            if ($exitoPersona) {
                $sql = "UPDATE t_usuarios SET id_rol = ?,
                                                usuario = ?,
                                                ubicacion = ?
                        WHERE id_usuario = ?";
                $query = $conexion->prepare($sql);
                $query->bind_param('issi', $datos['idRol'],
                                            $datos['usuario'],
                                            $datos['ubicacion'],
                                            $datos['idUsuario']);
                $respuesta = $query->execute();
                $query->close();
                return $respuesta;
            } else {
                return 0;
            }
        }

        public function actualizarPersona($datos) {
            $conexion = Conexion::conectar();
            $idPersona = self::obtenerIdPersona($datos['idUsuario']);

            $sql = "UPDATE t_persona SET paterno = ?,
                                        materno = ?,
                                        nombre = ?,
                                        fecha_nacimiento = ?,
                                        sexo = ?,
                                        telefono = ?,
                                        correo = ?
                    WHERE id_persona = ?";
            $query = $conexion->prepare($sql);
            $query->bind_param('sssssssi', $datos['paterno'],
                                            $datos['materno'],
                                            $datos['nombre'],
                                            $datos['fechanacimiento'],
                                            $datos['sexo'],
                                            $datos['telefono'],
                                            $datos['correo'],
                                            $idPersona);
            $respuesta = $query->execute();
            $query->close();
            return $respuesta;
        }

        public function obtenerIdPersona($idUSuario) {
            $conexion = Conexion::conectar();
            $sql = "SELECT
                        persona.id_persona AS idPersona
                    FROM
                        t_usuarios AS usuarios
                            INNER JOIN
                        t_persona AS persona ON usuarios.id_persona = persona.id_persona
                            AND usuarios.id_usuario = '$idUSuario' ";
            $respuesta = mysqli_query($conexion, $sql);
            $idPersona = mysqli_fetch_array($respuesta)['idPersona'];
            return $idPersona;
        }

        public function resetPassword($datos) {
            $conexion = Conexion::conectar();
            $sql = "UPDATE t_usuarios
                    SET password = ?
                    WHERE id_usuario = ?";
            $query = $conexion->prepare($sql);
            $query->bind_param('si', $datos['password'],
                                    $datos['idUsuario']);
            $respuesta = $query->execute();
            $query->close();

            return $respuesta;
        }

        public function cambioEstatusUsuario($idUSuario, $estatus) {
            $conexion = Conexion::conectar();

            if ($estatus == 1) {
                $estatus = 0;
            } else {
                $estatus = 1;
            }
            
            $sql = "UPDATE t_usuarios
                    SET activo = ?
                    WHERE id_usuario = ?";
            $query = $conexion->prepare($sql);
            $query->bind_param('ii', $estatus, $idUSuario);
            $respuesta = $query->execute();
            $query->close();
            return $respuesta;
        }

        public function buscarReportesUsuario($idUSuario) {
            $conexion = Conexion::conectar();
            $sql = "SELECT * FROM t_reportes WHERE id_usuario = '$idUSuario'";
            $respuesta = mysqli_query($conexion, $sql);
            if (mysqli_num_rows($respuesta) > 0) {
                return 1;
            } else {
                return 0;
            }
        }
        
        public function buscarAsignacionPersona($idPersona) {
            $conexion = Conexion::conectar();
            $sql = "SELECT * FROM t_asignacion WHERE id_persona = '$idPersona'";
            $respuesta = mysqli_query($conexion, $sql);
            if (mysqli_num_rows($respuesta) > 0) {
                return 1;
            } else {
                return 0;
            }
        }
        
        public function eliminarUsuario($datos) {
            $conexion = Conexion::conectar();

            $reportes = self::buscarReportesUsuario($datos['idUsuario']);
            $asignacion = self::buscarAsignacionPersona($datos['idPersona']);

            if ($reportes == 0 && $asignacion == 0){

                $sql = "DELETE FROM t_usuarios WHERE id_usuario = ?";
                $query = $conexion->prepare($sql);
                $query->bind_param('i', $datos['idUsuario']);
                $respuesta = $query->execute();
                $query->close();
                return $respuesta;
            } else {
                return 0;
            }

        } 
        

    }