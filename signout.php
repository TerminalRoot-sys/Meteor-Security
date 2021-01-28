<?php
    require("@/sys/exec.php");
    $_SESSION["username"] = NULL;
    $_SESSION["ID"] = NULL;
    unset($_SESSION["username"]);
    unset($_SESSION["ID"]);
    unset($_SESSION["locked"]);
    @session_regenerate_id();
    @session_destroy(TRUE); // In case of disconnect for session hijacking, having 2 differents session id
    header("Location: signin.php");
?>