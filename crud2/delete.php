<?php
include ('connection.php');
include ('header.php');

if (isset($_GET['deleteid'])) {
    $id=$_GET['deleteid'];
    $sql = "delete from `information` where id=$id";

    if (isset($_GET['profilepic'])) {
        unlink($_GET['profilepic']);
        // echo $_GET['profilepic'];
        // $img=$_POST['profilepic'];
        // echo "working";
        // die();
    }
    $result=mysqli_query($conn,$sql);
    if($result){
        header('location:display.php?msg=deleted_successfully');
    }
}
if (isset($_GET['delete'])) {
    $id=$_GET['delete'];
    $query = "delete from `user` where id=$id";
    // if (isset($_GET['ucertificate'])) {
    //     unlink($_GET['ucertificate']);
    //     echo $_GET['ucertificate'];
    //     // $img=$_POST['profilepic'];
    //     // echo "working";
    //     die();
    // }
    $res=mysqli_query($conn,$query);
    if($res){
        header('location:display.php?msg=deleted_successfully');
    }
}
?>