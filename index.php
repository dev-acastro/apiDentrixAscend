<?php

require_once "api.php";

$arturo =getPatients("FX2005");
print_r($arturo);



if (count($_POST)==0){


    $filter = [
        "filter" => "firstName==ana"
    ];

    $patientSearch = getData("patients", $filter);
    $patients = $patientSearch->data;
     print_r($patientSearch);



    ?>

    <html>
    <head>
        <script src="https://code.jquery.com/jquery-3.6.0.slim.min.js" integrity="sha256-u7e5khyithlIdTpu22PHhENmPcRdFiHRjhAuHcs05RI=" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>

    </head>

    <body>
    <div class="container">
     <table class="table table-bordered">
         <thead class="thead-dark">
         <tr>
             <th>id</th>
             <th>Nombre</th>
             <th>Apellido</th>
             <th>Acciones</th>
         </tr>
         </thead>
         <tbody>
         <?php
         foreach ($patients as $patient){

             ?>
             <tr>
                 <td><?php echo $patient->id ?></td>
                 <td><?php echo $patient->firstName?></td>
                 <td><?php echo $patient->lastName?></td>
                 <td>
                     <form action="tx.php" method="post">
                         <input type="hidden" value="<?php echo $patient->id ?>" name="id">
                         <input type="submit" class="btn btn-info" value="Treatment Plan">
                     </form>

                     </td>
             </tr>
             <?php
         }
         ?>
         </tbody>

     </table>
    </div>
    </body>
    </html>


    <?php



}else {
    echo "no Existe";
}

?>

