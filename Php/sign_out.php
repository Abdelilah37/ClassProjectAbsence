<?php
        // Paths updated
        session_start();
        session_destroy();
        header("Location: ../authentication.php");
        exit();    
?>