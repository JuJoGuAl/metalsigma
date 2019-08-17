<?php
require_once("class.bd_connect.php");
class database {
    private $conn;
    private $con_;
    public $table;
    public $fields;
    public $tablekey;
    public $rows_not_upper;

    public function __construct ($table, $key){
        $this->table =$table;
        $this->tablekey =$key;
        /** Por defecto todo valor agregado a la BD es pasado a Mayuscula, sin embargo existen campos donde no se
        debe aplicar dicha regla, por ejemplo claves.
        Creo un arreglo con aquellos campos que no convertire a Mayuscula.
        */
        $this->rows_not_upper =array("clave","picture");
        $this->fields =array ();
        $this->con_ = connect();
        if($this->con_["title"]=="SUCCESS"){
            $this->conn=$this->con_["content"];
        }
        /*try {
            $this->conn = connect();
        } catch (Exception $e){
            $response["title"]="ERROR";
            $response["content"]=strtoupper($e->getMessage());
        }*/
    }
    /** Obtiene los registros de la tabla segun los campos listados en la Classe
    * @param campos_srt: Si es false obtiene los campos de la classe, de lo contrario toma los campos listados
    * @param where_str: Posee la condicion del select, tomando en cuenta sentencias preparadas
    * @param group_str: Condiciones para agrupar
    * @param order_str: Condiciones para ordenar
    * @param having_str: Condiciones de grupo
    * @param limit_str: Condiciones de Limites
    */
    public function getRecords($campos_srt=false,$where_str=false, $group_str=false, $order_str=false, $having_str=false,$limit_str=false){
        $response=array();
        $order =$order_str ? "ORDER BY $order_str" : "ORDER BY $this->tablekey ASC";
        $limit =$limit_str ? "LIMIT $limit_str" : false;
        $campos =$campos_srt ? "$campos_srt" : $this->getAllFields();
        $query = "SELECT $campos FROM {$this->table}";
        $values = $values2 = array();
        if ($where_str) {
            //print_r($where_str)."<br>";
            if(array_key_exists(0, $where_str)){
                $query .= " WHERE $this->tablekey > ?";
                $values[]=0;
                foreach ($where_str as $key => $value) {
                    //Evaluo si un valor es Arreglo
                    if(is_array($value["value"])){
                        $in  = str_repeat('?,', count($value["value"]) - 1) . '?';
                        $query .= " AND ".$value["row"]." ".$value["operator"]." ($in)";                        
                        $values2=array_map('strtoupper', $value["value"]);
                        //dentro del arreglo values, meto el otro arreglo, para permitirlo
                        $values=array_merge($values,$values2);
                    }else{
                        $query .= " AND ".$value["row"]." ".$value["operator"]." ?";
                        $values[]=$value["value"]==null ? $value["value"] : strtoupper($value["value"]);
                    }
                }
            }
        }
        $group = $group_str ? "GROUP BY $group_str" : "" ;
        $having = $having_str ? "HAVING $having_str" : "" ;
        $query .= " $group $having $order $limit";
        //echo $query."<br>";
        //print_r($values)."<br>";
        return $this->validateOperation($query,$values);        
    }
    /** Obtiene un registro de la BD segun su ID
    * @param id: ID a buscar    
    */
    public function getRecord($id){
        $data = array();
        $data[0]["row"]="$this->tablekey";
        $data[0]["operator"]="=";
        $data[0]["value"]=$id;
        return $this->getRecords(false,$data);
    }
    /** Inserta registros en la BD, teniendo en cuenta los campos insertables
    * @param data: arreglo de datos que se insertaran (deben estar en el mismo orden de los campos declarados)
    */
    public function insertRecord($data){
        $response=array();
        $campos_insert =$this->getInsertFields();
        $campos_values =$this->getInsertFields(true);
        $query = "INSERT INTO {$this->table} ($campos_insert) VALUES (";
        foreach ($data as $key => $value) {
            $query .= " ?, ";
            $values[] = (in_array($campos_values[$key], $this->rows_not_upper)) ? $value : mb_strtoupper($value, 'UTF-8') ;
        }
        $query = substr($query,0,-2);
        $query .= " )";
        //echo $query."<br>";
        //print_r($values)."<br>";
        return $this->validateOperation($query,$values);
    }
    public function insertRecords($data){
        $response=array();
        $campos_insert =$this->getInsertFields();
        $campos_values =$this->getInsertFields(true);
        $leng = $this->count_dimension($data);
        //$query = "INSERT INTO {$this->table} ($campos_insert) VALUES (";
        $query = "INSERT INTO {$this->table} ($campos_insert) VALUES ";
        if($leng==1){
            $query .= "( ";
            foreach ($data as $key => $value) {
                $query .= "?, ";
                $values[] = (in_array($campos_values[$key], $this->rows_not_upper)) ? $value : mb_strtoupper($value, 'UTF-8') ;
            }
            $query = substr($query,0,-2);
            $query .= " )";
        }else{
            foreach ($data as $key => $value){
                $query .= "( ";
                foreach ($data[$key] as $key1 => $value1){
                    $query .= "?, ";
                    $values[] = (in_array($campos_values[$key1], $this->rows_not_upper)) ? $value1 : mb_strtoupper($value1, 'UTF-8') ;
                }
                $query = substr($query,0,-2);
                $query .= " ),";
            }
            $query = substr($query,0,-2);
            $query .= ";";
        }
        echo $query."<br>";
        print_r($values)."<br>";
        //return $this->validateOperation($query,$values);
    }
    /** Inserta registros en la BD, si el KEY existe lo actualiza UPSERT
    * para que funcione como se espere, el ID de la tabla debe especificarse en el INSERT si no no disparara
    * el ON DUPLICATE, adicionalmente el INDEX UNIQUE/PRIMARY debe haberse declarado en la tabla en la BD.
    * @param data: arreglo de datos que se insertaran (deben estar en el mismo orden de los campos declarados)
    */
    public function upsertRecord($data){
        $response=array();
        $campos =$this->getInsertFields();
        $campos2 =$this->getEditFields(true);
        $query = "INSERT INTO {$this->table} ($campos) VALUES (";
        foreach ($data as $key => $value) {
            $query .= " ?, ";
            $values[] = (in_array($campos[$key], $this->rows_not_upper)) ? $value : mb_strtoupper($value, 'UTF-8') ;
        }
        $query = substr($query,0,-2);
        $query .= " ) ON DUPLICATE KEY UPDATE ";
        array_shift($data);
        array_shift($campos2);
        foreach ($data as $key => $value) {
            $query .= $campos2[$key]." = ?, ";
            $values[] = (in_array($campos2[$key], $this->rows_not_upper)) ? $value : mb_strtoupper($value, 'UTF-8') ;
        }
        $query = substr($query,0,-2);
        //echo $query."<br>";
        //print_r($values)."<br>";
        return $this->validateOperation($query,$values);
    }
    /** Retorna el ultimo ID insertado (Solo funciona si el ID lo asigna un AutoIncrement)
    */
    public function return_id(){
        return $this->conn->lastInsertId();
    }
    /** Actualiza los datos de una tabla a partir de un id
    * @param id: ID a actualizar
    * @param data: Arreglo con la data a Actualizar, tomando en cuenta el Orden listado en la tabla
    * @param where_str: Posee la condicion del Update, tomando en cuenta sentencias preparadas, si esta seteado ignora $id
    */
    public function updateRecord($id,$data,$where_str=false){
        $campos =$this->getEditFields(true);
        $query = "UPDATE {$this->table} SET ";
        $values = $values2 = array();
        foreach ($data as $key => $value){
            $query .= $campos[$key]." = ?, ";
            $values[] = (in_array($campos[$key], $this->rows_not_upper)) ? $value : mb_strtoupper($value, 'UTF-8') ;
        }
        $query = substr($query,0,-2);
        if ($where_str) {
            //print_r($where_str)."<br>";
            if(array_key_exists(0, $where_str)){
                $query .= " WHERE {$this->tablekey} > ?";
                $values[]=0;
                foreach ($where_str as $key => $value) {
                    //Evaluo si un valor es Arreglo
                    if(is_array($value["value"])){
                        $in  = str_repeat('?,', count($value["value"]) - 1) . '?';
                        $query .= " AND ".$value["row"]." ".$value["operator"]." ($in)";
                        $values2=array_map('strtoupper', $value["value"]);
                        //dentro del arreglo values, meto el otro arreglo, para permitirlo
                        $values=array_merge($values,$values2);
                    }else{
                        $query .= " AND ".$value["row"]." ".$value["operator"]." ?";
                        $values[]=strtoupper($value["value"]);
                    }
                }
            }
        }else{
            $query .= " WHERE {$this->tablekey} = ?";
            $values[]=$id;            
        }
        //echo $query."<br>";
        //print_r($values)."<br>";
        return $this->validateOperation($query,$values);
    }
    /** Elimina registros de la tabla segun las condiciones del Parametro
    * @param where_str: Posee la condicion del delect, tomando en cuenta sentencias preparadas
    */
    public function deleteRecords($where_str=false){
        $query = "DELETE FROM {$this->table}";
        $values = $values2 = array();
        if ($where_str) {
            //print_r($where_str)."<br>";
            if(array_key_exists(0, $where_str)){
                $query .= " WHERE $this->tablekey > ?";
                $values[]=0;
                foreach ($where_str as $key => $value) {
                    //Evaluo si un valor es Arreglo
                    if(is_array($value["value"])){
                        $in  = str_repeat('?,', count($value["value"]) - 1) . '?';
                        $query .= " AND ".$value["row"]." ".$value["operator"]." ($in)";
                        $values=array_merge($values,$value["value"]);
                    }else{
                        $query .= " AND ".$value["row"]." ".$value["operator"]." ?";
                        $values[]=strtoupper($value["value"]);
                    }
                }
            }
        }
        //echo $query."<br>";
        //print_r($values)."<br>";
        return $this->validateOperation($query,$values);
    }
    /** Elimina un registro de la tabla segun el ID
    * @param ID: ID a eliminar    
    */
    public function deleteRecord($id){
        $query = "DELETE FROM {$this->table} WHERE {$this->tablekey} = ?";
        $values[]=$id;
        //echo $query."<br>";
        return $this->validateOperation($query,$values);
    }
    /** Ejecuta directamente una Sentencia
    * @param query: El query a Ejecutar
    */
    public function sql($query){
        if($this->con_["title"]=="SUCCESS"){
            //echo "<br><strong>Query: </strong>".$query;
            $response=array();
            try {
                $object = $this->conn->prepare($query);
                $result =  $object->execute();
                $row_affected = $object->rowCount();
                //La sentencia se ejecuto (no hay error de Sintaxis), procedo a buscar que sentencia fue usada
                if ($result) {
                    if(preg_match('/^SELECT/', $query)){
                        //Es un Select, lo que implica que debo de obtener el resultado.
                        $result = $object->fetchAll(PDO::FETCH_ASSOC);
                        if ($result) {
                            $response["title"]="SUCCESS";
                            $response["rows"]=$row_affected;
                            $response["content"]=$result;
                        }else{
                            $response["title"]="WARNING";
                            $response["content"]="LA SENTENCIA NO DEVOLVIO NINGUN REGISTRO.  QUERY: <strong>".$query."</strong>";
                        }
                    }elseif(preg_match('/^INSERT/', $query)){
                        //Insert consigo el ID insertado, asi mismo como el registro insertado
                        $id=$this->return_id();
                        $response["title"]="SUCCESS";
                        $response["id"]=$id;
                        $response["rows"]=$row_affected;
                        $response["content"]=true;
                    }elseif (preg_match('/^UPDATE|DELETE/', $query)) {
                        //Upate o Delete indago si afecto una o mas filas, de ser asi devuelvo el numero de filas afectadas
                        //$titulo = ($row_affected>0) ? "SUCCESS" : "WARNING" ;
                        //$contenido = ($row_affected>0) ? true : "NINGUN REGISTRO FUE AFECTADO.  QUERY: <strong>".$query."</strong>" ;
                        $titulo="SUCCESS";
                        $contenido=true;
                        $response["title"]=$titulo;
                        $response["id"]=0;//NO HAY ID
                        $response["rows"]=$row_affected;
                        $response["content"]=$contenido;
                    }
                }else{
                    // La sentencia no se Ejectuo
                    $response["title"]="WARNING";
                    $response["content"]="LA SENTENCIA NO SE EJECUTO.  QUERY: <strong>".$query."</strong>";
                }
            } catch (PDOException $e) {
                //PDO arrojo un error lo capturo y lo envio
                $response["title"]="ERROR";
                $response["content"]=$e->getMessage()." QUERY: <strong>".$query."</strong>";
            }
        }else{
            $response["title"]="ERROR";
            $response["content"]=$this->con_["content"];
        }
        //print_r($response);
        return $response;
    }
    // PRIVATE METHODS
    /** Ejecuta la sentencia enviada por los metodos anteriores, para retornar los resultados de aplicar
    * @param query: El query a Ejecutar
    * @param values: Un arreglo con los datos a ejecutar
    */
    private function validateOperation($query,$values){
        if($this->con_["title"]=="SUCCESS"){
            //echo "<br><strong>Query: </strong>".$query."<br><strong>Valores: </strong>";
            //print_r ($values)."<br>";
            //print_r($this->getEditFields(true));
            $response=array();
            try {
                //$this->conn->beginTransaction();
                $object = $this->conn->prepare($query);
                $result =  $object->execute($values);
                //$this->conn->commit();
                $row_affected = $object->rowCount();
                //La sentencia se ejecuto (no hay error de Sintaxis), procedo a buscar que sentencia fue usada
                if ($result) {
                    if(preg_match('/^SELECT/', $query)){
                        //Es un Select, lo que implica que debo de obtener el resultado.
                        $result = $object->fetchAll(PDO::FETCH_ASSOC);
                        if ($result) {
                            $response["title"]="SUCCESS";
                            $response["rows"]=$row_affected;
                            $response["content"]=$result;
                        }else{
                            $response["title"]="WARNING";
                            $response["content"]="LA SENTENCIA NO DEVOLVIO NINGUN REGISTRO.  QUERY: <strong>".$query."</strong>";
                        }
                    }elseif(preg_match('/^INSERT/', $query)){
                        //Insert consigo el ID insertado, asi mismo como el registro insertado
                        $id=$this->return_id();
                        $response["title"]="SUCCESS";
                        $response["id"]=$id;
                        $response["rows"]=$row_affected;
                        $response["content"]=true;
                    }elseif (preg_match('/^UPDATE|DELETE/', $query)) {
                        //Upate o Delete indago si afecto una o mas filas, de ser asi devuelvo el numero de filas afectadas
                        //$titulo = ($row_affected>0) ? "SUCCESS" : "WARNING" ;
                        //$contenido = ($row_affected>0) ? true : "NINGUN REGISTRO FUE AFECTADO.  QUERY: <strong>".$query."</strong>" ;
                        $titulo="SUCCESS";
                        $contenido=true;
                        $response["title"]=$titulo;
                        $response["id"]=0;//NO HAY ID
                        $response["rows"]=$row_affected;
                        $response["content"]=$contenido;
                    }
                }else{
                    // La sentencia no se Ejectuo
                    $response["title"]="WARNING";
                    $response["content"]="LA SENTENCIA NO SE EJECUTO.  QUERY: <strong>".$query."</strong>";
                }
            } catch (PDOException $e) {
                //PDO arrojo un error lo capturo y lo envio
                $response["title"]="ERROR";
                $response["content"]=$e->getMessage()." QUERY: <strong>".$query."</strong>";
            }
        }else{
            $response["title"]="ERROR";
            $response["content"]=$this->con_["content"];
        }
        //print_r($response);
        return $response;
    }    
    private function getFieldsByType ($type=''){
        $return = array ();
        $types = explode ('|', $type);
        foreach ($this->fields as $field){
            foreach ($types as $t){
                if ($field[0] == $t){
                    array_push ($return, $field);
                }
            }
        }
        return $return;
    }
    private function getFields ($type){
        $return = array ();
        $fields = $this->getFieldsByType ($type);
        foreach ($fields as $field){
            array_push ($return, $field[1]);
        }
        return $return;
    }
    private function getEditFields ($asArray=false){
        $return = $this->getFields ('public|public_u');
        return $asArray ? $return : implode (', ', $return);
    }
    private function getInsertFields ($asArray=false){
        $return = $this->getFields ('public|public_i');
        return $asArray ? $return : implode (', ', $return);
    }
    private function getAllFields ($asArray=false){
        $return = $this->getFields ('public|public_i|public_u|system');
        return $asArray ? $return : implode (', ', $return);
    }
    private function count_dimension($Array, $count = 0){
        if(is_array($Array)) {
            return $this->count_dimension(current($Array), ++$count);
        } else {
            return $count;
        }
    }
}
?>