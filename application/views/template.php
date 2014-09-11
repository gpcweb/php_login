<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Bienvenido </title>
    <link href="<? echo base_url('recursos/css/style.css'); ?>" rel="stylesheet" type="text/css" />
    <link href="<? echo base_url('recursos/css/ui-lightness/jquery-ui-1.8.21.custom.css'); ?>" rel="stylesheet" type="text/css" />
	<script type="text/javascript" src="<? echo base_url('recursos/js/jquery-1.7.2.min.js'); ?>"></script>
    <script type="text/javascript" src="<? echo base_url('recursos/js/jquery.validate.min.js'); ?>"></script>
    <script type="text/javascript" src="<? echo base_url('recursos/js/jquery.Rut.js'); ?>"></script>
    <script type="text/javascript" src="<? echo base_url('recursos/js/jquery-ui-1.8.21.custom.min.js'); ?>"></script>
    <script type="text/javascript" src="<? echo base_url('recursos/js/jquery.ui.datepicker-es.js'); ?>"></script>
    <script type="text/javascript" src="<? echo base_url('recursos/js/test.js'); ?>"></script>
    <script type="text/javascript" src="<? echo base_url('recursos/js/ajaxfileupload.js'); ?>"></script>
</head>
<body>

<div id="container">
	<?php
      $this->load->view($contenido);
      
    ?> 
</div>

</body>
</html>