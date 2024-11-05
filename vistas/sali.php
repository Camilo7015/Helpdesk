<?php

    session_start();
    session_destroy();
    include "modalLoginSession.php";

    header("location:../index.html");