<?php
  require_once('DAL.php');

  class DB 
  {
    private $pdo;
    public function __construct()
    {
      $this->pdo = DAL::getInstance()->getConn();
    }

    public function User_login()
    {
      if($_POST) {
        $stm = $this->pdo->prepare("
          SELECT * FROM users WHERE email = :email;
        ");
        $stm->bindParam(":email", $_POST['email']);

        if($stm->execute()) {
          $user = $stm->fetch(PDO::FETCH_ASSOC);
        }

        if($user) {
          $_SESSION['user_id'] = $user['id'];
          $_SESSION['user_name'] = $user['name'];
          $_SESSION['role'] = 0;
          $_SESSION['logged_in'] = time();

          header("location: index.php");
        } else {
          echo "<script>alert('Incorrect email & password')</script>"; 
        }
      }
    }

    public function User_register()
    {
      if($_POST) {
        $stm = $this->pdo->prepare("
          SELECT * FROM users WHERE email = :email
        ");

        $stm->bindParam(":email", $_POST['email']);

        if($stm->execute()) {
          $user = $stm->fetch(PDO::FETCH_ASSOC);
        }

        if($user) {
          echo "<script>alert('Email duplicated')</script>";
        } else {
          $stm = $this->pdo->prepare("
            INSERT INTO users (name, password, email, role) VALUES
            (:name, :password, :email, :role)
          ");

          $stm->bindParam(":name", $_POST['name']);
          $stm->bindParam(":password", $_POST['password']);
          $stm->bindParam(":email", $_POST['email']);
          $stm->bindParam(":role", 0);

          if($stm->execute()) {
            echo "<script>alert('Successfully register;You can login now');window.location.href='login.php';</script>";
         }
        }
      }
    }

    public function User_index()
    {
      if(!empty($_GET['pageno'])) {
        $pageno = $_GET['pageno'];
      } else {
        $pageno = 1;
      }
      $numOfrecs = 6;
      $offset = ($pageno -1 ) * $numOfrecs;

      $stm = $this->pdo->prepare("
        SELECT * FROM posts ORDER BY id DESC
        ");

        if($stm->execute()) {
            $rawResult = $stm->fetchAll();
        }

        $total_pages = ceil(count($rawResult)/ $numOfrecs);

          $stm = $this->pdo->prepare("
            SELECT * FROM posts ORDER BY id DESC LIMIT $offset,$numOfrecs
          ");

          if($stm->execute()) {
            $result = $stm->fetchAll();
            return array('result'=> $result, 'total_pages'=>$total_pages, 'pageno'=>$pageno);
          }
    }

    public function User_blogdetail()
    {
      $stmt = $this->pdo->prepare("SELECT * FROM posts WHERE id=" .$_GET['id']);
      $stmt->execute();
      $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
      $blogId = $_GET['id'];
    
      $stmtcmt = $this->pdo->prepare("SELECT * FROM comments WHERE post_id=$blogId");
      $stmtcmt->execute();
      $resultcmt = $stmtcmt->fetchAll(PDO::FETCH_ASSOC);
    
      $resultau = [];
      if($resultcmt) {
        foreach($resultcmt as $key => $value) {
          $authorId = $resultcmt[$key]['author_id'];
          $stmtau = $this->pdo->prepare("SELECT * FROM users WHERE id=$authorId");
          $stmtau->execute();
          $resultau[] = $stmtau->fetch(PDO::FETCH_ASSOC);
        }
      }
    
      if($_POST) {
        $comment = $_POST['comment'];
    
           $stm = $this->pdo->prepare("
              INSERT INTO comments (context, author_id, post_id) VALUES
              (:context, :author_id, :post_id)
           ");
     
           $result = $stm->execute(
             array(':context'=>$comment,':author_id'=>$_SESSION['user_id'],':post_id'=>$blogId)
           );
           if($result) {
             header("Location: blogdetail.php?id=".$blogId);
           }
        }
        return array('result'=>$result, 'resultcmt'=>$resultcmt, 'resultau'=> $resultau);
    }
  }