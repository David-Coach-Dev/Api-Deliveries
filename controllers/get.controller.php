<?php
  /************************
   *todo Get Controller.
   ************************/
    /************************
     *! Requerimientos.
    ************************/
      require_once "models/get.model.php";
    /******************************
     *? Class Controller GET
    ******************************/
      class GetController{
        /********************************
         ** Petición GET sin filtro
        ********************************/
          static public function getData($db, $table, $select,
          $orderBy, $orderMode, $startAt, $endAt){
            $response = GetModel::getData($db, $table, $select,
                $orderBy, $orderMode, $startAt, $endAt);
            $return = new GetController();
            $return -> fncResponse($response,"getData");
          }
        /********************************
         ** Petición GET con filtro
        ********************************/
          static public function getDataFilter($db, $table, $select,
            $linkTo, $equalTo, $orderBy, $orderMode, $startAt, $endAt){
            $response = GetModel::getDataFilter($db, $table, $select,
              $linkTo,$equalTo, $orderBy, $orderMode, $startAt, $endAt);
            $return = new GetController();
            $return -> fncResponse($response,"getDataFilter");
          }
        /************************************************************
          ** Petición Get con tablas relacionadas.
        ************************************************************/
          static public function getRelData($db, $rel, $type,
            $select, $orderBy, $orderMode, $startAt, $endAt){
            $response = GetModel::getRelData($db, $rel, $type,
              $select, $orderBy, $orderMode, $startAt, $endAt);
            $return = new GetController();
            $return->fncResponse($response,"getRelData");
          }
        /*************************************************************
         ** Petición Get con tablas relacionadas con filtros .
        *************************************************************/
          static public function getRelDataFilter($db, $rel, $type,
            $select, $linkTo, $equalTo, $orderBy, $orderMode,
            $startAt, $endAt){
            $response = GetModel::getRelDataFilter($db, $rel, $type,
              $select, $linkTo, $equalTo, $orderBy, $orderMode,
              $startAt, $endAt);
            $return = new GetController();
            $return->fncResponse($response,"getRelDataFilter");
          }
        /****************************************************
        ** Petición Get para buscadores
        *****************************************************/
          static public function getDataSearch($db, $table, $select,
            $linkTo, $searchTo, $orderBy, $orderMode, $startAt, $endAt){
            $response = GetModel::getDataSearch($db, $table, $select,
              $linkTo, $searchTo, $orderBy, $orderMode, $startAt, $endAt);
            $return = new GetController();
            $return->fncResponse($response,"getDataSearch");
          }
        /*************************************************************
         ** Petición Get para buscadores con tablas relacionadas.
        *************************************************************/
          static public function getRelDataSearch($db, $rel, $type, $select,
            $linkTo, $searchTo, $orderBy, $orderMode, $startAt, $endAt){
            $response = GetModel::getRelDataSearch($db, $rel, $type, $select,
              $linkTo, $searchTo, $orderBy, $orderMode, $startAt, $endAt);
            $return = new GetController();
            $return->fncResponse($response,"getRelDataSearch");
          }
        /*************************************************************
         ** Petición Get con rangos.
        *************************************************************/
          static public function getDataRange($db, $table, $select,
            $linkTo, $betweenIn, $betweenOut, $orderBy, $orderMode,
            $startAt, $endAt, $filterTo, $inTo){
            $response = GetModel::getDataRange($db, $table, $select,
              $linkTo, $betweenIn, $betweenOut, $orderBy, $orderMode,
              $startAt, $endAt, $filterTo, $inTo);
            $return = new GetController();
            $return->fncResponse($response,"getDataRange");
          }
        /*************************************************************
         ** Petición Get con rangos con tablas relacionadas.
        *************************************************************/
          static public function getRelDataRange($db, $rel, $type, $select,
            $linkTo, $betweenIn, $betweenOut, $orderBy, $orderMode, $startAt,
            $endAt, $filterTo, $inTo){
            $response = GetModel::getRelDataRange($db, $rel, $type, $select,
              $linkTo, $betweenIn, $betweenOut, $orderBy, $orderMode, $startAt,
              $endAt, $filterTo, $inTo);
            $return = new GetController();
            $return->fncResponse($response,"getRelDataRange");
          }
        /*******************************
        ** Respuesta del controlador
        *******************************/
          public function fncResponse($response,$method){
            if(!empty($response)){
              $json = array(
                "status" => 200,
                "method" => $method,
                "total" => count($response),
                "detalle" => $response
              );
            }else{
              $json = array(
                "status" => 404,
                "detalle" => "not found...",
                "method" => $method
              );
            }
            echo json_encode($json, http_response_code($json["status"]));
          }
      }
?>