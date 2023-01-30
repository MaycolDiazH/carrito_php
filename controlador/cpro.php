<?php

require_once 'modelo/conexion.php';
require_once 'modelo/mprod.php';


$arc='index.php';
$mprod = new mprod();

//variables que se van a utilizar con operadores ternarios, si la variable esta declarada se deja declarada sino se deja nula...
$id = isset($_POST['id']) ? $_POST['id']:NULL;
if(!$id)
	$id = isset($_GET['id']) ? $_GET['id']:NULL;
$nombre = isset($_POST['nombre']) ? $_POST['nombre']:NULL;
if(!$nombre)
	$nombre = isset($_GET['nombre']) ? $_GET['nombre']:NULL;
$precio = isset($_POST['precio']) ? $_POST['precio']:NULL;
if(!$precio)
	$precio = isset($_GET['nombre']) ? $_GET['precio']:NULL;

$accion = isset($_POST["accion"]) ? $_POST['accion']:NUll;
if(!$accion)
	$accion= isset($_GET['accion']) ? $_GET['accion']:NULL;
$can= isset($_POST['can']) ? $_POST['can']:NULL;
if(!$can)
	$can= isset($_GET['can']) ? $_GET['can']:NULL;

$idfac= isset($_POST['idfac']) ? $_POST['idfac']:NULL;
if($idfac)
	$idfac = isset($_GET['idfac']) ? $_GET['idfac']:NULL;

$carro=isset($_POST['carro']) ? $_POST['carro']:NULL;
	if($carro)
		$carrocarro=isset($_GET['carro']) ? $_GET['carro']:NULL;

// la misma comprobacion de que la variable de sesion este declara...
if(!isset($_SESSION['carrito'])){
	$_SESSION['carrito']= array();
}


//agregar el producto y la cantidad en el carrito
if($accion=="agrecar"){
	$carro=array('id'=>$id,
	'nombre'=>$nombre,
	'precio'=>$precio,
	'cantidad'=>$can);

	$num = -1;//se declara una variable de indexación para recorrer el carrito segun los arrays... 
	//se inicializa -1 
	
	//se inicia un ciclo for 
	for($i = 0; $i < count($_SESSION['carrito']); $i++){
		//se crea una condición si el id del carrito es igual al id(en este caso del array carro) el contador $num aumenta.
		if($_SESSION['carrito'][$i]['id']==$id){
			//el contador $num aumenta(si estaba en -1 cambiaria a 0...)
			$num= $i;
			break;//si encuentra un valor igual al id de la variable "carrito" para con el contador con el indice obtenido(num)...
		}
	}

	//si el contador $num esta en -1, se hace un array push(porque el carrito estaria vacio...)
	if($num == -1){
		array_push($_SESSION['carrito'],$carro);
	}else{
	//sino, entonces hace un cambio de la cantidad en el array encontrado en el carrito con el indice $num...
		$_SESSION['carrito'][$num]['cantidad'] = $can;
	}
	//se crea un alert y redireccionamiento...
	echo "<script>alert('producto agregado');</script>";
	echo '<script>window.location="index.php";</script>';
}


if($accion=='ElMn'){
	$num = -1;//se inicializa la variable num en -1
	#se inicia un ciclo for
    for ($i = 0; $i < count($_SESSION['carrito']); $i++) {
		#si encuentra en el array del carrito un valor igual al del id enviado...
        if ($_SESSION['carrito'][$i]['id'] == $id) {
			#se le asigna el valor de i segun el array que tiene el mismo id...
            $num = $i;
			#se hace un break para que $num quede con el valor que en la variable i quedo...
            break;
        }
    }
	#se hace una condicion para que elimine el array con la funcion array splice enviando un nuevos valores 
	#o  en este caso eliminando el array contenido en el array del carrito...
    if ($num != -1) {
        array_splice($_SESSION['carrito'], $num, 1);
    }
	#se crea un alert y un redireccionamiento
	echo "<script>alert('producto eliminado');</script>";
	echo '<script>window.location="index.php";</script>';
}


//vaciar carrito(vacia totalmente el carrito)
if($accion=="vaciar"){
	unset($_SESSION['carrito']);
	$_SESSION['carrito']= array();
}



//accion de realizar compra...
if($accion=="comprar"){
	timezone_set('America/Bogota');
	$fecfac = Date('Y-m-d h:i:s:');
	$mprod->faciu("",$fecfac);//metodo de crear factura con sus parametros...
	$fac = $mprod->selfact1($fecfac);//metodo de seleccionar factura con sus parametros...
	foreach ($_SESSION['carrito'] as $car) {
		$mprod->pediu("",$car['id'],$fac[0]['idfac'],$car['cantidad']);//se hace un foreach para que haga la incersion de cada articulo en el carro toma la factura creada con antelación y la asigna a determinada cantidad de articulos que se encuentren en el carro... idpedido(auto_increment) idpro='id' idfactura='idfac' cantidad='cantidad'; 
	}
	//se envia la variable de sesion cque quede vacia nuevamente para insertar nuevos productos...
	$_SESSION['carrito']=array();
	
}





//mostrar productos registrados de la tabla "productos"
function mosdatos(){
	$mprod = new mprod();
	$tot = $mprod->selprod();
	$constr = '';
	$constr .='<table>';
	$constr .= '<thead>';
		$constr .= '<tr>';
		$constr .= '<th>Id_producto</th>';
		$constr .= '<th>nombre</th>';
		$constr .= '<th>precio</th>';
		$constr .= '<th>Existencias</th>';
		$constr .= '</tr>';
	$constr .= '</thead>';
	$constr .= '<tbody>';
	foreach ($tot as $dtpro) {
		$constr .= '<tr>';
			$constr.= '<form name="frm1" action="index.php"method="POST">';
			$constr.='<td>'.$dtpro["id"].'</td>';
			$constr.='<td>'.$dtpro["nombre"].'</td>';
			$constr.='<td>'.$dtpro["precio"].'</td>';
			$constr.='<td>'.$dtpro["can"].'</td>';
			$constr.='<td>';
				$constr.='<a href="index.php?pg=908&id='.$dtpro["id"].'">';
					$constr .= '<button type="button">Ver</button>';
				$constr .= '</a>';
			$constr.='</td>';
		$constr .= '</tr>';
		}
	$constr.='</form>';
	$constr .= '</table>';

	echo $constr;
		
}


//modal de mostrar los articulos en el carro...
function moscarr(){
	$mprod = new mprod();
	$constr = '';
	$constr .='<div class="modal fade" id="carrito" tabindex="-1" aria-labelledby="carrito" aria-hidden="true">';
  	$constr.='<div class="modal-dialog">';
    $constr.='<div class="modal-content">';
      $constr.='<div class="modal-header">';
        $constr.='<h5 class="modal-title">Productos</h5>';
        $constr.='<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>';
      $constr.='</div>';
      $constr.='<div class="modal-body">';
      $total=0;
      	if($_SESSION['carrito']){
      		
      		$constr.='<table class="table">';
      				$constr.= '<thead>';
      					$constr.= '<tr>';
	      					 $constr.='<th scope="col">Nombre</th>';
	      					 $constr.='<th scope="col">Precio</th>';
	      					 $constr.='<th scope="col">Cantidad</th>';
	      					 $constr.='<th scope="col">Subtotal</th>';
      					$constr .= '</tr>';
      					$constr.= '</thead>';
      					$constr.='<tbody>';
      					
      		foreach($_SESSION['carrito'] as $carr){
      			$subtotal = $carr['cantidad']*$carr['precio'];
      			$total += $subtotal; 
    					$constr.='<tr>';
				      		$constr.='<th scope="row">'.$carr['nombre'].'</th>';
				      		$constr.='<td>'.$carr['precio'].'</td>';
				      		$constr.='<td>'.$carr['cantidad'].'</td>';
				      		$constr.='<td>'.$subtotal.'</td>';
							$constr.= '<td>';
							$constr .= '<a href="index.php?pg=808&accion=ElMn&id='.$carr['id'].'" onclick="return quitar();">';
									$constr .= '<i class="fas fa-trash-alt fa-1x" style="margin:10px"></i>';
								$constr.='</a>';
							$constr.='</td>';
				    	$constr.='</tr>';
        	}
        	
    	}else{
    		$constr.= '<p>carrito vacio</p>';
    	}
    		$constr.='<th scope="row">Total: '.$total.'</th>';
		    $constr.='</tbody>';
			$constr.='</table>';
      $constr.='</div>';
      $constr.='<div class="modal-footer">';
      if($_SESSION['carrito']){
     	$constr.='<form action="index.php?pg=707" method="POST">';
        	$constr.='<input type="submit" class="btn btn-primary" value="comprar" onclick="comprar();">';
        		$constr.='<input type="hidden" name="accion" value="comprar">';
        $constr.='</form>';
      }
        $constr.='<form action="index.php" method="POST">';
        $constr.='<input type="submit" class="btn btn-secondary" value="vaciar" onclick="eliminar();">';
        		$constr.='<input type="hidden" name="accion" value="vaciar">';
    		$constr.='</form>';
      $constr.='</div>';
    $constr.='</div>';
  $constr.='</div>';
$constr.='</div>';

$constr.='<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#carrito">';
  $constr.='<i class="fa-solid fa-cart-shopping">( ';
  $constr .=count($_SESSION['carrito']);
	 
$constr.=' )</i></button>';
echo $constr;
}



//muestra el producto para agregarlo al carro
function vdprod($id,$arc){
	$mprod= new mprod();
	$dtdprod = NULL;
	$dtdprod = $mprod->selprod1($id);
	$constr='';
	$constr .= '<h1>'.$dtdprod[0]["nombre"].'</h1>';
	if($dtdprod){
		$constr.='<form action="'.$arc.'?pg=707" method="POST">';
			$constr.='<input type="hidden" name="id" value="'.$dtdprod[0]["id"].'">';
			$constr.='<input type="hidden" name="nombre" value="'.$dtdprod[0]["nombre"].'">';
			$constr.='<input type="hidden" name="precio" value="'.$dtdprod[0]["precio"].'">';
			$constr.='<input type="number" name="can">';
			$constr .='<input type="hidden" name="accion" value="agrecar">';//agregar al carrito
			$constr .= '<input  class="btn btn-primary" type="submit" value="agregar">';
		$constr.='</form>';
	}else{
		$constr.="<h1>No hay productos registrados...</h1>";
	}
	//print_r($_SESSION["carrito"]);
	echo $constr;
}
?>