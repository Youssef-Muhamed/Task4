<?php
session_start();

if($_SERVER['REQUEST_METHOD'] == "POST"){

    $name     = filter_var($_POST['name'],FILTER_SANITIZE_STRING);
    $email    = $_POST['email'];
    $password = $_POST['pass'];
    $adress   = $_POST['adress'];
    $url      = $_POST['url'];

    $fileName = $_FILES['image']['name'];
    $fileTmp = $_FILES['image']['tmp_name'];

    $AllowExtention = array("jpg","png","jpeg");

    $tmp = explode('.',$fileName);
    $fileExtention = strtolower(end($tmp));

    $errors = [];

    # Validate Name
    if(empty($name)){
        $errors['Name']  = "Field Required...";
    }

    # Validate Email
    if(empty($email)){
        $errors['Email'] = "Field Required...";
    }

    if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        $errors['Email'] = "Inter Vaild Email Email Must Be Have a( . - @ ) Charcters...";
    }

    #Validate Password
    if(empty($password)){
        $errors['Password'] = "Field Required...";
    }

    if(strlen($password) < 6){
        $errors['Password']  = "Password Length must be > 6 Charcters... ";
    }

    #Validate Adress
    if(empty($adress)){
        $errors['Adress'] = "Field Required...";
    }

    if(strlen($adress) < 10) {
        $errors['Adress'] = "Adress Length must be > 10 Charcters... ";
    }

    #Validate URL
    if(empty($url)){
        $errors['URL'] = "Field Required...";
    }

    if(!filter_var($url, FILTER_VALIDATE_URL)){
        $errors['URL'] = "Inter Vaild URL...";
    }

    #Validate Image
    if ( !empty($fileName) && in_array($fileExtention,$AllowExtention)){

    } else {
        $errors['Image'] = " The Extention Of Image Is Not Allwoed";
    }

    # Check Forms
    echo '<div class="container">';
    if(count($errors) > 0){
        foreach ($errors as $key => $value) {
            echo '<div class="alert alert-danger"> '.$key.' : '.$value.'</div>';
        }
    }else{
        $newFileName = rand().time(). '_' . $fileName;
        move_uploaded_file($fileTmp,"./uploads/" . $newFileName);

        $_SESSION['info'] = [
                "Name"      => $name,
                "Email"     =>  $email,
                "Adress"    =>  $adress,
                "URL"       =>  $url
        ];
        $_SESSION['img'] = './uploads/'.$newFileName;

        header("Location: profile.php");
        exit();
    }
    echo '</div>';
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Register</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<body>

<div class="container">
    <h2>Register</h2>
    <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post" enctype="multipart/form-data">

        <div class="form-group">
            <label for="exampleInputName">Name</label>
            <input type="text" class="form-control" id="exampleInputName" name="name" placeholder="Enter Name">
        </div>

        <div class="form-group">
            <label for="exampleInputEmail">Email</label>
            <input type="text" class="form-control" id="exampleInputEmail1" name="email" placeholder="Enter email">
        </div>

        <div class="form-group">
            <label for="exampleInputEmail">Password</label>
            <input type="password" class="form-control" id="exampleInputEmail1" name="pass" placeholder="Enter Password">
        </div>

        <div class="form-group">
            <label for="exampleInputEmail">Adress</label>
            <input type="text" class="form-control" id="exampleInputEmail1" name="adress" placeholder="Enter Adress">
        </div>

        <div class="form-group">
            <label for="exampleInputEmail">URL</label>
            <input type="url" class="form-control" id="exampleInputEmail1" name="url" placeholder="Enter URL">
        </div>

        <div class="form-group">
            <label for="exampleInputEmail">Upload Image</label>
            <input type="file" class="form-control" id="exampleInputEmail1" name="image" >
        </div>

        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>

</body>
</html>