<?php
session_start();
include'../inc/db_config.php';
include '../inc/header.php';
require_once('../view/courseView.php');
$course = new courseView();
$m_id=intval($_REQUEST['cid']);
$query="select * from course where courseid=$m_id";
$result=mysql_query($query);
while($m_rows=mysql_fetch_object($result))
{
    $m_coursename=$m_rows->coursename;
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta name="keywords" content="announcement">
  <meta name="description" content="AdminHomePage">
  <title>Delete Course</title>
  <link rel="stylesheet" href="../jscss/default.css" type="text/css" media="screen" />
  <link rel="stylesheet" type="text/css" href="../jscss/dist/css/bootstrap.min.css"> 
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="../jscss/jquery.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="../jscss/dist/js/bootstrap.min.js"></script>
    <script src="../jscss/ckeditor/ckeditor.js"></script>
</head>
<body>
    <!--breadcrumb-->
    <ol class="breadcrumb">
    <li><a href="adminHome.php">Home</a></li>
    <li><a href="courses.php">Courses</a></li>
    <li class="active">Delete Course</li>
    </ol>

    <div class="alert alert-warning" role="alert">
      <strong>Are you sure you wan to delete this course?</strong>
      <br>
    <form action="?action=delcouse?cid=<?php echo $m_id ?>" method="POST">
    <input type="hidden" name="cid" value="<?php echo $m_id ?>">
            <legend>Annoucement:</legend>
            <textarea name="coursename" id="coursename" rows="10" cols="80"><?php echo strip_tags($m_coursename); ?></textarea>
    <br>
    <input type="submit" class = "btn btn-default" name = "submit" value="Yes">
    <a class="btn btn-default" href="courses.php">No</a>
      <?php
          $course->delCourse()
      ?>
    </form>
    </div>
</body>
</html>