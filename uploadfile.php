<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8" />
</head>
<body>
 
 <?php 
 
    $dsn = 'データベース名';
	$user = 'ユーザー名';
	$password = 'パスワード';
	$pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
	$sql = "CREATE TABLE IF NOT EXISTS tbtest"
	." ("
	. "id INT AUTO_INCREMENT PRIMARY KEY,"
	. "name char(32),"
	. "comment TEXT"
	//. "dt DATETIME"
	.");";
	$stmt = $pdo->query($sql);
	
	/*$sql=('ALTER TABLE tbtest ADD dt datetime AFTER comment');
	$stmt=$pdo->prepare($sql);
	$stmt->execute();*/
	
	//パスワードカラム追加
	/*$sql=('ALTER TABLE tbtest ADD pass TEXT AFTER comment');
	$stmt=$pdo->prepare($sql);
	$stmt->execute();*/

	  
    
	
	
	//投稿フォームに名前とコメントが入力されたらdbに保存
	if(isset($_POST["submit"])){
	    $name = $_POST["name"];
	    $comment = $_POST["comment"]; 
	    $pass=$_POST["pass"];
	    $dt = date("Y-m-d H:i:s"); 
	 if($name!==''&&$comment!=='' && $pass){
	   // $sql="ALTER TABLE tbtest ADD dt datetime AFTER comment";
	    $sql = $pdo -> prepare("INSERT INTO tbtest (name, comment,pass,dt) VALUES (:name, :comment,:pass,:dt)");
	    $sql -> bindParam(':name', $name, PDO::PARAM_STR);
	    $sql -> bindParam(':comment', $comment, PDO::PARAM_STR);
	    $sql -> bindParam(':dt', $dt, PDO::PARAM_STR);
	    $sql -> bindParam(':pass', $pass, PDO::PARAM_INT);
	    $sql -> execute();
	    
	    
	    
	   

	 }
	}
	
	
	//削除機能
	if(isset($_POST["delSubmit"])){
	    $delete=$_POST["delete"];
	    $Dpass=$_POST["Dpass"];
	    if($delete!==''){
	       $sql = 'SELECT * FROM tbtest';
	       $stmt = $pdo->query($sql);
	       $results = $stmt->fetchAll();
	       foreach($results as $row){
	          $id=$row['id'];
	          $Pass=$row['pass'];
	        if($id==$delete && $Dpass==$Pass){
	            $id=$delete;
	            $sql = ('delete from tbtest where id=:id');
	            $stmt = $pdo->prepare($sql);
	            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
	            $stmt->execute();
	        }     
	       } 
	    }
	}
	
	//編集機能
/*	if(isset($_POST["editSubmit"])){
	    $edit=$_POST["edit"];
	    $Epass=$_POST["Epass"];
	    if($edit!==''){
	      $sql = 'SELECT * FROM tbtest';
	      $stmt = $pdo->query($sql);
	      $results = $stmt->fetchAll();  
	      foreach($results as $row){
	          $id=$row['id'];
	          $Pass=$row['pass'];
	          if($id==$edit && $Pass==$Epass){
	              $id = $edit; //変更する投稿番号
	              echo $row;
	          }
	      }
	    }
	}*/
	
	
 ?>
 <form method="POST" action="">
      <input type="text" name="name" placeholder="名前" value="<?php 	
        if(isset($_POST["editSubmit"])){
	    $edit=$_POST["edit"];
	    $Epass=$_POST["Epass"];
	    if($edit!==''){
	      $sql = 'SELECT * FROM tbtest';
	      $stmt = $pdo->query($sql);
	      $results = $stmt->fetchAll();  
	      foreach($results as $row){
	          $id=$row['id'];
	          $Pass=$row['pass'];
	          if($id==$edit && $Pass==$Epass){
	              $id = $edit; //変更する投稿番号
	              echo $row['name'];
	          }
	      }
	    }
	}?>"><br>
      <input type="text" name="comment" placeholder="コメント" value="<?php
      	if(isset($_POST["editSubmit"])){
	    $edit=$_POST["edit"];
	    $Epass=$_POST["Epass"];
	    if($edit!==''){
	      $sql = 'SELECT * FROM tbtest';
	      $stmt = $pdo->query($sql);
	      $results = $stmt->fetchAll();  
	      foreach($results as $row){
	          $id=$row['id'];
	          $Pass=$row['pass'];
	          if($id==$edit && $Pass==$Epass){
	              $id = $edit; //変更する投稿番号
	              echo $row['comment'];
	          }
	      }
	    }
	}?>"><br>
      <input type="number" name="number" >
      <input type="text" name="pass" placeholder="パスワード"><br>
      <input type="hidden" name="Hname" value="<?php 	
        if(isset($_POST["editSubmit"])){
	    $edit=$_POST["edit"];
	    $Epass=$_POST["Epass"];
	    if($edit!==''){
	      $sql = 'SELECT * FROM tbtest';
	      $stmt = $pdo->query($sql);
	      $results = $stmt->fetchAll();  
	      foreach($results as $row){
	          $id=$row['id'];
	          $Pass=$row['pass'];
	          if($id==$edit && $Pass==$Epass){
	              $id = $edit; //変更する投稿番号
	              echo $row['name'];
	          }
	      }
	    }
	}?>">
	  <input type="hidden" name="Hcomment" value="<?php
      	if(isset($_POST["editSubmit"])){
	    $edit=$_POST["edit"];
	    $Epass=$_POST["Epass"];
	    if($edit!==''){
	      $sql = 'SELECT * FROM tbtest';
	      $stmt = $pdo->query($sql);
	      $results = $stmt->fetchAll();  
	      foreach($results as $row){
	          $id=$row['id'];
	          $Pass=$row['pass'];
	          if($id==$edit && $Pass==$Epass){
	              $id = $edit; //変更する投稿番号
	              echo $row['comment'];
	          }
	      }
	    }
	}?>">
	  <input type="submit" name="submit" value="送信">
 </form>
 <form method="POST" action="">
      <input type="text" name="delete" placeholder="削除対象番号"><br>
      <input type="text" name="Dpass" placeholder="パスワード"><br>
      <input type="submit" value="削除" name="delSubmit"><br>
 </form>
 <form method="POST" action="">
      <input type="text" name="edit" placeholder="編集対象番号"><br>
      <input type="text" name="Epass" placeholder="パスワード"><br>
      <input type="submit" value="編集" name="editSubmit">
 </form>
 <?php 
 if(isset($_POST["submit"])){
	    $name = $_POST["name"];
	    $comment = $_POST["comment"]; 
	    $pass=$_POST["pass"];
	    $dt = date("Y-m-d H:i:s"); 
    $sql = 'SELECT * FROM tbtest';
	$stmt = $pdo->query($sql);

	$results = $stmt->fetchAll();
	
	  foreach ($results as $row){
	      $id=$row['id'];
	      $Pass=$row['pass'];
		if($name!==''&&$comment!==''&&$_POST["Hname"]&&$_POST["Hcomment"]&&$id==$_POST["number"]&&$Pass==$_POST["pass"]){
		    $id = $_POST["number"]; //変更する投稿番号
	        $name = $_POST["name"];
	        $comment =$_POST["comment"]; //変更したい名前、変更したいコメントは自分で決めること
	        $sql = "UPDATE tbtest SET name=:name,comment=:comment,id=:id,dt=:dt,pass=:pass WHERE id=:id";
	        $stmt = $pdo->prepare($sql);
	        $stmt->bindParam(':name', $name, PDO::PARAM_STR);
	        $stmt->bindParam(':comment', $comment, PDO::PARAM_STR);
	        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
	        $stmt -> bindParam(':dt', $dt, PDO::PARAM_STR);
	        $stmt -> bindParam(':pass', $pass, PDO::PARAM_INT);
	        $stmt->execute();
		}
	  }
 }  
  	$sql = 'SELECT * FROM tbtest';
	$stmt = $pdo->query($sql);

	$results = $stmt->fetchAll();
	
	  foreach ($results as $row){
		echo $row['id'].',';
		echo $row['name'].',';
		echo $row['comment'].',';
		echo $row['pass'].',';
		echo $row['dt'].',';
	    echo "<hr>";
	  }
 ?>
</body>
</html>