<?php
session_start();
include'../inc/db_config.php';
include '../inc/header.php';
require_once('../view/userView.php');
$user = new userView();
$m_id=intval($_REQUEST['userid']);
$query="select * from user where userid=$m_id";
$result=mysql_query($query);
while($m_rows=mysql_fetch_object($result))
{
    $m_username=$m_rows->username;
    $m_rank=$m_rows->rank;
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta name="keywords" content="announcement">
  <meta name="description" content="AdminHomePage">
  <title>Edit User</title>
  <link rel="stylesheet" href="../jscss/default.css" type="text/css" media="screen" />
  <link rel="stylesheet" type="text/css" href="../jscss/dist/css/bootstrap.min.css"> 
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script type="text/javascript" src="../jscss/jquery.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="../jscss/dist/js/bootstrap.min.js"></script>
    <script src="../jscss/ckeditor/ckeditor.js"></script>
</head>
<body>
    <!--breadcrumb-->
    <ol class="breadcrumb">
    <li><a href="adminHome.php">Home</a></li>
    <li><a href="manageAccount.php">Account</a></li>
    <li class="active">Edit Account</li>
    </ol>
    <div align = "center">
    <form action="?action=editaccount?userid=<?php echo $m_id ?>" method="POST">
    <input type="hidden" name="userid" value="<?php echo $m_id ?>">
    <table class="table table-bordered">
        <tr>
           <td width="20%" >UserName: </td><td><?php echo $m_username ?></td>
         </tr>
         <tr>
           <td width="20%">Rank: </td>
           <!--<td><input type="text" name="rank" id = "rank" value="<?php echo $m_rank ?>"></td>-->
           <td>
            <select name = "rank">
              <?php 
              if ($m_rank == 1)
              {
                echo "<option value=\"1\" selected>Super Admin</option>";
                echo "<option value=\"2\">Admin</option>";
                echo "<option value=\"3\">User</option>";
              }
              else if ($m_rank ==2) 
              {
                echo "<option value=\"1\">Super Admin</option>";
                echo "<option value=\"2\"selected>Admin</option>";
                echo "<option value=\"3\">User</option>";
              }
               else if ($m_rank ==3) 
              {
                echo "<option value=\"1\">Super Admin</option>";
                echo "<option value=\"2\">Admin</option>";
                echo "<option value=\"3\"selected>User</option>";
              }
              ?>
              </select>
            </td>
          </tr>
          <?php
            if($m_rank == 2)
            {
              $query1="select * from course";
              $result1=mysql_query($query1);
              echo "<tr>";
              echo "<td width=\"20%\">Course: </td>";
              echo "<td>";
              while($m_rows=mysql_fetch_object($result1))
              {

                 $cquery = "select * from permission where courseid = $m_rows->courseid";
                 $cresult = mysql_query($cquery);
                 if (mysql_num_rows($cresult) == 0) 
                  {
                    echo "<input type=\"checkbox\" name=\"permCourse[]\" value=\"$m_rows->courseid\" />".$m_rows->coursename."</br>";
                  }
                else
                  {
                    echo "<input type=\"checkbox\" name=\"permCourse[]\" value=\"$m_rows->courseid\" checked/>".$m_rows->coursename."</br>";
                  }


                echo "<input type=\"checkbox\" name=\"permCourse[]\" value=\"$m_rows->courseid\" />".$m_rows->coursename."</br>";

              }
              echo "</td>";
              
              echo "</tr>";
            }

            if(isset($_POST['permCourse']))
            {
              $perm = $_POST['permCourse'];
              $query2 = "select * from permission where userid = $m_id";
              $result2 = mysql_query($query2);
              if (mysql_num_rows($result2) != 0) 
              {
                 $sql="delete from permission where userid=$m_id";
                 $result3 = mysql_query($sql);
              } 
              
              if(!empty($perm))
              {
                $n = count($perm);
                for($i=0;$i < $n; $i++)
                {
                  $sql1 = "insert into permission (userid,courseid) values ($m_id,$perm[$i])";
                  $result3 = mysql_query($sql1);
                  //echo($perm[$i] . " ");
                }
              }
            }
            


            $perm = $_POST['permCourse'];
            $query2 = "select * from permission where userid = $m_id";
            $result2 = mysql_query($query2);
            if (mysql_num_rows($result2) != 0) 
            {
               $sql="delete from permission where userid=$m_id";
               $result3 = mysql_query($sql);
            } 
            
            if(!empty($perm))
            {
              $n = count($perm);
              for($i=0;$i < $n; $i++)
              {
                $sql1 = "insert into permission (userid,courseid) values ($m_id,$perm[$i])";
                $result3 = mysql_query($sql1);
                //echo($perm[$i] . " ");
              }
            }


          ?>

    </table>
    <br>
    
    <button name="submit" type="submit" class="btn btn-default">Submit</button>&nbsp&nbsp<button type="reset" class="btn btn-default">Reset</button>
    </div>
      <?php
          $user->editAcc()
      ?>
    </form>
</body>
</html>