<?php 
$directorio = dirname( __DIR__ , 2 ).DS.'mvc'.DS.'controllers';
$phps = glob($directorio.DS."*.php");
foreach($phps as $p) require $p;