<?php
    function getConnection() {
        try {
            $bdd = new PDO('mysql:host=localhost;dbname=ice-breaking;charset=utf8',
            'root', '');

            return $bdd ;
        } catch (Exception $e) {
           return null ;
        }
    }
?>