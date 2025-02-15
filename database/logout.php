<?php
session_name('Klothink');
session_start();
session_unset();
session_destroy();
header("Location: ../views/index.php");
die();
