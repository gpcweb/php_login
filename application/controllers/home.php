<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller {


   function __construct()
        // Función constructora aquí podemos hacer la carga de algunos elementos adicionales cómo librerías, helpers, etc...
    {
        parent::__construct();
        $this->load->model('Usuario_model');
        $this->load->helper('date');
       
    }
	
	public function index()
	{
		$data['contenido'] = 'formulario';
        $this->load->view('template', $data);
	}
    
    public function ficha_usuario($rut)
	{
		$data['contenido'] = 'ficha';
        $data['lista'] = $this->Usuario_model->datos_usuario($rut);
        $this->load->view('template', $data);
	}
    
    public function existe_rut($rut)
	{
		
        $existe = $this->Usuario_model->check_rut($rut);
        if($existe['resultado']>=1){
            $status = 'error';
            $msg = 'RUT ya ingresado';
        }
        else {
            $status = 'succes';
            $msg = 'No existe el Rut';
        }
        
         echo json_encode(array('status' => $status,'msg' => $msg));
	}
    
    public function existe_mail($mail)
	{
		
        $existe = $this->Usuario_model->check_mail($mail);
        if($existe['resultado']>=1){
            $status = 'error';
            $msg = 'Mail ya ingresado';
        }
        else {
            $status = 'succes';
            $msg = 'No existe el mail';
        }
        
         echo json_encode(array('status' => $status,'msg' => $msg));
	}
    
    function ingresar_usuario()
    {

        //datos del form_registro enviados por la llamada AjaxFileUpload a traves de POST
        $datos_usuario = array(
            'rut' => $this->input->post('rut'),
            'nombre' => $this->input->post('nombre'),
            'apellidos' => $this->input->post('apellidos'),
            'email' => $this->input->post('email'),
            'fecha_nac' => mdate('%Y-%m-%d', strtotime($this->input->post('fecha_nac'))),
            'fono' => $this->input->post('fono'));

        
        //parametros para la respuesta a la llamada de AjaxFileUpload
        $status = "";
        $msg = "";
        $file_element_name = "userfile"; //recibe el archivo adjunto

        //ruta primaria del archivo
        $ruta = './uploads/';

        //si la ruta no existe quiere decir que es una empresa recien creada
        if (!file_exists($ruta)) {
            //creamos el directorio si no existe
            mkdir($ruta, 0777);
        }


        //configuracion para que la libreria upload de CI procese el archivo adjunto y lo suba al server
        $config['upload_path'] = $ruta;
        $config['allowed_types'] = 'jpg';
        $config['overwrite'] = false;
        $config['max_size'] = 1024 * 2; //maximo 2 megas
        $config['max_width'] = '1024';
        $config['max_height'] = '768';
        

        //llamada a la libreria upload de CI con los datos para subir el archivo
        $this->load->library('upload', $config);

        //si la carga del archivo al server falla la respuesta a la llamada AjaxFileUpload es el mensaje de error
        if (!$this->upload->do_upload($file_element_name)) {
            $status = 'error';
            $msg = $this->upload->display_errors('', '');
        }
        //si la carga en el server es exitosa se configuran los parametros de la respuesta AJax
        else {
            $data = $this->upload->data(); //capturar datos de la subida desde la libreria upload

            //se agrega al array de datos del documento dirigido a la BD, el nombre del archivo subido con su extension
            $datos_usuario['nombre_archivo'] = $data['file_name'];

            //bloque try catch para capturar errores en la llamada a la BD para registrar los datos del archivo
            try {
                $file_id = $this->Usuario_model->insertar_usuario($datos_usuario);
                $status = "success";
                $msg = "Usuario ingresado exitosamente!";
            }
            catch (exception $e) {
                $status = "error";
                $msg = $e->getMessage();
                // si la llamada a la BD falla, se elimina el archivo subido del server
                unlink($data['full_path']);
            }
            //se borra registro temporal del archivo subido
            @unlink($_FILES[$file_element_name]);
            $ruta = $ruta . '/' . $data['file_name'];
        }

        //codificacion en formato JSON de los parametros de respuesta a la llamada AjaxFileUpload
        echo json_encode(array(
            'status' => $status,
            'msg' => $msg));
            
        $this->load->library('email');

        $config = array(
            'protocol' => 'smtp',
            'smtp_host' => 'ssl://smtp.gmail.com',
            'smtp_port' => 465,
            'smtp_user' => 'poblete.cuadra@gmail.com',
            'smtp_pass' => '77578851gpc',
            'mailtype' => 'html');

        $this->email->initialize($config);

        $this->email->set_newline("\r\n");

        $this->email->from('poblete.cuadra@gmail.com', 'Gabriel Poblete');
        $this->email->to($datos_usuario['email']);
        $this->email->subject('Registro');
        $this->email->message('Te has registrado correctamente!');

        if (!$this->email->send()) {
            $msg = "Problema al enviar el correo!";
        } else {
            $msg = $msg . " Correo Enviado!";
        }
        
      

    }
    
}
