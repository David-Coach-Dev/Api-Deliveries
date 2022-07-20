<?php
  /****************************************
   *todo Connection.
   ****************************************/
    /****************************************
     *! Requerimientos.
    ****************************************/
      require_once "models/get.model.php";
    /******************************
     *?Class Connection
    ******************************/
      class Connection{
        /********************************
         ** Información de la DB.
        ********************************/
          static public function infoDatabase($db){
            /********************************
             *? Información de la DB Sql.
            ********************************/
              $infoSqlDB = array(
                "base"=>"mysql",
                "host"=>"localhost",
                "database" => "deliveries",
                "user" => "root",
                "pass" => "",
                "port"=>3306
              );
            /********************************
             *? Información de la DB PgSql.
            ********************************/
              $infoPgSqlDB = array(
                "base"=>"pgsql",
                "host"=>"ec2-3-223-169-166.compute-1.amazonaws.com",
                "database" => "d1mvga7irad67n",
                "user" => "dbcwalnvizknns",
                "pass" => "5cfded1cccb6f48ad3ca1a1ecd3714bbccbd0910e35d120af63770804155ce49",
                "port"=> 5432,
              );
            /***************************************
             *? Retorno de la DB seleccionada.
            ***************************************/
              // 1 - SQL
              if($db == 1){
                return $infoSqlDB;
              }
              // 2 - PGSQL
              if($db == 2){
                return $infoPgSqlDB;
              }
          }
        /********************************
         ** Conexión a la DB.
        ********************************/
          static public function connect($db){
            /************************************************
             *? Colección a la DB.
            ************************************************/
              try {
                /********************************
                 *? Conexión a la DB.
                ********************************/
                    $link=new PDO(Connection::infoDatabase($db)["base"].":host=".Connection::infoDatabase($db)["host"]
                                    .";port=".Connection::infoDatabase($db)["port"]
                                    .";dbname=".Connection::infoDatabase($db)["database"],
                                    Connection::infoDatabase($db)["user"],
                                    Connection::infoDatabase($db)["pass"]);
                    if($db==1){
                      $link->exec("set names utf8");
                    }
              /************************************************
               *? Capturar error de confección a la DB.
              ************************************************/
                }catch (PDOException $e){
                  die("Error: ".$e->getMessage());
                }
              /************************************************
               *? Retorno de la función conectar.
              ************************************************/
                return $link;
              }
        /*************************************************
         ** validar existencia de una tabla en la DB
        *************************************************/
          static public function getColumnsData($db, $table, $columns){
            /*****************************************
            *? Traer nombre de la base de la DB
            ******************************************/
              $database=Connection::infoDatabase($db)["database"];
            /*****************************************
            *? traer el nombre la columnas de la DB
            ******************************************/
              $validate = Connection::Connect($db)
                ->query("SELECT COLUMN_NAME AS item
                        FROM information_schema.columns WHERE table_schema ='$database'
                        AND table_name = '$table'")
                ->fetchAll(PDO::FETCH_OBJ);
            /**********************************************
            *? Validación de la existencia de la tabla.
            ***********************************************/
              if(empty($validate)){
                return null;
              }else{
                /*******************************
                 *? Validación select = *
                *******************************/
                  if($columns[0] == "*"){
                    array_shift($columns);
                  }
                /***************************************************
                 *? Validación de la existencia de las columnas.
                ***************************************************/
                  $sum=0;
                  foreach ($validate as $key => $value) {
                    $sum+=in_array($value->item, $columns);
                  }
                return $sum == count($columns) ? $validate : null;
              }
          }
        /*************************************************
         ** Generar token de autorización de usuario
        *************************************************/
          static public function jwt($id, $email){
            $time=time();
            $token= array(
              //tiempo en que inicia el token en el email
              "init"=>$time,
              //tiempo de expiración del token
              "exp"=>$time+(60*60*24),//(60*5)
              //Datos del usurario para el token
              "data" =>[
                "id" => $id,
                "email"=>$email
              ]
            );
            return $token;
          }
        /*************************************************
         ** Generar code de autorización de usuario
        *************************************************/
          static public function code($id, $email){
            $time=time();
            $code= array(
              //tiempo en que inicia el code en el email
              "init"=>$time,
              //tiempo de expiración del code
              "exp"=>$time+(60*5),
              //Datos del usurario para el code
              "data" =>[
                "id" => $id,
                "email"=>$email
              ]
            );
            return $code;
          }
      }
?>