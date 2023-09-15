<?php 
include('connection.php');
include('header.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Display</title>
</head>
<body>




</div>
    <div class="container">
      

            <?php
            if (isset($_GET['info'])) {
                $id = $_GET['info'];
                
                $sql="select * from `information` where  `id`= $id";
                //  echo "<h1> You are in ID : $id </h1>";

                $result=mysqli_query($conn,$sql);
                //  $getRow = mysqli_fetch_row($result);
                if ($result) {
                    // echo "34";
                    while ($row=mysqli_fetch_array($result)) {
                        // $id         =     $row['id'];
                        $image      =     $row['profile_image'];
                        $name       =     $row['name'];
                        $gender     =     $row['gender'];
                        $country    =     $row['country'];
                        $address    =     $row['address'];
                        ?>

                    <div class="row">
                        <div class="col-sm">
                        <img src="<?php echo $image; ?>" width='200' height='200'>
                        </div>
                        <div class="col-sm">
                            <h3> ID : <?php echo $id; ?></h3>
                         <h3> NAME : <?php echo $name; ?></h3> 
                           <h3> GENDER : <?php echo $gender; ?></h3>
                           <h3> COUNTRY : <?php echo $country;?></h3>
                           <h3> ADDRESS : <?php echo $address;?></h3>
                        </div>
                      
                    </div>
              <?php          
                    }  
             ?>
                
<?php  }
     }
?>
  <tbody>
    <table class="table table-striped " style="margin-top: 55px">
        <thead>
            <tr>
            <!-- <th scope="col">User Id</th> -->
            <th scope="col">Id</th>
            <th scope="col">Certificate</th>
            <th scope="col">Year</th>
            <th scope="col">Institution</th>
            </tr>
        </thead>
        <tbody>
        <?php
        $sql="select * from `user` where uid =$id";
        $result=mysqli_query($conn,$sql);
        if ($result) {
            while ($row=mysqli_fetch_assoc($result)) {
            $insert_id = mysqli_insert_id($conn);
                
                // $uid              =     $row['uid'];
                $id               =     $row['id'];
                $ucertificate     =     $row['ucertificate'];
                $ucyear           =     $row['ucyear'];
                $uinstitute       =     $row['uinstitute'];
        ?>
        
        <tr>
            <!-- <td><?php //echo $uid; ?></td> -->
            <th><?php echo $id; ?></th>
            <td><img src="<?php echo $row['ucertificate']; ?>" width='80' height='80'></td>
            <td><?php echo $ucyear; ?></td>
            <td><?php echo $uinstitute; ?></td>
        </tr>
            <!-- Displaying user table -->
          

            <?php
                    }   
                } 
            ?>
        </tbody>
    </table>
</div>
</body>
</html>