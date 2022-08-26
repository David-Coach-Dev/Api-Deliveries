<?php
  /************************
   *todo Get Controller.
   ************************/
    /************************
     *! Requerimientos.
    ************************/
      require_once "models/get.model.php";
      require_once "controllers/router.controller.php";
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
            $return = new routerController();
            $return -> fncResponse($response,"getData",null);
          }
        /********************************
         ** Petición GET con filtro
        ********************************/
          static public function getDataFilter($db, $table, $select,
            $linkTo, $equalTo, $orderBy, $orderMode, $startAt, $endAt){
            $response = GetModel::getDataFilter($db, $table, $select,
              $linkTo,$equalTo, $orderBy, $orderMode, $startAt, $endAt);
            $return = new GetController();
            $return -> fncResponse($response,"getDataFilter",null);
          }
        /************************************************************
          ** Petición Get con tablas relacionadas.
        ************************************************************/
          static public function getRelData($db, $rel, $type,
            $select, $orderBy, $orderMode, $startAt, $endAt){
            $response = GetModel::getRelData($db, $rel, $type,
              $select, $orderBy, $orderMode, $startAt, $endAt);
            $return = new GetController();
            $return->fncResponse($response,"getRelData",null);
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
            $return->fncResponse($response,"getRelDataFilter",null);
          }
        /****************************************************
        ** Petición Get para buscadores
        *****************************************************/
          static public function getDataSearch($db, $table, $select,
            $linkTo, $searchTo, $orderBy, $orderMode, $startAt, $endAt){
            $response = GetModel::getDataSearch($db, $table, $select,
              $linkTo, $searchTo, $orderBy, $orderMode, $startAt, $endAt);
            $return = new GetController();
            $return->fncResponse($response,"getDataSearch",null);
          }
        /*************************************************************
         ** Petición Get para buscadores con tablas relacionadas.
        *************************************************************/
          static public function getRelDataSearch($db, $rel, $type, $select,
            $linkTo, $searchTo, $orderBy, $orderMode, $startAt, $endAt){
            $response = GetModel::getRelDataSearch($db, $rel, $type, $select,
              $linkTo, $searchTo, $orderBy, $orderMode, $startAt, $endAt);
            $return = new GetController();
            $return->fncResponse($response,"getRelDataSearch",null);
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
            $return->fncResponse($response,"getDataRange",null);
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
            $return->fncResponse($response,"getRelDataRange",null);
          }
        /*******************************
        ** Respuesta del controlador
        *******************************/
        public function fncResponse($response, $method, $error){
          if(!empty($response)){
            $json = array(
              "status" => 201,
              "method" => $method,
              "total" => count($response),
              "detalle" => $response
            );
          }else{
          if($error != null){
            $json = array(
              "status" => 400,
              "method" => $method,
              "error" => $error,
          );
          }else{
          $json = array(
            "status" => 404,
            "method" => $method,
            "detalle" => "not found...",
          );
          }
        }
          echo json_encode($json, http_response_code($json["status"]));
        }
      }
?>