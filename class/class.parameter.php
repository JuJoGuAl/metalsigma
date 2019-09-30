<?php
class parametros{
	private $db;
	public $table;
	public $tId;
	
	public function __construct(){
		include_once('class.bd_transsac.php');
		$this->table = "adm_parametro";
		$this->tId = "cparametro";
		$this->db = new database($this->table, $this->tId);
		$this->db->fields = array (
			array ("system",	"parametro"),
			array ("system",	"descripcion"),
			array ("system",	"block"),
			array ("public",	"valor"),
			array ("public_i",	"crea_user"),
			array ("public_u",	"mod_user"),
			array ("system",	"LPAD($this->tId,10,0) AS codigo")
		);
	}
	public function list_parametros($privados=false){
		$data = array ();
		if($privados!==false){
			$data[0]["row"]="block";
			$data[0]["operator"]="=";
			$data[0]["value"]=$privados;
		}
		return $this->db->getRecords(false,$data);
	}
	//OBTENER
	public function get_parametro($id){
		$result=array();
		$result=$this->db->getRecord($id);
		if($result["title"]=="SUCCESS"){
			$result["content"]=$result["content"][0];
		}
		return $result;
	}
	//ACTUALIZAR
	public function edit_parametro($id,$data){
		$data[]=$_SESSION['metalsigma_log'];
		return $this->db->updateRecord($id,$data);
	}
}
?>