<?php
include("vertice.php");
Class Grafo{


	private $matrizA;
	private $vectorV;
	private $dirigido;

	public function __construct($dir = true){
		$this->matrizA = null;
		$this->vectorV = null;
		$this->dirigido = $dir;
	}

		//recibe objeto tipo vertice, no pueden repetirce id
	public function agregarVertice($v){
		if(!isset($this->vectorV[$v->getId()])){
			$this->matrizA[$v->getId()] = null;
			$this->vectorV[$v->getId()] = $v;
		} else{
			return false;
		}
		return true;

	}


	public function getVertice($v){
		return $this->vectorV[$v];
	}


	public function existente($v){
		if(isset($this->vectorV[$v->getId()])){
			return true;
		}
		else{
			return false;
		}
	}

	public function BuscarVertice($vertice) {
		if (!isset($this->vectorV[$vertice])) {
			return false;
		} else {
			return true;
		}
	}


		//recibe id de nodo origen, destino y peso (opcional)
	public function agregarArista($o, $d, $p = null){
		if (isset($this->vectorV[$o]) && isset($this->vectorV[$d])){
			$this->matrizA[$o][$d] = $p;
		}else{
			return false;
		} 

		return true;
	}
		/*public function agregarArista($o, $d, $p = null){
			$po= $o->getId(); $pd= $d->getId();
			if (isset($this->vectorV[$po]) && isset($this->vectorV[$pd])){
				$this->matrizA[$po][$pd] = $p;
			}else{
				return false;
			} 

			return true;
		}*/


		//recibe id de nodo y retorna en un arreglo sus adyacentes.
		public function getAdyacentes($v){
			return $this->matrizA[$v];
		}

		public function getMatrizA(){
			return $this->matrizA;
		}

		public function getVectorV(){
			return $this->vectorV;
		}

		//recibe el id del vertice y retorna grado de salida del mismo
		public function gradoSalida($v){

			return count($this->matrizA[$v]);

		}

		public function gradoEntrada($v){
			$gr = 0;
			if ($this->matrizA != null){
				foreach ($this->matrizA as $vp => $adya) {
					if($adya !=null){
						foreach ($adya as $de => $pe) {
							if($de == $v){
								$gr++;
							}
						}
					}
				}
			}

			return $gr;
		}

		//recibe el id del vertice y retorna grado del mismo
		public function grado($v){

			return $this->gradoSalida($v) + $this->gradoEntrada($v);

		}

		//recibe id de vertice origen y destino
		public function eliminarArista($o, $d){
			$io=$o->getId(); $id=$d->getId();
			if (isset($this->matrizA[$io][$id])){
				unset($this->matrizA[$io][$id]);
			}else{
				return false;
			}
			return true;
		}

		//recibe id de vertice a eliminar, elimina aristas relacionadas

		/*public function eliminarVertice($v){
			if(isset($this->vectorV[$v])){
				foreach ($this->matrizA as $vp => $adya) {
					if($adya !=null){
						foreach ($adya as $de => $pe) {
							if($de == $v){
								unset($this->matrizA[$vp][$de]);
							}
						}
					}
				}
				unset($this->matrizA[$v]);
				unset($this->vectorV[$v]);
			} else{
				return false;
			}
			return true;

		}*/
		public function eliminarVertice($v){
			$iv=$v->getId();
			if(isset($this->vectorV[$iv])){
				foreach ($this->matrizA as $vp => $adya) {
					if($adya !=null){
						foreach ($adya as $de => $pe) {
							if($de == $iv){
								unset($this->matrizA[$vp][$de]);
							}
						}
					}
				}
				unset($this->matrizA[$iv]);
				unset($this->vectorV[$iv]);
			} else{
				return false;
			}
			return true;

		}

	}

		?>