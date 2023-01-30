<?php
 	session_start(); 	
?>
<!DOCTYPE html>

<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
	<link rel="stylesheet" href="https://kit.fontawesome.com/f0d299a1c1.css" crossorigin="anonymous">
	<script src="https://kit.fontawesome.com/f0d299a1c1.js" crossorigin="anonymous"></script>
	<title></title>
</head>

<body>
	<?php
	
	if(!isset($_SESSION['carrito'])){
		$_SESSION['carrito']= array();
	}
	$pg= isset($_REQUEST["pg"]) ? $_REQUEST["pg"]:NULL;
	
	if(session_status()==2){
		echo "Sesion Iniciada";
	}
	if($pg==908){
		include('vista/vdprod.php');
	}else{
	include('vista/vpro.php');
	}
	?>
</body>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js" integrity="sha384-mQ93GR66B00ZXjt0YO5KlohRA5SY2XofN4zfuZxLkoj1gXtW8ANNCe9d5Y3eG5eD" crossorigin="anonymous"></script>
<script type="text/javascript">
	//pequeñas funciones para comprobar cuando se vacia, se elimina un producto o se realiza una compra...
	function eliminar(){
	var v = confirm("¿Desea vaciar el carrito?");
	return v;
	}
	
	function comprar(){
		var c=alert('compra realizada con exito...');
		return c;
	}
	function quitar(){
		var a = confirm("¿desea quitar el producto?");
		return a;
		
	}


</script>
</html>