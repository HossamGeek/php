<?php
    session_start();
    if (isset($_SESSION["username"])){
      header("Location: Dashboard.php");

    }
    $pagetitle = "Geek Family";
    include"ini.php";


    if ($_SERVER["REQUEST_METHOD"] === "POST"){
        /**If Have Account**/

        $submit = $_POST["log"];
        $errors = array();

        if($submit === "Log in" ) {
            $user = filter_var(strtolower($_POST["user"]), FILTER_SANITIZE_STRING);
            $userdb = strtolower($user);
            $password = $_POST["password"];
            $shapass = sha1($password);




            if (empty($user)) {
                $errors[] = "Username must not Be empty";
            }

            if (empty($password)) {
                $errors[] = "Password must not Be empty";
            }

            if (empty($errors)) {

                $usercheck = User::find_by_username($userdb);





                if(!isset($usercheck->id)){
                    $errors[] = "Username or Password not correct !!";
                }else {

                    if ( $usercheck->status == 1 ){
                        $ID = $usercheck->id ;
                        $_SESSION["username"] = $usercheck->username;
                        $_SESSION["Id"] = $ID;
                        header("Location: Dashboard.php?do=Manage");

                    }elseif ($usercheck->status  == 0){

                        $ID = $usercheck->id ;
                        $_SESSION["username"] = $usercheck->username;
                        $_SESSION["Id"] = $ID;
                        header("Location: home.php");
                    }
                }
            }
        }
        /**If not Have Account**/
        else{
        $newuser = filter_var(strtolower($_POST["newuser"]),FILTER_SANITIZE_STRING);
        $email = $_POST["email"];
        $Phonenum = $_POST["Phone"];
        $passnewuser = $_POST["newpassword"];


        if(strlen($newuser) > 10 || is_numeric($newuser) || empty(trim($newuser)))
        {
            $errors[] = "Username must Be less than   <strong> 10 </strong> characters and not be integer and not be empty";
        }
        //email
        if(filter_var($email,FILTER_VALIDATE_EMAIL) !== FALSE){
                $emaildb = $email;
        }else{
            $errors[] = "plz. Write correct Mail ";
        }
        if(empty(trim($email))){
            $errors[] = "Mail not be empty";
        }

        //password
        if(!preg_match('/^(?=.*[A-Za-z])[0-9A-Za-z!@#$%]{8,12}$/',$passnewuser)){
            $errors[] = "password at least one letter and it has to be a number following and  be 8-12 characters ";
        }else{
            $shapassagain = sha1($passnewuser);
        }
        //phone
        if(is_numeric($Phonenum)){
            $Phone = (string)$Phonenum;
            if(strlen($Phone) > 15 || empty(trim($Phone)))
            {
                $errors[] = "Phone must Be less than   <strong> 15 </strong> number and not be empty";

            }
        }else
        {
            $errors[] = "Phone must Be  number ";
        }

            if (empty($errors)) {

                $Newuserdb = User::create(array('username' => $newuser, 'password' => $shapassagain, 'email' => $emaildb,"phone" =>$Phone));


                if($Newuserdb->is_valid()){
                    $usercheck = User::find_by_username($newuser);
                    if($usercheck->status  == 0){
                        $ID = $usercheck->id ;
                        $_SESSION["username"] = $usercheck->username;
                        $_SESSION["Id"] = $ID;
                        header("Location: home.php");
                    }
                }else{
                    $errors[] = "Username is not valid !!";

                }
            }

        }
    }


?>

    <div class="pic">
        <div class="pic1">
            <img class="img1"  src="layout/image/girly_desk-wallpaper-2400x1350.jpg">
            <!--
                        <div class="textforma">
                            <p class="textformal">Connect with your friends and other fascinating people.
                                Get in the moment updates on the things that
                                interest you. And watch events unfold, in real time, from every angle.
                                <span style="font-size: 15px;color: #d1d1d5;margin-left: 20px; ">
                                <i class="fa fa-heart-o" aria-hidden="true"></i> Geek Family <i class="fa fa-heart-o" aria-hidden="true"></i></span></p>
                        </div>
                        -->
                    </div>

                    <div class="pic2">
                        <img class="img2"  src="layout/image/pexels-photo-225502.jpeg">
                    </div>

                    <div class="pic3">
                        <img class="img3"  src="layout/image/pexels-photo-450035.jpeg">
                        <!--
                        <div class="textforma2">
                            <p class="textformal">“You may say I'm a dreamer, but I'm not the only one. I hope someday you'll join us. And the world will live as one.”
                                <span style="font-size: 15px;color: #d1d1d5;margin-left: 20px; "><i class="fa fa-heart-o" aria-hidden="true">
                                    </i> John Lennon <i class="fa fa-heart-o" aria-hidden="true"></i></span></p>
                        <?php echo $_SERVER['PHP_SELF'];?>
                        </div>
                            -->
                     </div>


    </div>

    <div class="container">
        <h3 class="textlogin">Welcome In <span style="color:#1da1f2;">Elhrm </span> Family</h3>
        <form class="login"   action="<?php echo $_SERVER["PHP_SELF"];?>"  method="post"  style="<?php if (isset($errors) && !empty($errors)) { echo "top: 170px";}else{echo "top: 250px"; }?>">
            <?php if (isset($errors) && !empty($errors)) { ?>
                <div class="alert alert-danger alert-dismissible " role="alert">
                  <!--  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>-->
                    <?php
                    foreach ($errors as $errorr) {
                        echo $errorr . "<br/>";
                    }
                    ?>
                </div>
            <?php } ?>
        <input type="submit" class="btn btn1 btn-primary" id="log" name="log"  value="Log in" formnovalidate>
        <input type="submit"  class="btn btn2 btn-primary" id="sign" name="log" value="Sign up" formnovalidate>




        <div class="hidde">
        <input type="text" class="form-control user" name="user" placeholder="Username" autocomplete="off" required="required">
            <i class="fa fa-user" aria-hidden="true"></i>
        <input type="password" class="form-control password" name="password" placeholder="password" autocomplete="off" required="required">
            <i class="fa fa-user-secret" aria-hidden="true"></i>
        </div>

        <div class="hidde2">
            <input type="text" class="form-control newuser" name="newuser"  value="<?php if (isset($newuser)) echo $newuser; ?>"
                   placeholder="Username" autocomplete="off" required="required">
            <i class="fa fa-user" aria-hidden="true"></i>
            <input type="email" class="form-control email" name="email" value="<?php if (isset($email)) echo $email; ?>"
                   placeholder="email" autocomplete="off" required="required">
            <i class="fa fa-envelope" aria-hidden="true"></i>
            <input type="text" class="form-control phone" name="Phone" value="<?php if (isset($Phone)) echo $Phone; ?>"
                   placeholder="Phone No." autocomplete="off" required="required">
            <i class="fa fa-phone" aria-hidden="true"></i>
            <input type="password" class="form-control pass" name="newpassword" placeholder="password" autocomplete="off" required="required">
            <i class="fa fa-user-secret" aria-hidden="true"></i>
        </div>

        </form>

</div>

<?php
include $temp . "footer.php";
?>
