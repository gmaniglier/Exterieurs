<?php

//"connector.php" file
require_once("../codebase/connector/chart_connector.php");//includes related connector file
include("config/conf.php");

$conn = new ChartConnector($mysql,"MySQL");                    // connector initialization

$conn->render_table("v_stats", "nbvalid", "nbvalid, nboutdated" );     // data configuration

?>
