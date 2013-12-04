<?php
  if(empty($_FILES['image']['name']){
    $image = 'noimage.jpg';
  }else{
    $image = date('YmdHis').$_FILES['image']['name'];
    move_uploaded_file($_FILES['image']['tmp_name'],'../member_picture/'.$image);
  }
  $_SESSION['join'] = $_POST;
  $_SESSION['join']['image'] = $image;
?>