<?php
    // Paths updated
    include('config.php');
    session_start();
    if (!isset($_SESSION['username']))
    {
        header("location: ./authentication.php");
        exit();
    }
    function extractInitials($user) {
        // Check if both 'Nom' and 'prenom' exist, use their initials
        if (isset($user['Nom']) && isset($user['prenom'])) {
            $initials = strtoupper(substr($user['Nom'], 0, 1) . substr($user['prenom'], 0, 1));
        } else {
            // If either 'Nom' or 'prenom' is missing, use initials of 'username'
            $initials = strtoupper(substr($user['username'], 0, 2));
        }
      
        return $initials;
      }
?>