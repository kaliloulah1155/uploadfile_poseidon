<?php 
  // var_dump($_FILES);

  /* DATA BASE to store file

  CREATE TABLE public.uploadfile
(
    id SERIAL UNIQUE, 
	name VARCHAR,
	file_url VARCHAR
)


  */
  include_once 'mabd.php';

   if(!empty($_FILES)){
       $file_name=$_FILES['fichier']['name'];
      $file_extension=strrchr($file_name,".");


      $file_tmp_name=$_FILES['fichier']['tmp_name'];
      $file_dest='files/'.$file_name;

      $extensions_autorisees=array('.pdf','.PDF');
      if(in_array($file_extension,$extensions_autorisees)){

        if (isset($_POST['sendfile'])){
           if(move_uploaded_file($file_tmp_name,$file_dest)){

                 /////////////INSERT DATA INTO UPLOADFILE //////////
                
                 $query2="INSERT INTO public.uploadfile(
                    name, file_url)
                    VALUES (  
                           '".$file_name."',
                            '".$file_dest."' 
                              );
                              "; 
                    pg_query($query2) or die("Error while insert");
                 //////////////////
               echo 'Fichier envoyé avec succès';
           }else{
               echo "Une erreur est survenue lors de l'envoi du fichier ";
           }
        }



      }else{
          echo 'Seuls les fichiers PDF sont autorisés';
      }

   }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload pdf file</title>
</head>
<body>
    <h1>Uploader of PDF file</h1>

    <form method="POST" enctype="multipart/form-data">
         <input type="file" name="fichier" />
         <input type="submit" name="sendfile" value="Envoyer le fichier" />
    </form>
    <h1>Fichiers PDF enregistrés</h1>
    <?php 

        $query_ ="SELECT name,file_url FROM public.uploadfile ";
        $contests_ = pg_query($query_) or die('Query failed: ' . pg_last_error());
        while ($row_ = pg_fetch_row($contests_)) {
              
            echo $row_[0].' : '.'<a href="'.$row_[1].'" target="_blank"  >'.$row_[0].'</a> <br/>';
        }

    ?>

    
</body>
</html>