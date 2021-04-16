<?php

session_start();
session_destroy();
Print '<script>window.location.assign("http://localhost:8080/lenskart/index.html");</script>';
?>