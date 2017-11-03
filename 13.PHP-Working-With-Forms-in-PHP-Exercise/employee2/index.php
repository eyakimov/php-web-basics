<?php

// Load DB
include "db_config.php";

// Load core classes
include "core/Model.php";
include "core/Controller.php";

// Load model classes - they extend Model.php
include "model/AddressesModel.php";
include "model/EmployeesModel.php";
include "model/ProjectsModel.php";

// Load Controller class - it extends Controller.php
include "controller/MainController.php";
include "controller/EmployeeController.php";
include "controller/MyController.php";

$app=new MyController($db);
$app->route();

