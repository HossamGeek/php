<?php

session_start();

if (isset($_SESSION["username"])){
    $ID = $_SESSION["Id"];
    $pagetitle = "DashBoard";
    include"ini.php";
    $user = User::find('all', array('select' => 'id , username , email ,phone ,status,activation , userdelete'));

    $do = isset($_GET['do']) ? $_GET['do'] : 'Manage' ;

    if($do == "Manage"){
        ?>
        <h1 class="text-center"> <?php echo "welcome ".$_SESSION["username"];?> to Registers Member</h1>

        <div class="container">
            <div class="table-responsive text-center">
                <table class="main-table table table-bordered">
                    <tr style="background-color: #333;
    color: white;
    text-align: center;">
                        <td>#Username</td>
                        <td>#Mail</td>
                        <td>#Phone</td>
                        <td>#Posts & #Comments</td>
                        <td>other</td>
                    </tr>

                    <?php
                    for ($i=0;$i<count($user);$i++){
                        if ($user[$i]->status != 1 && $user[$i]->userdelete != 1) {
                            ?>
                            <tr>
                                <td><?= $user[$i]->username ?></td>
                                <td><?= $user[$i]->email ?></td>
                                <td><?= $user[$i]->phone ?></td>
                                    <td>
                                        <a href="posts.php?do=post<?php echo "&id=" . $user[$i]->id; ?>" class="btn btn-success "
                                           style="border: none;background-color: #e92344" >
                                            <i class="fa fa-send" style="margin-right: 3px"></i>
                                            Posts</a>
                                        <a href="posts.php?do=comment<?php echo "&id=" . $user[$i]->id; ?>" class="btn btn-primary "style="background-color: #005389" >
                                            <i class="fa fa-comment" style="margin-right: 3px;"></i>
                                            Comments</a>
                                    </td>
                                <td>

                                    <a href="Dashboard.php<?php echo "?do=edit&id=" . $user[$i]->id; ?>" class="btn btn-success" >
                                        <i class="fa fa-edit" style="margin-right: 3px"></i>Edit</a>
                                    <a href="Dashboard.php<?php echo "?do=delete&id=" . $user[$i]->id; ?>" class="btn btn-danger">
                                        <i class="fa fa-trash" style="margin-right: 3px"></i>Delete</a>

                                    <?php
                                    if($user[$i]->activation == 0  ){
                                        ?>
                                        <a href="Dashboard.php<?php echo "?do=DisActive&id=" . $user[$i]->id; ?>"
                                           class="btn Disactive btn-primary "><i class="fa fa-ban" style="margin-right: 3px"></i>

                                            DisActive</a>

                                    <?php }else{

                                        echo "
                                        <a href='Dashboard.php?do=Active&id=" . $user[$i]->id ."
                                         ' class='btn  btn-primary'> <i class=\"fa fa-check\" style=\"margin-right: 3px\"></i>Active</a>";

                                    } ?>


                                </td>
                            </tr>
                        <?php }
                    }
                    ?>

                </table>
            </div>

            <a href="Dashboard.php?do=Add" class="btn btn-primary" style=" margin-left: 2px;background-color:#2bb39f ;border: none "><i class="fa fa-plus"></i>
                Add Member</a>
            <a href="Dashboard.php?do=category" class="btn btn-primary" style=" margin-left: 20px;background-color: #e67f5c;border: none">
                <i class="fa fa-plus"></i> Add Category</a>
            <a href="posts.php?do=Allpost" class="btn btn-primary" style=" margin-left: 180px;background-color: #9b4487;border: none ">
                <i class="fa fa-send" style="margin-right: 3px"></i> All posts</a>
            <a href="posts.php?do=Allcomment" class="btn btn-primary" style=" margin-left: 30px;background-color: #72606e;border: none ">
                <i class="fa fa-comment" style="margin-right: 3px;"></i>
                All Comment</a>

            <a href="Logout.php" class="btn btn-primary" style=" background-color: #363b59;  margin-left: 310px;width:100px "><i class="fa fa-sign-out" style="margin-right: 3px"></i>Logout</a>
        </div>
        <?php
    }

    else if($do == "delete"){

        $id = $_GET["id"];
        $userid =isset($id) && is_numeric($id) ? intval($id) : 0 ;

        $userdelete = User::find_by_id($userid);
        if($userdelete){
        $userdelete->userdelete = 1;
        $userdelete->save();
        header("Location: Dashboard.php?do=Manage");
            }else{
            echo "<div class=\"container\"><div class='col-sm-offset-2 col-sm-8  col-md-offset-3 col-md-6  col-lg-offset-3 col-lg-6 alert alert-danger succ'>"
                . "user Not Found </div> </div>" ;
        }


        }
        else if($do == "DisActive"){


            $id = $_GET["id"];
            $userid =isset($id) && is_numeric($id) ? intval($id) : 0 ;

            $useractive = User::find_by_id($userid);
            //print_r($userdelete);
            if($useractive){
                $useractive->activation = 1;
                $useractive->save();
                header("Location: Dashboard.php?do=Manage");
                }else{
                echo "<div class=\"container\"><div class='col-sm-offset-2 col-sm-8  col-md-offset-3 col-md-6  col-lg-offset-3 col-lg-6 alert alert-danger succ'>"
                    . "user Not Found </div> </div>" ;
            }
    }
    else if($do == "Active"){

        $id = $_GET["id"];
        $userid =isset($id) && is_numeric($id) ? intval($id) : 0 ;

        $userdisactive = User::find_by_id($userid);
        if($userdisactive){
            $userdisactive->activation = 0 ;
            $userdisactive->save();
            header("Location: Dashboard.php?do=Manage");
        }else{
            echo "<div class=\"container\"><div class='col-sm-offset-2 col-sm-8  col-md-offset-3 col-md-6  col-lg-offset-3 col-lg-6 alert alert-danger succ'>"
                . "user Not Found </div> </div>" ;
        }
    }
    else if($do == "edit") {

        include "users/edit.php";

    }
    elseif ($do == "Add"){
        ?>
        <h1 class="text-center " style="color: #009673 ;" > # Add Member #</h1>
        <?php
        if($_SERVER["REQUEST_METHOD"] == "POST") {
            $users = $_POST["username"];
            $email =$_POST["Email"];
            $Phone = $_POST["Phone"];
            $pass = $_POST["NewPassWord"];
            $newuser = filter_var($users, FILTER_SANITIZE_STRING );


            $formErrors = array();

            /**Start vilidation **/

            if( strlen($newuser) < 3){
                $formErrors[]="Username must be greater than 3  ";
            }
            if(strlen($newuser) > 10  ){
                $formErrors[]="Username must be  smaller than 10 ";
            }

            if(empty($newuser)){
                $formErrors[]="Username must be Not Empty ";
            }



            if(filter_var($email,FILTER_VALIDATE_EMAIL) !== FALSE){
                $emaildb = $email;
            }else{
                $formErrors[] = "plz. Write correct Mail ";
            }
            if(empty(trim($email))){
                $formErrors[] = "Mail not be empty";
            }


            if(empty($pass)){
                $formErrors[]="Username must be Not Empty ";
            }
            if(strlen($pass) < 5){
                $formErrors[]="Password must be greater than 5 ";
            }

            if(!preg_match("#[a-zA-Z]+#", $pass)|| !preg_match("#[0-9]+#", $pass)){
                $formErrors[]= "password must include at least a letter and  number Not include (+,@,#,..,&) ";
            }


            /**End vilidation **/
            if(empty($formErrors)) {
                $saniPass = filter_var($pass, FILTER_SANITIZE_STRING);
                $newpass = sha1($saniPass);
                $active = 1;

                $Newuserdb = User::create(array('username' => $newuser, 'password' => $newpass, 'email' => $emaildb,"phone" =>$Phone,"activation" => 1));


                if($Newuserdb->is_valid()){
                    $usercheck = User::find_by_username($newuser);

                    echo "<div class=\"container\"><div class='col-sm-offset-2 col-sm-8  col-md-offset-3 col-md-6  col-lg-offset-3 col-lg-6 alert alert-success succ'>"
                        . "user Added</div> </div>" ;
                        header("Location: Dashboard.php?do=Manage");

                }else{
                    $formErrors[] = "Username is not valid !!";

                }


            }



        }


        ?>


        <!--  Add Page    -->
        <div class="container">
            <form action="Dashboard.php?do=Add"  method="POST" class="form-horizontal form-edit">

                <?php if(!empty($formErrors) ) {?>
                    <div class="col-sm-offset-2 col-sm-8  col-md-offset-3 col-md-6  col-lg-offset-3 col-lg-6
                                                    alert alert-danger alert-dismissable" role="start">
                        <button type="button" class="close" data-dismiss="alert" aria-label="close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <?php
                        foreach ($formErrors as $errors){
                            echo $errors."<br/>";
                        }
                        ?>
                    </div>
                <?php } ?>



                <!-- Start user name-->
                <div class="form-group form-group-lg">
                    <label class="control-label col-sm-2 col-lg-4" for="">Username</label>
                    <div class="col-sm-10 col-md-4 col-lg-5">
                        <input type="text" name="username" class="form-control" required="required" autocomplete="off"
                               value="<?php if(isset($users)){echo $users;} ?>">
                        <i class="chest fa fa-user"></i>
                    </div>
                </div>

                <div class="form-group form-group-lg">
                    <label class="control-label col-sm-2 col-lg-4" for="">PassWord</label>
                    <div class="col-sm-10 col-md-4 col-lg-5">
                        <input type="PassWord" name="NewPassWord" class="form-control" autocomplete="off">
                        <i class="chest fa fa-user-secret"></i>
                    </div>
                </div>

                <div class="form-group form-group-lg">
                    <label class="control-label col-sm-2 col-lg-4" for="">Email</label>
                    <div class="col-sm-10 col-md-4 col-lg-5">
                        <input type="Email" name="Email" class="form-control" required="required" autocomplete="off"
                               value="<?php if(isset($email)){echo $email;} ?>">
                        <i class="chest fa fa-envelope"></i>
                    </div>
                </div>
                <div class="form-group form-group-lg">
                    <label class="control-label col-sm-2 col-lg-4" for="">Phone</label>
                    <div class="col-sm-10 col-md-4 col-lg-5">
                        <input type="text" name="Phone" class="form-control" required="required" autocomplete="off"
                               value="<?php if(isset($Phone)){echo $Phone;} ?>">
                        <i class="chest fa fa-user-plus"></i>
                    </div>
                </div>
                <div class="form-group form-group-lg">
                    <div class="col-sm-offset-2 col-sm-10 col-lg-offset-4 col-lg-5 ">
                        <input type="submit" value="Add" class="btn btn-success btn-lg btn-block">
                    </div>
                </div>
            </form>

            <a href="Dashboard.php?do=Manage" class="btn btn-primary"
               style=" margin-left: 47%;background-color: #036503;border: none"><i class="fa fa-undo"></i> Dachboard</a>

        </div>

        <?php
        /*
        if($_SERVER["REQUEST_METHOD"] == "POST") {
            $user = $_POST["username"];
            echo $user;
        }*/

    }
    elseif ($do == "category"){

        $cates = Cates::all();

        ?>
        <h1 class="text-center " style="color: #009673 ;" > # Add Category #</h1>
        <a href="Dashboard.php?do=Manage" class="btn btn-primary" style="  background-color: #363b59;  margin-left:46%;width:120px "><i class="fa fa-sign-out" style="margin-right: 3px"></i>DashBoard </a>
        <?php
        if($_SERVER["REQUEST_METHOD"] == "POST") {
        $Category = $_POST["Category"];

            $formErrors = array();

            /**Start vilidation **/

            if( strlen($Category) < 3){
                $formErrors[]="Category must be greater than 3  ";
            }
            if(strlen($Category) > 30  ){
                $formErrors[]="Category must be  smaller than 10 ";
            }

            if(empty($Category)){
                $formErrors[]="Category must be Not Empty ";
            }

            if(empty($formErrors)) {
                $NewCategory = filter_var($Category, FILTER_SANITIZE_STRING);
                $Newcates = Cates::create(array('name' => $NewCategory));


                if($Newcates){
                    header("Location: Dashboard.php?do=category");
                }else{
                    $formErrors[]="Category Can't Added";
                }

            }


        }
        ?>
        <div class="container">
            <form action="Dashboard.php?do=category"  method="POST" class="form-horizontal form-edit">

                <?php if(!empty($formErrors) ) {?>
                    <div class="col-sm-offset-2 col-sm-8  col-md-offset-3 col-md-6  col-lg-offset-3 col-lg-6
                                                    alert alert-danger alert-dismissable" role="start" style="margin-bottom: 10px;">
                        <button type="button" class="close" data-dismiss="alert" aria-label="close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <?php
                        foreach ($formErrors as $errors){
                            echo $errors."<br/>";
                        }
                        ?>
                    </div>
                <?php } ?>

                <h3 style="color: #6d3840;margin-bottom: 15px;width: 190px">All category</h3>

                <select class="form-control" style="margin-bottom: 25px">
                    <?php for($i =0;$i<count($cates);$i++){?>
                    <option value="<?php echo $cates[$i]->id;?>"><?php echo $cates[$i]->name;?></option>
                    <?php }?>
                </select>
                        <input type="text" name="Category" class="form-control" placeholder="Add Category" required="required" autocomplete="off"
                               value="<?php if(isset($Category)){echo $Category;} ?>" style="margin-bottom: 25px;padding-left: 10px">

                <input type="submit" value="Add Category" class="btn btn-success btn-lg btn-block">
            </form>
        </div>
    <?php

    }


    else{

        echo "<div class=\"container\"><div class='col-sm-offset-2 col-sm-8  col-md-offset-3 col-md-6  col-lg-offset-3 col-lg-6 alert alert-danger succ'>"
            . "Page Not Found </div> </div>" ;

    }

    ?>

<?php



}else{
    header("Location: index.php");
}

include $temp . "footer.php";
?>









