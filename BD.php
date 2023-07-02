<?php 

class base{

    public $res;
    public $con;

    public function __construct()
    {
      //return new base();
    }
    
    public function conectar(){
    	$this->con=mysqli_connect("localhost","root","","cochera");
      // $this->con=mysqli_connect("127.0.01","root","Mysql1337","cochera2");
        if(!$this->con){
            die("Error: " . mysqli_connect_error());
            exit();
        }
    }

    public function query($q){
        $this->res = mysqli_query($this->con, $q);
        if (!$this->res) {
            $error = mysqli_error($this->con);
            return $error; // Devuelve el mensaje de error de MySQL
        }
        return true;
    }

    public function fetch(){
        $row= mysqli_fetch_assoc($this->res);
        if(!$row) {

         return null;
        }
        return $row;
    }
    public function fetchAll() {
        $rows = array();
        while ($row = $this->fetch()) {
            $rows[] = $row;
        }
        return $rows;
    }

    public function row(){
        $row= mysqli_num_rows($this->res);
        
        return $row;
    }
}
?>      