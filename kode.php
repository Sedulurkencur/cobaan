<?php

echo "\nSEDANG RUN\n";
jembut :
$kodeku = substr(str_shuffle(str_repeat("2346789abcdefghjklmnpqrtuvwxyz", 5)), 0, 10);
file_put_contents("KODEKU.txt",$kodeku."\n",FILE_APPEND);
goto jembut;