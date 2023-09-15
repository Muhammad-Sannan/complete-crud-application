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
    <div class="container">
        <button class="btn btn-secondary my-5"><a href="index.php"class="text-light"> Add Data</a></button>
<table class="table table-striped" >
  <thead>
    <tr>
      <th scope="col">Id</th>
      <th scope="col">Profile Pic</th>
      <th scope="col">Name</th>
      <th scope="col">Gender</th>
      <th scope="col">Country</th>
      <th scope="col">Address</th>
      <th scope="col">Edit/Delete </th>
      <th scope="col">More </th>
      
    </tr>
  </thead>
  <tbody>
      <?php
      $sql="select * from `information`";
      $result=mysqli_query($conn,$sql);
      if ($result) {
        while ($row=mysqli_fetch_assoc($result)) {
            $id       =     $row['id'];
            $name     =     $row['name'];
            $gender   =     $row['gender'];
            $country  =     $row['country'];
            $address  =     $row['address'];
      ?>
            <tr>
                
                <th><?php echo $id; ?></th>
                <td><img src="<?php echo $row['profile_image']; ?>" width='80' height='80'></td>
                <td><?php echo $name; ?></td>
                <td><?php echo $gender; ?></td>
                <td><?php echo $country; ?></td>
                <td><?php echo $address; ?></td>

                <td>
                <button class='btn btn-success'><a href='index.php?updateid=<?php echo $row['id'] ?>'class= text-light>Edit</a></button>
                <button class='btn btn-danger'><a href='delete.php?deleteid=<?php echo $row['id'] ?>&profilepic=<?php echo $row['profile_image']; ?>' class =text-dark>Delete</a></button>
                </td>
                <td>
                <button class='btn btn-info'><a href='info.php?info=<?php echo $row['id'] ?>'class= text-light>info</a></button>
                </td>
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