<?php

class Usuario_model extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }
    
    function datos_usuario($rut)
    {
        $this->db->select('*');
        $this->db->where('rut', $rut);
              
        $consulta = $this->db->get('usuario');
        return $consulta->row_array();
    }
    
    function check_rut($rut)
    {
        $this->db->select('COUNT(*) AS resultado');
        $this->db->where('rut', $rut);
              
        $consulta = $this->db->get('usuario');
        return $consulta->row_array();
    }
    
    function check_mail($mail)
    {
        $this->db->select('COUNT(*) AS resultado');
        $this->db->where('email', $mail);
              
        $consulta = $this->db->get('usuario');
        return $consulta->row_array();
    }
    
    function insertar_usuario($datos_usuario)
    {  
        $consulta = $this->db->insert('usuario', $datos_usuario);    
        
        return $consulta;               
    }
    
   
    
}
//location: application/models/login_model.php
?>