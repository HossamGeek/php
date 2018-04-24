<?php

if($_SERVER["REQUEST_METHOD"] == "POST"){

                $id = $_POST['userID'];
                $user = User::find_by_id($id);
                $newuser = filter_var(strtolower($_POST['username']),FILTER_SANITIZE_STRING);
                $email = $_POST['Email'];
                $Phonenum = $_POST["Phone"];
                $pass =$_POST["NewPassWord"];
                $formError = array();



                if(strlen($newuser) > 10 || is_numeric($newuser) || empty(trim($newuser)))
                {
                $formError[] = "Username must Be less than   <strong> 10 </strong> characters and not be integer and not be empty";
                }
                //email
                if(filter_var($email,FILTER_VALIDATE_EMAIL) !== FALSE){
                $emaildb = $email;
                }else{
                $formError[] = "plz. Write correct Mail ";
                }
                if(empty(trim($email))){
                $formError[] = "Mail not be empty";
                }

                //password

                if(empty($pass)){
                $pass = $_POST["OldPassWord"];
                }else{

                if(!preg_match('/^(?=.*[A-Za-z])[0-9A-Za-z!@#$%]{8,12}$/',$pass)){
                $formError[] = "password at least one letter and it has to be a number following and  be 8-12 characters ";
                }else{
                $shapassagain = sha1($pass);
                }
                }


                //phone
                if(is_numeric($Phonenum)){
                $Phone = (string)$Phonenum;
                if(strlen($Phone) > 15 || empty(trim($Phone)))
                {
                $formError[] = "Phone must Be less than   <strong> 15 </strong> number and not be empty";

                }
                }else
                {
                $formError[] = "Phone must Be  number ";
                }



                if (empty($formError)) {
                $userid =isset($id) && is_numeric($id) ? intval($id) : 0 ;
                $userupdate = User::find_by_id($userid);

                $userupdate->username = $newuser  ;
                $userupdate->email = $emaildb ;
                $userupdate->phone = $Phone ;
                $userupdate->password = $pass ;
                $userupdate->save();

                if($userupdate->is_valid()){
                header("refresh:5;url= users.php?do=Manage");
                echo "<div class='alert alert-success'> Record Update </div>" ;

                }else{
                $formError[] = "Username is not valid !!";

                }


                }

}

$userid = isset($_GET["id"]) && is_numeric($_GET["id"]) ? intval($_GET["id"]) : 0;

$user = User::find_by_id($userid);
if ($user) {


?>
<h1 class="text-center ">Hello <?php echo $_SESSION['username']; ?> To Edit Page </h1>

    <!--  Edit Page    -->
<div class="container">
    <form action="Dashboard.php?do=edit&id=<?= $userid?>" method="post" class="form-horizontal form-edit">
        <?php if (isset($formError) && !empty($formError)) { ?>
            <div class="alert alert-danger alert-dismissible " role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <?php
                foreach ($formError as $errorr) {
                    echo $errorr . "<br/>";
                }
                ?>
            </div>
        <?php } ?>
        <input type="hidden" name="userID" value="<?php echo $userid; ?>"
        <!-- Start user name-->
        <div class="form-group form-group-lg">
            <label class="control-label col-sm-2 col-lg-4" for="">Username</label>
            <div class="col-sm-10 col-md-4 col-lg-5">
                <input type="text" name="username" class="form-control" required="required"
                       autocomplete="off"
                       value="<?php echo $user->username; ?>">
                <i class="chest fa fa-user"></i>
            </div>
        </div>

        <div class="form-group form-group-lg">
            <label class="control-label col-sm-2 col-lg-4" for="">PassWord</label>
            <div class="col-sm-10 col-md-4 col-lg-5">
                <input type="hidden" name="OldPassWord" value="<?php echo $user->password; ?>">
                <input type="PassWord" name="NewPassWord" class="form-control" autocomplete="off">
                <i class="chest fa fa-user-secret"></i>
            </div>
        </div>

        <div class="form-group form-group-lg">
            <label class="control-label col-sm-2 col-lg-4" for="">Email</label>
            <div class="col-sm-10 col-md-4 col-lg-5">
                <input type="Email" name="Email" class="form-control" required="required"
                       autocomplete="off"
                       value="<?php echo $user->email; ?>">
                <i class="chest fa fa-envelope"></i>
            </div>
        </div>
        <div class="form-group form-group-lg">
            <label class="control-label col-sm-2 col-lg-4" for="">Phone</label>
            <div class="col-sm-10 col-md-4 col-lg-5">
                <input type="text" name="Phone" class="form-control" required="required"
                       autocomplete="off"
                       value="<?php echo $user->phone; ?>">
                <i class="chest fa fa-user-plus"></i>
            </div>
        </div>
        <div class="form-group form-group-lg">
            <div class="col-sm-offset-2 col-sm-10 col-lg-offset-4 col-lg-5 ">
                <input type="submit" value="Update" class="btn btn-success btn-lg btn-block">
            </div>
        </div>
    </form>
    <a href="Dashboard.php?do=Manage" class="btn btn-primary"
       style="margin-left: 520px;background-color: #036503;border: none"><i class="fa fa-undo"></i> Dachboard</a>

</div>


<?php

} else {
    echo "<div class=\"container\"><div class='col-sm-offset-2 col-sm-8  col-md-offset-3 col-md-6  col-lg-offset-3 col-lg-6 alert alert-danger succ'>"
        . " user Not Found </div> </div>";

}
?>