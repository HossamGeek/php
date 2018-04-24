<?php

session_start();

if (isset($_SESSION["username"])){
    $ID = $_SESSION["Id"];
    $pagetitle = "Geek Family";
    include"ini.php";

    $do = isset($_GET['do']) ? $_GET['do'] : 'Manage' ;
    if($do == "edit") {
        $userid = isset($_GET["id"]) && is_numeric($_GET["id"]) ? intval($_GET["id"]) : 0;

        $user = User::find_by_id($userid);

        ?>
        <h1 class="text-center ">Hello <?php echo $_SESSION['username']; ?> To Edit Page </h1>
        <!--  Edit Page    -->
        <div class="container">
            <form action="?do=Update" method="post" class="form-horizontal">
                <input type="hidden" name="useID" value="<?php echo $userid; ?>"
                <!-- Start user name-->
                <div class="form-group form-group-lg">
                    <label class="control-label col-sm-2 col-lg-4" for="">Username</label>
                    <div class="col-sm-10 col-md-4 col-lg-5">
                        <input type="text" name="username" class="form-control" required="required" autocomplete="off"
                               value="<?php echo $user->username; ?>">
                        <i class="chest fa fa-user"></i>
                    </div>
                </div>

                <div class="form-group form-group-lg">
                    <label class="control-label col-sm-2 col-lg-4" for="">PassWord</label>
                    <div class="col-sm-10 col-md-4 col-lg-5">
                        <input type="hidden" name="OldPassWord">
                        <input type="PassWord" name="NewPassWord" class="form-control" autocomplete="off">
                        <i class="chest fa fa-user-secret"></i>
                        <i class="show-pass fa fa-eye-slash "></i>
                    </div>
                </div>

                <div class="form-group form-group-lg">
                    <label class="control-label col-sm-2 col-lg-4" for="">Email</label>
                    <div class="col-sm-10 col-md-4 col-lg-5">
                        <input type="Email" name="Email" class="form-control" required="required" autocomplete="off"
                               value="<?php echo $user->email; ?>">
                        <i class="chest fa fa-envelope"></i>
                    </div>
                </div>
                <div class="form-group form-group-lg">
                    <label class="control-label col-sm-2 col-lg-4" for="">Phone</label>
                    <div class="col-sm-10 col-md-4 col-lg-5">
                        <input type="text" name="Fullname" class="form-control" required="required" autocomplete="off"
                               value="<?php echo $user->phone; ?>">
                        <i class="chest fa fa-user-plus"></i>
                    </div>
                </div>
                <div class="form-group form-group-lg">
                    <div class="col-sm-offset-2 col-sm-10 col-lg-offset-4 col-lg-5 ">
                        <input type="submit" value="save" class="btn btn-primary btn-lg btn-block">
                    </div>
                </div>
            </form>
        </div>


        <?php
    }
}else{
    header("Location: index.php");
}

include $temp . "footer.php";?>