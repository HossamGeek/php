    <?php
/*
 *
 * include "conect.php";
$posts  = Post::all();

echo "<pre>";
print_r($posts);

echo"</pre>";

echo $posts[0]->title;

*/


session_start();

if (isset($_SESSION["username"])) {
    $ID = $_SESSION["Id"];
    $pagetitle = "DashBoard";
    include"ini.php";
    $posts  = Post::find('all', array('order' => 'created_at desc'));
    $cateogry = Cates::find('all');

?>
    <h1 class="text-center" xmlns="http://www.w3.org/1999/html"> <?php echo "welcome ".ucfirst($_SESSION["username"]);?> to Home</h1>
    <div class="container">


        <div class="w3-row-padding"style="margin-left:12% !important;width:77%;height: 250px">
            <div class="w3-col m12">
                <div class="w3-card w3-round w3-white">
                    <div class="w3-container w3-padding" >
                        <h4 class="w3-opacity">What's on Your Mind , <?php echo ucfirst($_SESSION["username"]);?> ? </h4>
                        <p contenteditable="true" class="w3-border w3-padding" style="height: 100px;color: black !important;"></p>
                        <button type="button" class="w3-button w3-theme"><i class="fa fa-pencil"></i>  Post</button>

                        <select class="w3-button w3-theme form-control" style="display:inline-block;background-color: #696a6d !important;width : 100px;height: 37px">
                            <?php for ($i=0;$i<count($cateogry);$i++){?>
                            <option  value="<?php $cateogry[$i]->id ?>"><?php echo $cateogry[$i]->name ;?></option>
                            <?php }?>
                        </select>
                    </div>
                </div>
            </div>
        </div>


        <?php  for ($i=0;$i<count($posts);$i++){
            $userid = $posts[$i]->u_id;
            $cateid = $posts[$i]->cat_id;
            $users = User::find_by_id($userid);
            $cates = Cates::find_by_id($cateid);
            ?>
        <div class="w3-container w3-card w3-white w3-round w3-margin" style="margin-left:15% !important;width:70%; height:300px;"><br>

            <span class="w3-right w3-opacity"><?php echo timeAgo($posts[$i]->created_at);?></span>
            <h2 style="cursor: pointer; color: #2e6da4"><?php echo  ucfirst( $users->username) ;?></h2>

            <span  class="btn btn-success" style="background-color: #3e6d50 ;border: none;font-weight: bold">"<?php echo $posts[$i]->title;?>"</span>
            <span  class="btn btn-primary" style="background-color: #95463f ;border: none; margin-left: 5px;font-weight: bold"><?php echo $cates->name;?></span>
            <hr class="w3-clear">
            <?php if(strlen($posts[$i]->content) > 90 ){
                echo "<span style=\"color: black\">". substr($posts[$i]->content,0,90)." ..."."</span>"."<a href=\"\"  style=\"text-decoration: underline; color: #243495;width:100px;border: none \"><i class=\"fa fa-eye\" style=\"margin-right: 3px\"></i>See more</a><br><br>";
                }else{
                echo "<p style='color: black'>". $posts[$i]->content."</p>";

             }?>
            <a href="" class="btn btn-primary" style="  background-color: #952c51;border: none;width:100px "><i class="fa fa-comment" style="margin-right: 3px"></i>Comment</a>
            <span  class="btn btn-success" style="margin-left: 10px;font-weight: bold"><i class="fa fa-edit" style="margin-right: 3px"></i>Edit</span>
            <span  class="btn btn-danger" style="margin-left: 10px;font-weight: bold"><i class="fa fa-sign-out" style="margin-right: 3px"></i>Delete</span>

        </div>
        <?php }?>
    </div>





<?php






}else{
    header("Location: index.php");
}

include $temp . "footer.php";


