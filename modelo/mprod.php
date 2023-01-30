<?php
class mprod{

	//-----metodos productos---------
	#seleccionar todos los productos
	public function selprod(){
		$resultado = NULL;
		$modelo = new conexion();
		$conexion = $modelo->get_conexion();
		$sql ="SELECT p.id,p.nombre,p.precio,p.can FROM productos AS p ORDER BY id";

		$result =$conexion->prepare($sql);
		$result->execute();
		while($f=$result->fetch()){
			$resultado[]=$f;
		}
		return $resultado;

	}

	#seleccionar un producto por su id
	public function selprod1($id){
		$resultado=null;
		$modelo = new conexion();
		$conexion = $modelo->get_conexion();
		$sql = "SELECT p.id,p.nombre,p.precio,p.can FROM productos AS p WHERE p.id=:id;";
		//echo "<br><br><br><br>".$sql."<br>";
		$result = $conexion->prepare($sql);
		//echo $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$result->bindParam(':id',$id);
		$result->execute();

		while($f=$result->fetch()){
			$resultado[]=$f;
		}
		
		return $resultado;
	}


	// PEDIDO //
	#insertar un pedido(en si seria un detalle de pedido), se utiliza un procedimiento almacenado
	public function pediu($idped,$idpro,$idfac,$cant){

		$modelo = new conexion();
		$conexion = $modelo->get_conexion();
		$sql ="CALL pediu(:idped,:idpro,:idfac,:cant);";
		//echo "<br><br>".$sql."<br><br><br>";
		$result = $conexion->prepare($sql);
		//echo $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$result->bindParam(':idped',$idped);
		$result->bindParam(':idpro',$idpro);
		$result->bindParam(':idfac',$idfac);
		$result->bindParam(':cant',$cant);
		if(!$result){
			echo "<script>alert('parece que hubo un error...');</script>";
		}else{
		$result->execute();
		}
	}

	//FACTURA//
	#metodo insertar factura, se utiliza un procedimiento almacenado
	public function faciu($idfac,$fecfac){
		$modelo = new conexion();
		$conexion = $modelo->get_conexion();
		$sql = "CALL faciu(:idfac,:fecfac);";
		//echo "<br><br>".$sql."<br><br><br>";
		$result = $conexion->prepare($sql);
		//echo $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$result->bindParam(':idfac',$idfac);
		$result->bindParam(':fecfac',$fecfac);
		if(!$result){
			echo "<script>alert('parece que hubo un error...');</script>";
		}else{
		$result->execute();
		}

	}

	#metodo seleccionar factura se tomaria por su fecha en caso de una idea diferente de negocio, se utilizarian mas parametros...
	public function selfact1($fechfac){
		$resultado = null;
		$modelo = new conexion();
		$conexion = $modelo->get_conexion();
		$sql = "SELECT f.idfac,f.fechfac FROM factura AS f WHERE f.fechfac=:fechfac";
		//echo "<br><br>".$sql."<br><br><br>";
		$result = $conexion->prepare($sql);
		//echo $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$result->bindParam(':fechfac',$fechfac);
		$result->execute();
		while($f=$result->fetch()){
			$resultado[]=$f;
		}
		return $resultado;
	}
}