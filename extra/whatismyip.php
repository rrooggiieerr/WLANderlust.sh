<?php
header_remove('X-Powered-By');
header('Content-Type:');
header('Content-Length: '.strlen($_SERVER['REMOTE_ADDR']));
echo $_SERVER['REMOTE_ADDR'];
