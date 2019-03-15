<?php
require_once 'Graph.php';

$graph = json_decode(file_get_contents("graph.json"),true);

$g = new Graph($graph);

$g->search("лужа", "море");

