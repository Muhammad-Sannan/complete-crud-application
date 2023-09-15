<?php 
include('connection.php');
include('header.php');
if (isset($_GET['updateid'])) {
    $id = $_GET['updateid'];
    // echo $id;
    $query = "select * from `information` where `id`='$id'";
    $result = mysqli_query($conn, $query);
            if (!$result) {
                die("query failed".mysqli_error());
            }else {
                $row =(mysqli_fetch_assoc($result));
                // print_r ($row);     
          }
    }
if (isset($_POST['id']) && $_POST['id'] != 0 ) {

    // echo "<pre>";
    // print_r();
    // exit;
    $id             =           $_POST['id'];
    $name           =           $_POST['name'];
    $gender         =           $_POST['gender'];
    $country        =           $_POST['country'];
    $address        =           $_POST['address'];

    $ucertificate   =           $_FILES['ucertificate'];
    $ucyear         =           $_POST['ucyear'];
    $uinstitute     =           $_POST['uinstitute'];

    // echo "<pre>";
    // print_r($_FILES['profilepic']);
    // exit;
    if(isset($_FILES['profilepic']) && $_FILES['profilepic']['error']==0){
        // echo "aa";
        $ppic=$_FILES['profilepic']['name'];
        //Getting the Temporary file name of the uploaded file
        $ppicTempName = $_FILES['profilepic']['tmp_name'];
        //Getting the file size of the uploaded file
        $ppicSize = $_FILES['profilepic']['size'];
        //getting the no. of error in uploading the file
        $ppicError = $_FILES['profilepic']['error'];
        //Getting the file type of the uploaded file
        $ppicType = $_FILES['profilepic']['type'];
        //Getting the file ext
        $ppicExt = explode('.',$ppic);
        $ppicActualExt = strtolower(end($ppicExt));
        //Array of Allowed file type
        $allowedExt = array("jpg","jpeg","png","pdf");
        if(in_array($ppicActualExt, $allowedExt)){
            //Checking, Is there any file error
            if($ppicError == 0){
                //Checking,The file size is bellow than the allowed file size
                if($ppicSize < 10000000){
                    //Creating a unique name for file
                    $ppicNemeNew = time().".".$ppicActualExt;
                    //File destination
                    $ppicDestination = 'Uploads/'.$ppicNemeNew;
                    //function to move temp location to permanent location
                    move_uploaded_file($ppicTempName, $ppicDestination);
                    //Message after success
                    // echo "File Uploaded successfully";
                   
                }else{
                    //Message,If file size greater than allowed size
                    echo "File Size Limit beyond acceptance";
                }
            }else{
                //Message, If there is some error
                echo "Something Went Wrong Please try again!";
            }
            // $sql= "UPDATE `information` SET name='$name', gender='$gender', country='$country', address='$address' profile_image='$ppicDestination' where id=$id ";

          /*echo */ $sql= "UPDATE `information` SET `name`='$name', `gender`='$gender',`country`='$country',`address`='$address', `profile_image`='$ppicDestination' where id=$id";
            // exit();
            if (isset($_POST['old_image'])) {
                // $old = $_POST['old_image'];
                unlink($_POST['old_image']);
                // echo $_POST['old_image'];
                // echo "working";
                // die();
            }
        }   else{
            //Message,If this is not a valid file type
            echo "You can't upload this extention of file";
        }
        
     }else{
        $sql= "UPDATE `information` SET `name`='$name', `gender`='$gender',`country`='$country',`address`='$address' where id=$id";
    }    
        // echo $sql;
        // die();
        $result=mysqli_query($conn,$sql);
        if ($result) {

            //echo "<pre>"; print_r($_FILES);print_r($_REQUEST); exit;
            // $insert_id      =            mysqli_insert_id($conn); 
            // echo "workinngg ";
            // echo $sql;
            // die();
            $sqql = "delete from `user` where uid=$id";
            $ress = mysqli_query($conn,$sqql);
            if ($ress) {
                $roww= mysqli_fetch_assoc($ress);
                // echo "ssssssssss";
            }else {
                
                echo "error";
                // echo "$sqql";
            }
            if(isset($_FILES['ucertificate'])){ 
                
                
                
                    for ($i=0; $i < COUNT($ucyear); $i++) {
                        $certificate    =   '';
                            # code...
                        if($_FILES['ucertificate']['error'][$i] == 0){
                            $cpic=$_FILES['ucertificate']['name'][$i];
            
                            $ppicTempName       =       $_FILES['ucertificate']['tmp_name'][$i];
                            //Getting the file size of the uploaded file
                            $ppicSize           =       $_FILES['ucertificate']['size'][$i];
                            //getting the no. of error in uploading the file
                            $ppicError          =       $_FILES['ucertificate']['error'][$i];
                            //Getting the file type of the uploaded file
                            $ppicType           =       $_FILES['ucertificate']['type'][$i];
                    
                            //Getting the file ext
                            $ppicExt            =       explode('.',$cpic);
                            $ppicActualExt      =       strtolower(end($ppicExt));
                    
                            //Array of Allowed file type
                            $allowedExt         =       array("jpg","jpeg","png","pdf");
                    
                            //Checking, Is file extentation is in allowed extentation array
                            if(in_array($ppicActualExt, $allowedExt)){
                                //Checking, Is there any file error
                                //Checking,The file size is bellow than the allowed file size
                                if($ppicSize < 10000000){
                                    //Creating a unique name for file
                                    $ppicNemeNew = time().".".$ppicActualExt;
                                    //File destination
                                    $certificate = 'images/'.$ppicNemeNew;
                                    //function to move temp location to permanent location
                                    move_uploaded_file($ppicTempName, $certificate);
                                    //Message after success
                                    echo "File Uploaded successfully";
                                }else{
                                    //Message,If file size greater than allowed size
                                    echo "File Size Limit beyond acceptance";
                                }
                                
                            }else{
                                //Message,If this is not a valid file type
                                echo "You can't upload this extention of file";
                            }
                        }else{
                            //Message, If there is some error
                            //echo $certificate; exit;
                        }
                        
                    if($certificate == ""){
                        $certificate = $_REQUEST['user_temp_img'][$i];
                    }
    
                    $que= "INSERT INTO `user` (uid, ucertificate, ucyear, uinstitute) VALUES (".$id.", '".$certificate."', '".$ucyear[$i]."', '".$uinstitute[$i]."')";
                    $resu = mysqli_query($conn, $que);
                    if ($resu) {
                        echo "working";
                    }
                }
            // }
            header('location:display.php');
            // echo "updated";
        }
    }
}    






    // var_dump($_POST['id']);
    // echo 'gfk1';
    // die();




    // $ucertificate           =           $_FILES['ucertificate'];
    // $ucyear                 =           $_POST['ucyear'];
    // $uinstitute             =           $_POST['uinstitute'];


    // echo "cccc";


    // echo "<pre>";
    // print_r($ucyear);
    // exit();
// ------------------------------------------------------------
// inserting data
if(!isset($_GET['updateid'])){
    if (isset($_POST['submit'])) {
        $name           =   $_POST['name'];
        $gender         =   $_POST['gender'];
        $country        =   $_POST['country'];
        $address        =   $_POST['address'];



        // ------------------------------------
        // user table
        $insert_id      =   0;
        $ucertificate   =   $_FILES['ucertificate'];
        $ucyear         =   $_POST['ucyear'];
        $uinstitute     =   $_POST['uinstitute'];
        // echo "<pre>";
        // print_r($ucyear);
        // exit();
        
        // echo 'gfk';
        if(isset($_FILES['profilepic'])){
            $ppic           =   $_FILES['profilepic']['name'];
            //Getting the Temporary file name of the uploaded file
            $ppicTempName   =   $_FILES['profilepic']['tmp_name'];
            //Getting the file size of the uploaded file
            $ppicSize       =   $_FILES['profilepic']['size'];
            //getting the no. of error in uploading the file
            $ppicError      =   $_FILES['profilepic']['error'];
            //Getting the file type of the uploaded file
            $ppicType       =   $_FILES['profilepic']['type'];

            //Getting the file ext
            $ppicExt        =   explode('.',$ppic);
            $ppicActualExt  =   strtolower(end($ppicExt));

            //Array of Allowed file type
            $allowedExt     =   array("jpg","jpeg","png","pdf");

        //Checking, Is file extentation is in allowed extentation array
            if(in_array($ppicActualExt, $allowedExt)){
                //Checking, Is there any file error
                if($ppicError == 0){
                    //Checking,The file size is bellow than the allowed file size
                    if($ppicSize < 10000000){
                        //Creating a unique name for file
                        $ppicNemeNew        =       time().".".$ppicActualExt;
                        //File destination
                        $ppicDestination    =       'Uploads/'.$ppicNemeNew;
                        //function to move temp location to permanent location
                        move_uploaded_file($ppicTempName, $ppicDestination);
                        //Message after success
                        echo "File Uploaded successfully";
                    }else{
                        //Message,If file size greater than allowed size
                        echo "File Size Limit beyond acceptance";
                    }
                }else{
                    //Message, If there is some error
                    echo "Something Went Wrong Please try again!";
                }
            }else{
                //Message,If this is not a valid file type
                echo "You can't upload this extention of file";
            }
            $sql= "insert into `information`(name,gender,country,address,profile_image)
            values('$name','$gender','$country','$address','$ppicDestination') ";
            // echo $sql;
            // die();
            $result             =           mysqli_query($conn,$sql);
            if ($result) {
                $insert_id      =            mysqli_insert_id($conn);     
            }
        
        // ----------------------------------
        // getting certificate.........
        if(isset($_FILES['ucertificate'])){ 
            $certificate    =   '';
            
            if($insert_id >0 ){
                for ($i=0; $i < COUNT($ucyear); $i++) {
                        # code...
                    if($_FILES['ucertificate']['error'][$i] == 0){
                        $cpic=$_FILES['ucertificate']['name'][$i];
        
                        $ppicTempName       =       $_FILES['ucertificate']['tmp_name'][$i];
                        //Getting the file size of the uploaded file
                        $ppicSize           =       $_FILES['ucertificate']['size'][$i];
                        //getting the no. of error in uploading the file
                        $ppicError          =       $_FILES['ucertificate']['error'][$i];
                        //Getting the file type of the uploaded file
                        $ppicType           =       $_FILES['ucertificate']['type'][$i];
                
                        //Getting the file ext
                        $ppicExt            =       explode('.',$cpic);
                        $ppicActualExt      =       strtolower(end($ppicExt));
                
                        //Array of Allowed file type
                        $allowedExt         =       array("jpg","jpeg","png","pdf","doc");
                
                        //Checking, Is file extentation is in allowed extentation array
                        if(in_array($ppicActualExt, $allowedExt)){
                            //Checking, Is there any file error
                            //Checking,The file size is bellow than the allowed file size
                            if($ppicSize < 10000000){
                                //Creating a unique name for file
                                $ppicNemeNew = time().".".$ppicActualExt;
                                //File destination
                                $certificate = 'images/'.$ppicNemeNew;
                                //function to move temp location to permanent location
                                move_uploaded_file($ppicTempName, $certificate);
                                //Message after success
                                echo "File Uploaded successfully";
                            }else{
                                //Message,If file size greater than allowed size
                                echo "File Size Limit beyond acceptance";
                            }
                            
                        }else{
                            //Message,If this is not a valid file type
                            echo "You can't upload this extention of file";
                        }
                    }else{
                        //Message, If there is some error
                        echo "Something Went Wrong Please try again!";
                    }
                

                $query2 = "INSERT INTO `user` (uid, ucertificate, ucyear, uinstitute) VALUES (".$insert_id.", '".$certificate."', '".$ucyear[$i]."', '".$uinstitute[$i]."')";
                $result1 = mysqli_query($conn, $query2);
                
            }
        }
        
        header('location:display.php');
        }
    }
        }
    }
?>


    <div class="container">
        <form method="post" enctype="multipart/form-data">
            <div class="mb-3">
                <input type="hidden" class="form-control" name="id" value="<?php if(isset($_GET['updateid'])){ echo $row['id'];}?>"required>
                
            </div>
            <div class="mb-3">
                <label>Name :</label>
                <input type="text" class="form-control" name="name" value="<?php if(isset($_GET['updateid'])){ echo $row['name'];}?>" placeholder="Enter your name " required>
                
            </div>
            <div class="mb-3">
                <label>Gender :</label>
                <input type="text" class="form-control" name="gender"  value="<?php if(isset($_GET['updateid'])){ echo $row['gender'];}?>" placeholder="Enter your gender" required>
            </div>
            <div class="mb-3">
                <label>Country :</label>
                <input type="text" class="form-control" name="country" value="<?php if(isset($_GET['updateid'])){ echo $row['country'];}?>" placeholder="Enter country name" required>
            </div>
            <div class="mb-3">
                <label>Address :</label>
                <input type="text" class="form-control" name="address"value="<?php if(isset($_GET['updateid'])){ echo $row['address'];}?>" placeholder="Enter your permanent address"  required>
            </div>
            <div class="form-group">
                <label>Upload Image :</label>
                <input type="file" class="form-control" name="profilepic"value="<?php echo $row['profile_image']; ?>" width="48" height="48"><br>
                <?php if (isset($_GET['updateid'])) { 
                     if (empty($_FILES['profilepic']['name']) && !empty($row['profile_image'])) { ?>
                        <img src="<?php echo $row['profile_image']; ?>" width="100" height="100">
                    <?php } 
                 } ?>
                     <span style="color: brown; font-size: 12px;">Only jpg / jpeg / png / gif / doc format allowed.</span><br>
            </div>


            
            <input type="hidden" name="old_image" value="<?php echo $row['profile_image']; ?>">
         <?php
            if (isset($_GET['updateid'])) {
                $id = $_GET['updateid'];
                // echo $id;
               /*echo */$query3   =      "select * from `user` where `uid`=".$id;
                $result3  =      mysqli_query($conn, $query3);
                // echo "<pre>";
                // print_r ($result3);
                        if ($result3) {
                        
                            // $row3   =   mysqli_fetch_assoc($result3);
                            // print_r ($row3);
                            while ($row3=mysqli_fetch_assoc($result3)) {  ?>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div id="inputFormRow">
                                            <div class="mb-3">
                                                <input type="hidden" class="form-control" name="idd" value="<?php if(isset($_GET['updateid'])){ echo $row3['id'];}?>"required>
                                            </div>

                                            <div class="input-group mb-3">
                                            <label>
                                                Certificate:
                                                <input type="file" name="ucertificate[]" class="form-control m-input" value="<?php if(isset($_GET['updateid'])){ echo $row3['ucertificate'];}?>" placeholder="upload degree certificate" autocomplete="off"><br>
                                                <img src="<?php echo $row3['ucertificate']; ?>" width='60' height='60'> 
                                                <span style="color:red; font-size:12px;">Only jpg / jpeg/ png /pdf /doc format allowed.</span>

                                            </label>
                                            <input type="hidden" name="user_temp_img[]" value="<?php echo $row3['ucertificate']; ?>">
                                            <label class="style">
                                                Degree Completion Year:
                                                <input type="number" min="1900" max="2099" name="ucyear[]" class="form-control m-input" value="<?php if(isset($_GET['updateid'])){ echo $row3['ucyear'];}?>" placeholder="degree completion year" autocomplete="off">
                                            </label>
                                            <label class="style1">
                                                Institution: 
                                                <input type="text" name="uinstitute[]" class="form-control m-input" value="<?php if(isset($_GET['updateid'])){ echo $row3['uinstitute'];}?>" placeholder="Institution" autocomplete="off">
                                            </label>
                                            

                                            


                                            <div class="input-group-append">
                                                <button id="removeRow" type="button[]" class="btn btn-danger">Remove</button>
                                            </div>
                                            <script type="text/javascript">
                                                // add row
                                                $("#addRow").click(function () {
                                                var html = '';
                                                html += '<div id="inputFormRow">';
                                                html += '<div class="input-group mb-3">';
                                                html += '<label>Certificate:<input type="file" name="ucertificate[]" class="form-control m-input" value=" <?php if(isset($_GET['updateid'])){ echo $row3['ucertificate']; }?> placeholder="upload degree certificate" autocomplete="off"></label>';
                                                html += '<label>Degree Completion Year:<input type="number" min="1900" max="2099"name="ucyear[]" class="form-control m-input" value="<?php if(isset($_GET['updateid'])){ echo $row3['ucyear[]'];}?>" placeholder="degree completion year" autocomplete="off"></label>';
                                                html += '<label>Institution:<input type="text" name="uinstitute[]" class="form-control m-input" value="<?php if(isset($_GET['updateid'])){ echo $row3['uinstitute[]'];}?>" placeholder="Institution" autocomplete="off"></label>';

                                                html += '<div class="input-group-append">';
                                                html += '<button id="removeRow" type="button" class="btn btn-danger">Remove</button>';
                                                html += '</div>';
                                                html += '</div>';

                                                $('#newRow').append(html);
                                                });

                                                // remove row
                                                $(document).on('click', '#removeRow', function () {
                                                    $(this).closest('#inputFormRow').remove();
                                                });
                                            </script>
                                            
                                        </div>
                                    </div>
                                    
                                
                                </div>
                            </div>
                            <?php   } ?>
                            

                            <div id="newRow"></div>
                            <br>
                            <button id="addRow" type="button" class="btn btn-info">Add Row</button><br><br>
                            <button type="submit" class="btn btn-primary" name="submit">Submit</button><br>
                            
                            <?php
                                    }
                       }
                        else{  ?>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div id="inputFormRow">
                                        <div class="mb-3">
                                            <input type="hidden" class="form-control" name="id" value="<?php if(isset($_GET['updateid'])){ echo $row3['id'];}?>"required>
                                        </div>

                                        <div class="input-group mb-3">
                                            <label>
                                                Certificate:
                                                <input type="file" name="ucertificate[]" class="form-control m-input"  placeholder="upload degree certificate" autocomplete="off">
                                                <!-- <span style="color:red; font-size:12px;">Only jpg / jpeg/ png /pdf /doc format allowed.</span>
                                                <img src="<?php //echo $row['ucertificate']; ?>" width='80' height='80'> -->
                                            </label>
                                            <label>
                                                Degree Completion Year:
                                                <input type="number" min="1900" max="2099" name="ucyear[]" class="form-control m-input" value="<?php if(isset($_GET['updateid'])){ echo $row3['ucyear[]'];}?>" placeholder="degree completion year" autocomplete="off">
                                            </label>
                                            <label>
                                                Institution: 
                                                <input type="text" name="uinstitute[]" class="form-control m-input" value="<?php if(isset($_GET['updateid'])){ echo $row3['uinstitute[]'];}?>" placeholder="Institution" autocomplete="off">
                                                </label>
                                            <div class="input-group-append">
                                                <button id="removeRow" type="button[]" class="btn btn-danger">Remove</button>
                                            </div>
                                        </div>
                                    </div>

                                    <div id="newRow"></div>
                                    <button id="addRow" type="button" class="btn btn-info">Add Row</button><br><br>
                                    <button type="submit" class="btn btn-primary" name="submit">Submit</button><br>
                                </div>
                            </div>

                      <?php  }
            
            
            ?>
            
        </form>
    </div>
    </div>

            

    <script type="text/javascript">
        // add row
        $("#addRow").click(function () {
            var html = '';
            html += '<div id="inputFormRow">';
            html += '<div class="input-group mb-3">';
            html += '<label>Certificate:<input type="file" name="ucertificate[]" class="form-control m-input"  placeholder="upload degree certificate" autocomplete="off"></label>';
            html += '<label>Degree Completion Year:<input type="number" min="1900" max="2099"name="ucyear[]" class="form-control m-input" placeholder="degree completion year" autocomplete="off"></label>';
            html += '<label>Institution:<input type="text" name="uinstitute[]" class="form-control m-input"  placeholder="Institution" autocomplete="off"></label>';

            html += '<div class="input-group-append">';
            html += '<button id="removeRow" type="button" class="btn btn-danger">Remove</button>';
            html += '</div>';
            html += '</div>';

            $('#newRow').append(html);
        });

        // remove row
        $(document).on('click', '#removeRow', function () {
            $(this).closest('#inputFormRow').remove();
        });
    </script>
    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script> -->
</body>
</html>