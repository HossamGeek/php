<?php

session_start();

if (isset($_SESSION["username"])){
    $ID = $_SESSION["Id"];
    $pagetitle = "Geek Family";
    include"ini.php";
    //$user = User::find('all', array('select' => 'id , username , email ,phone ,status,activation , userdelete'));

    $do = isset($_GET['do']) ? $_GET['do'] : 'Allpost' ;

    if($do == "Allpost") {
        $posts = Post::all();//find('all',array('select'=> 'id','content','p_status','created_at','u_id','cat_id'));


        ?>
        <h1 class="text-center"> <?php echo "welcome " . $_SESSION["username"]; ?> to Posts Members</h1>
        <div class="container">
            <div class="table-responsive text-center">
                <table class="main-table table table-bordered">
                    <tr style="background-color: #333;
    color: white;
    text-align: center;">
                        <td>#username</td>
                        <td>#Post</td>
                        <td>#Time_created</td>
                        <td>#Category</td>
                        <td>other</td>
                    </tr>

                    <?php
                    for ($i = 0; $i < count($posts); $i++) {
                        if ($posts[$i]->p_status != 1) {
                            $iduser = $posts[$i]->u_id;
                            $idcateg = $posts[$i]->cat_id;
                            //echo ($idcateg);
                            $username = User::find('all', array('conditions' => array('id = ?', $iduser)));
                            $categoryname = Cates::find('all', array('conditions' => array('id = ?', $idcateg)));
                            ?>
                            <tr>
                                <td><?= $username[0]->username ?></td>
                                <td><?= $posts[$i]->content ?></td>
                                <td><?= date("y-m-d h:i:s a", strtotime($posts[$i]->created_at)); ?></td>
                                <td><?= $categoryname[0]->name ?></td>

                                <td>
                                    <?php
                                    if ($posts[$i]->p_status == 0) {
                                        ?>
                                        <a href="posts.php<?php echo "?do=DisActive&type=post&id=" . $posts[$i]->id; ?>"
                                           class="btn Disactive btn-primary "><i class="fa fa-ban"
                                                                                 style="margin-right: 3px"></i>

                                            DisActive</a>

                                    <?php } else {

                                        echo "
                                        <a href='posts.php?do=Active&type=post&id=" . $posts[$i]->id . "
                                         ' class='btn  btn-primary'> <i class=\"fa fa-check\" style=\"margin-right: 3px\"></i>Active</a>";

                                    } ?>


                                </td>
                            </tr>
                        <?php }
                    }
                    ?>

                </table>
            </div>

            <a href="Dashboard.php?do=Manage" class="btn btn-primary"
               style="margin-left: 2px;background-color: #036503;border: none"><i class="fa fa-plus"></i> Dachboard</a>
        </div>
        <?php


    }else if($do == "Allcomment"){
            $comments = Comment::all();


            ?>
            <h1 class="text-center"> <?php echo "welcome ".$_SESSION["username"];?> to Comments Members</h1>
            <div class="container">
                <div class="table-responsive text-center">
                    <table class="main-table table table-bordered">
                        <tr style="background-color: #333;
    color: white;
    text-align: center;">
                            <td>#username</td>
                            <td>#comment</td>
                            <td>#Time_created</td>

                            <td>other</td>
                        </tr>

                        <?php
                        for ($i=0;$i<count($comments);$i++){
                            if ($comments[$i]->c_status != 1) {
                                $iduser = $comments[$i]->user_id;
                                $username =  User::find('all', array('conditions' => array('id = ?', $iduser)));
                                ?>
                                <tr>
                                    <td><?= $username[0]->username ?></td>
                                    <td><?= $comments[$i]->content ?></td>
                                    <td><?= date("y-m-d h:i:s a", strtotime($comments[$i]->created_at)); ?></td>

                                    <td>
                                        <?php
                                        if($comments[$i]->c_status == 0  ){
                                            ?>
                                            <a href="posts.php<?php echo "?do=DisActive&type=comment&id=" . $comments[$i]->id; ?>"
                                               class="btn Disactive btn-primary "><i class="fa fa-ban" style="margin-right: 3px"></i>

                                                DisActive</a>

                                        <?php }else{

                                            echo "
                                        <a href='posts.php?do=Active&type=comment&id=" . $comments[$i]->id ."
                                         ' class='btn  btn-primary'> <i class=\"fa fa-check\" style=\"margin-right: 3px\"></i>Active</a>";

                                        } ?>


                                    </td>
                                </tr>
                            <?php }
                        }
                        ?>

                    </table>
                </div>

                <a href="Dashboard.php?do=Manage" class="btn btn-primary" style="margin-left: 2px;background-color: #036503;border: none"><i class="fa fa-plus"></i> Dachboard</a>
            </div>
        <?php
    }else if($do == "Active") {
        $id = $_GET["id"];
        $type = $_GET["type"];
        if($type == "post"){
            $postid = isset($id) && is_numeric($id) ? intval($id) : 0;

            $postdisactive = Post::find_by_id($postid);

            $postdisactive->p_status = 0;
            $postdisactive->save();

            if(isset($_SERVER['HTTP_REFERER'])) {
                $previous = $_SERVER['HTTP_REFERER'];
                header("Location: $previous");
            }

        }elseif ($type == "comment"){
            $commentid = isset($id) && is_numeric($id) ? intval($id) : 0;

            $commentdisactive = Comment::find_by_id($commentid);

            $commentdisactive->c_status = 0;
            $commentdisactive->save();

            if(isset($_SERVER['HTTP_REFERER'])) {
                $previous = $_SERVER['HTTP_REFERER'];
                header("Location: $previous");
            }

        }


    }else if($do == "DisActive"){

        $id = $_GET["id"];
        $type = $_GET["type"];
        if ($type == "post"){
            $postid =isset($id) && is_numeric($id) ? intval($id) : 0 ;

            $postdisactive = Post::find_by_id($postid);
            $postdisactive->p_status = 1;
            $postdisactive->save();

            if(isset($_SERVER['HTTP_REFERER'])) {
                $previous = $_SERVER['HTTP_REFERER'];
                header("Location: $previous");
            }

           // header("Location: posts.php?do=Allpost");

        }elseif ($type == "comment"){
            $commentid = isset($id) && is_numeric($id) ? intval($id) : 0;

            $commentdisactive = Comment::find_by_id($commentid);
            $commentdisactive->c_status = 1;
            $commentdisactive->save();

            if(isset($_SERVER['HTTP_REFERER'])) {
                $previous = $_SERVER['HTTP_REFERER'];
                header("Location: $previous");
            }

        }

    }else if($do == "post"){
        $id = $_GET["id"];

        $userid =isset($id) && is_numeric($id) ? intval($id) : 0 ;

        $posts = Post::find('all', array('conditions' => array('u_id = ?', $userid)));

        ?>
        <h1 class="text-center"> <?php echo "welcome " . $_SESSION["username"]; ?> to Posts Members</h1>
        <div class="container">
            <div class="table-responsive text-center">
                <table class="main-table table table-bordered">
                    <tr style="background-color: #333;
    color: white;
    text-align: center;">
                        <td>#username</td>
                        <td>#Post</td>
                        <td>#Time_created</td>
                        <td>#Category</td>
                        <td>other</td>
                    </tr>

                    <?php
                    for ($i = 0; $i < count($posts); $i++) {
                            $iduser = $posts[$i]->u_id;
                            $idcateg = $posts[$i]->cat_id;

                            $username = User::find('all', array('conditions' => array('id = ?', $userid)));
                            $categoryname = Cates::find('all', array('conditions' => array('id = ?', $idcateg)));
                            //print_r($categoryname);
                            ?>
                            <tr>
                                <td><?= $username[0]-> username ?></td>
                                <td><?= $posts[$i]->content ?></td>
                                <td><?=date("y-m-d h:i:s a", strtotime($posts[$i]->created_at));  ?></td>
                                <td><?= $categoryname[0]->name ?></td>

                                <td>
                                    <?php
                                    if ($posts[$i]->p_status == 0) {
                                        ?>
                                        <a href="posts.php<?php echo "?do=DisActive&type=post&id=" . $posts[$i]->id; ?>"
                                           class="btn Disactive btn-primary "><i class="fa fa-ban"
                                                                                 style="margin-right: 3px"></i>

                                            DisActive</a>

                                    <?php } else {

                                        echo "
                                        <a href='posts.php?do=Active&type=post&id=" . $posts[$i]->id . "
                                         ' class='btn  btn-primary'> <i class=\"fa fa-check\" style=\"margin-right: 3px\"></i>Active</a>";

                                    } ?>


                                </td>
                            </tr>
                        <?php
                    }
                    ?>

                </table>
            </div>

            <a href="Dashboard.php?do=Manage" class="btn btn-primary"
               style="margin-left: 2px;background-color: #036503;border: none"><i class="fa fa-plus"></i> Dachboard</a>
        </div>

        <?php

    }else if($do == "comment"){
        $id = $_GET["id"];
        $userid =isset($id) && is_numeric($id) ? intval($id) : 0 ;
        $comments = Comment::find('all', array('conditions' => array('user_id = ?', $userid)));
        ?>
        <h1 class="text-center"> <?php echo "welcome ".$_SESSION["username"];?> to Comments Members</h1>
        <div class="container">
            <div class="table-responsive text-center">
                <table class="main-table table table-bordered">
                    <tr style="background-color: #333;
    color: white;
    text-align: center;">
                        <td>#username</td>
                        <td>#comment</td>
                        <td>#Time_created</td>
                        <td>other</td>
                    </tr>

                    <?php
                    for ($i=0;$i<count($comments);$i++){
                            $username =  User::find('all', array('conditions' => array('id = ?', $userid)));
                            ?>
                            <tr>
                                <td><?= $username[0]->username ?></td>
                                <td><?= $comments[$i]->content ?></td>
                                <td><?= date("y-m-d h:i:s a", strtotime($comments[$i]->created_at)); ?></td>

                                <td>
                                    <?php
                                    if($comments[$i]->c_status == 0  ){
                                        ?>
                                        <a href="posts.php<?php echo "?do=DisActive&type=comment&id=" . $comments[$i]->id; ?>"
                                           class="btn Disactive btn-primary "><i class="fa fa-ban" style="margin-right: 3px"></i>

                                            DisActive</a>

                                    <?php }else{

                                        echo "
                                        <a href='posts.php?do=Active&type=comment&id=" . $comments[$i]->id ."
                                         ' class='btn  btn-primary'> <i class=\"fa fa-check\" style=\"margin-right: 3px\"></i>Active</a>";

                                    } ?>


                                </td>
                            </tr>
                        <?php
                    }
                    ?>

                </table>
            </div>

            <a href="Dashboard.php?do=Manage" class="btn btn-primary" style="margin-left: 2px;background-color: #036503;border: none"><i class="fa fa-plus"></i> Dachboard</a>
        </div>
        <?php

    }

        ?>


<?php

}else{
    header("Location: index.php");
}

include $temp . "footer.php";

