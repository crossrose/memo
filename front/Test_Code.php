<?php

  $wherefrom = 4;
  if (in_array($wherefrom,array(1,2,3))) $wherefrom = "OK";
  else $wherefrom = "NOT OK";

  echo $wherefrom ;


?>
