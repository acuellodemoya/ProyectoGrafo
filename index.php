<?php
include("grafo.php");

session_start();
if (!isset($_SESSION['grafo'])) {
	$_SESSION['grafo'] = new Grafo;
}
?>

<html>
<head>
	<link rel="stylesheet" href="estilos.css">
	<link href="vis/dist/vis.css" rel="stylesheet" type="text/css">
	<script type="text/javascript" src="vis/dist/vis.js"></script>
	

	<style type="text/css">
		#grafoProyecto{
			width: 450px; 
			height: 300px; 
			border: 1.5px solid #17202A;
			top: 200px ;
			bottom: 100px;
			left: 810px;
			position: absolute;
			
		}

	</style>
</head>

<body>
	<h1><center>Proyecto grafos </center></h1>
	<p><center>
		Alejandro Cuello<br>
		Maria Maza<br>
		Gabriel Sandoval
	</center>
</p>

<div style= "text-align: right;"><h2>Ver Grafo<img src="vis/lib/Network/img/grafo.png" style="max-width: 45px; max-height: 45px"></h2></div>

<h2>Agregar vertice </h2>
<form action="index.php" method="post">
	<img src="vis/lib/Network/img/agregar.png" style="max-width: 30px; max-height: 30px"> 
	ID Vertice: <input type="text" name="idAgregarVertice">
	<input type="submit" value="Agregar" id="btnAgregarVertice">
</form>


<h2>Agregar Arista</h2>
<form action="index.php" method="post">
	<img src="vis/lib/Network/img/agregar.png" style="max-width: 30px; max-height: 30px">
	Vertice Origen: <input type="text" name="idVerticeOrigen"><br>
	Vertice Destino: <input type="text" name="idVerticeDestino">
	Peso: <input type="text" name="pesoArista">
	<input type="submit" value="Agregar" id="btnAgregarArista">
</form>

<h2>Ver Vertice</h2>
<form action="index.php" method="post">
	<img src="vis/lib/Network/img/ververtice.png" style="max-width: 40px; max-height: 40px">
	ID Vertice: <input type="text" name="idVerVertice">
	<input type="submit" value="Ver" id="btnVerVertice">
</form>

<h2>Ver Adyacentes</h2>
<form action="index.php" method="post">
	<img src="vis/lib/Network/img/adyacentes.png" style="max-width: 40px; max-height: 40px">
	ID Vertice: <input type="text" name="idVerticeAdyacentes">
	<input type="submit" value="Ver" id="btnVerAdyacentes">
</form>

<h2>Ver Grado</h2>
<form action="index.php" method="post">
	<img src="vis/lib/Network/img/grado.png" style="max-width: 40px; max-height: 40px">
	ID vertice: <input type="text" name="idVerticeGrado">
	<input type="submit" value="Ver" id="btnVerGrado">
</form>

<h2>Eliminar vertice</h2>
<form action="index.php" method="post">
	<img src="vis/lib/Network/img/eliminar.png" style="max-width: 30px; max-height: 30px">
	ID vertice: <input type="text" name="idVerticeEliminar">
	<input type="submit" value="Eliminar" id="btnEliminarVertice">
</form>

<h2>Eliminar Arista</h2>
<form action="index.php" method="post">
	<img src="vis/lib/Network/img/eliminar.png" style="max-width: 30px; max-height: 30px">
	Vertice Origen: <input type="text" name="idVerticeOrigenEliminar">
	Vertice Destino: <input type="text" name="idVerticeDestinoEliminar">
	<input type="submit" value="Eliminar" id="btnEliminarArista">
</form>


<?php
		
			//Agregar Vertice
if(isset($_POST["idAgregarVertice"])){
	$verticeAgregar = new Vertice($_POST["idAgregarVertice"]);
	if (!$_SESSION["grafo"]->existente($verticeAgregar)) {
		$_SESSION["grafo"]->agregarVertice($verticeAgregar);
		echo "¡El vertice fue agregado con exito! y es: ". $verticeAgregar->getID();
	} else {
		echo "El vertice ya existe, no fue creado nuevamente...";
	}
}

		//Agregar Arista
		if (isset($_POST ["idVerticeOrigen"],$_POST ["idVerticeDestino"],$_POST ["pesoArista"])){
			$a = $_SESSION['grafo']->agregarArista ($_POST["idVerticeOrigen"],$_POST["idVerticeDestino"],$_POST["pesoArista"]);
			if ($a != null ){
				echo "<br><hr> Arista agregada ";
			}
			else {
				echo "Verifique que las vertices existan o los datos ingresados sean correctos";
			}
		}

			//ver Adyacentes
        if (isset($_POST['idVerticeAdyacentes'])) {
                if (isset($_POST["idVerticeAdyacentes"])) {
                    $array = $_SESSION['grafo']->getAdyacentes($_POST["idVerticeAdyacentes"]);
                    foreach($array as $key => $val) {
                        print "El vertice es adyacente a $key. <br>";
                    }
                }
            }

		//ver Vertice
		if (isset($_POST["idVerVertice"])) {
			$v = $_SESSION ['grafo']->BuscarVertice($_POST["idVerVertice"]);
			if ($v == false) {
				echo "No existe el vertice!";
			} else {
				print_r($_SESSION['grafo']->getVertice($_POST["idVerVertice"]));
			}
		}

			
			//Ver grado
		if (isset($_POST["idVerticeGrado"])) {
			$verticeGrado = new Vertice($_POST["idVerticeGrado"]);
			$idVertice = $verticeGrado->getId();
			$confirmado = $_SESSION["grafo"]->existente($verticeGrado);
			if ($confirmado) {
				echo "El grado del vertice es: " . $_SESSION["grafo"]->grado($idVertice);
			} else {
				echo "El vertice al que desea ver el grado, no existe";
			}

		}
		

		//Eliminar vertice
	if(isset($_POST["idVerticeEliminar"])){
		$verticeEliminar = new Vertice($_POST["idVerticeEliminar"]);

		if ($_SESSION['grafo']->existente($verticeEliminar)) {
			$_SESSION['grafo']->eliminarVertice($verticeEliminar);
			echo "¡El vertice fue eliminado con exito!";
		} else {
			echo "El vertice no existe, verifique su ID";
		}

	}

				//Eliminar arista
	if(isset($_POST["idVerticeOrigenEliminar"])){
		$vOrigen = new Vertice($_POST["idVerticeOrigenEliminar"]);
		$vDestino = new Vertice($_POST["idVerticeDestinoEliminar"]);
		$eliminado = $_SESSION['grafo']->eliminarArista($vOrigen, $vDestino);
		if ($eliminado) {
			echo "¡La arista fue eliminada con exito!";
		} else {
			echo "Alguno de los vertices no fue colocado correctamente o no existe <br> o hay campos en blanco, verifique";
		}

	}
	?>



<div id="grafoProyecto" >


</div>


<script type="text/javascript">

	var nodos = new vis.DataSet([
		<?php 
		$v = count ($_SESSION['grafo']->getVectorV());
		$cantidad = 0;
		foreach ($_SESSION['grafo']->getVectorV() as $ind => $adyacente) {
			$cantidad++;
			if($cantidad==$v){
				echo "{id:'$ind',label: '$ind'}";
			}else{
				echo "{id:'$ind',label: '$ind'},";
			}

		}
		?>
		]);



	var aristas = new vis.DataSet([
		<?php 
		$s = count ($_SESSION['grafo']->getMatrizA());
		foreach ($_SESSION['grafo']->getMatrizA() as $t => $adyac) {
			if($adyac!=null){
				foreach ($adyac as $u => $m) {
					if($t == null){
						echo "{from: '$t', to: '$u', label: '$m'}";
					}else{
						echo "{from: '$t', to: '$u', label: '$m'},";
					}
				}
			}
		}
		?>
		]);

	var contenedor = document.getElementById("grafoProyecto");

	var datos = {
		nodes: nodos,
		edges: aristas
	};


	var opciones = {
		edges:{
			arrows:{
				to:{
					enabled: true
				}
			}
		},
		configure:{
			enabled:true,
			container:undefined,
			showButton: true
		}
	};

	var grafo = new vis.Network(contenedor,datos, opciones);

</script>

</body>
</html>

