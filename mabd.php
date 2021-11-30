<?php
//Auteur : Ibson

//connection à la Base de données pgAdmin :ibson
$conn = pg_connect("host=localhost port=5432 dbname=NGSYS user=ngsys password=ngsys");

if($conn) {
          // echo 'ok super';
    } else {
          echo 'there has been an error connecting';
	exit;
} 