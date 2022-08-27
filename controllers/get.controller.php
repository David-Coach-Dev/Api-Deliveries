<?php
  /************************
   *todo Get Controller.
   ************************/
    /************************
     *! Requerimientos.
    ************************/
      require_once "models/get.model.php";
      require_once "middleware/response.middleware.php";
    /******************************
     *? Class Controller GET
    ******************************/
      class getController{
        /********************************
         ** 1.- Petición GET sin filtro
         ********************************/
          static public function getData($db, $table, $select, $orderBy, $orderMode, $startAt, $endAt){
            $response = GetModel::getData($db, $table, $select, $orderBy, $orderMode, $startAt, $endAt);
            responseValidation($response, "getData");
          }
        /********************************
         ** 2.- Petición GET con filtro
         ********************************/
          static public function getDataFilter($db, $table, $select, $linkTo, $equalTo, $orderBy, $orderMode, $startAt, $endAt){
            $response = GetModel::getDataFilter($db, $table, $select, $linkTo,$equalTo, $orderBy, $orderMode, $startAt, $endAt);
            responseValidation($response, "getDataFilter");
          }
        /************************************************************
          ** 3.- Petición Get con tablas relacionadas.
         ************************************************************/
          static public function getRelData($db, $rel, $type, $select, $orderBy, $orderMode, $startAt, $endAt){
            $response = GetModel::getRelData($db, $rel, $type,$select, $orderBy, $orderMode, $startAt, $endAt);
            responseValidation($response, "getRelData");
          }
        /*************************************************************
         ** 4.- Petición Get con tablas relacionadas con filtros .
         *************************************************************/
          static public function getRelDataFilter($db, $rel, $type, $select, $linkTo, $equalTo, $orderBy, $orderMode, $startAt, $endAt){
            $response = GetModel::getRelDataFilter($db, $rel, $type, $select, $linkTo, $equalTo, $orderBy, $orderMode, $startAt, $endAt);
            responseValidation($response, "getRelDataFilter");
          }
        /****************************************************
         ** 5.- Petición Get para buscadores
         ****************************************************/
          static public function getDataSearch($db, $table, $select, $linkTo, $searchTo, $orderBy, $orderMode, $startAt, $endAt){
            $response = GetModel::getDataSearch($db, $table, $select, $linkTo, $searchTo, $orderBy, $orderMode, $startAt, $endAt);
            responseValidation($response, "getDataSearch");
          }
        /*************************************************************
         ** 6.- Petición Get para buscadores con tablas relacionadas.
         *************************************************************/
          static public function getRelDataSearch($db, $rel, $type, $select, $linkTo, $searchTo, $orderBy, $orderMode, $startAt, $endAt){
            $response = GetModel::getRelDataSearch($db, $rel, $type, $select, $linkTo, $searchTo, $orderBy, $orderMode, $startAt, $endAt);
            responseValidation($response, "getRelDataSearch");
          }
        /*************************************************************
         ** 7.- Petición Get con rangos.
         *************************************************************/
          static public function getDataRange($db, $table, $select, $linkTo, $betweenIn, $betweenOut, $orderBy, $orderMode, $startAt, $endAt, $filterTo, $inTo){
            $response = GetModel::getDataRange($db, $table, $select, $linkTo, $betweenIn, $betweenOut, $orderBy, $orderMode, $startAt, $endAt, $filterTo, $inTo);
            responseValidation($response, "getDataRange");
          }
        /*************************************************************
         ** 8.- Petición Get con rangos con tablas relacionadas.
         *************************************************************/
          static public function getRelDataRange($db, $rel, $type, $select, $linkTo, $betweenIn, $betweenOut, $orderBy, $orderMode, $startAt, $endAt, $filterTo, $inTo){
            $response = GetModel::getRelDataRange($db, $rel, $type, $select, $linkTo, $betweenIn, $betweenOut, $orderBy, $orderMode, $startAt, $endAt, $filterTo, $inTo);
            responseValidation($response, "getRelDataRange");
          }
        /*************************************************************
         ** 9.- Response Validation.
         *************************************************************/
          static public function responseValidation($response,  $method){
            $return = new responseMiddleware();
            ($response==null ? $return -> fncResponse(400,  $method, "Sintaxis invalida...") : $return -> fncResponse(200, $method, $response));
          }
      }
?>