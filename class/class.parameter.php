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
			array ("public",	"valor"),
			array ("system",	"block"),
			array ("public_i",	"crea_user"),
			array ("public_u",	"mod_user"),
			array ("system",	"LPAD($this->tId,10,0) AS codigo")
		);
	}
	public function list_(){
		$data = array ();
		$data[0]["row"]="block";
		$data[0]["operator"]="=";
		$data[0]["value"]=0;
		$resultado = false;
		return $this->db->getRecords(false,$data);
	}
	public function list_all(){
		return $this->db->getRecords();
	}
	//OBTENER
	public function get_($id){
		$result=array();
		$result=$this->db->getRecord($id);
		if($result["title"]=="SUCCESS"){
			$result["content"]=$result["content"][0];
		}
		return $result;
	}
	//ACTUALIZAR
	public function edit_($id,$data){
		$data[]=$_SESSION['user_log'];
		return $this->db->updateRecord($id,$data);
	}
}
?>