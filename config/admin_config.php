<?php
  require_once('DAL.php');
  class DB
  {
     private $pdo;
     public function __construct()
     {
         $this->pdo = DAL::getInstance()->getConn(); 
     }

     public function Admin_login()
     {
          if($_POST) {
               $email = $_POST['email'];
               $password = $_POST['password'];
             
               $stm = $this->pdo->prepare("
                 SELECT * FROM users WHERE email = :email
               ");
             
               $stm->bindValue(":email", $email);
             
               if($stm->execute()) {
                 $user = $stm->fetch(PDO::FETCH_ASSOC);
               }
             
               if($user) {
                 if($user['password'] == $password) {
                   $_SESSION['user_id'] = $user['id'];
                   $_SESSION['user_name'] = $user['name'];
                   $_SESSION['role'] = 1;
                   $_SESSION['logged_in'] = time();
             
                   header("Location: index.php");
                 }
               } else {
                 echo "<script>alert('Incorrect email & password')</script>";
               }
             }
     }

     public function Admin_index()
     {
      if(isset($_POST['search'])) {
        setcookie('search',$_POST['search'], time() + (86400 * 30), '/');
      } else {
        if(empty($_GET['pageno'])) {
          unset($_COOKIE['search']);
          setcookie('search', null, -1, '/');
        }
      }

       if(!empty($_GET['pageno'])) {
         $pageno = $_GET['pageno'];
       } else {
         $pageno = 1;
       }

       $numOfrecs = 3;
       $offset = ($pageno-1) * $numOfrecs;

       if(empty($_POST['search']) && empty($_COOKIE['search'])) {
        $stm = $this->pdo->prepare("
        SELECT * FROM posts ORDER BY id DESC
      ");

        $stm->execute();
        $rawResult = $stm->fetchAll(PDO::FETCH_ASSOC);

        $total_pages = ceil(count($rawResult) / $numOfrecs);
        
        $stm = $this->pdo->prepare("
          SELECT * FROM posts ORDER BY id DESC LIMIT $offset,$numOfrecs
      ");

        $stm->execute();
        $result = $stm->fetchAll(PDO::FETCH_ASSOC);

        return array('result'=> $result, 'total_pages'=>$total_pages, 'pageno'=>$pageno);
       } else {
         $searchKey = !empty($_POST['search']) ? $_POST['search'] : $_COOKIE['search'];
         $stm = $this->pdo->prepare("
          SELECT * FROM posts WHERE  title LIKE '%$searchKey%' ORDER BY id DESC
       ");

         $stm->execute();
         
         $rawResult = $stm->fetchAll(PDO::FETCH_ASSOC);
         $total_pages = ceil(count($rawResult) / $numOfrecs);
         
         $stm = $this->pdo->prepare("
         SELECT * FROM posts WHERE title LIKE '%$searchKey%' ORDER BY id DESC LIMIT $offset,$numOfrecs
       ");

         $stm->execute();
         $result = $stm->fetchAll(PDO::FETCH_ASSOC);

         return array('result'=> $result, 'total_pages'=>$total_pages, 'pageno'=>$pageno);
       }
       
     }

     public function Admin_store()
     {
       if($_POST) {
         $file = 'images/'.($_FILES['image']['name']);
         $imageType = pathinfo($file,PATHINFO_EXTENSION);
         if($imageType != 'png' && $imageType != 'jpg' && $imageType != 'jpeg'){
          echo "<script>alert('Image is jpg or png or jpeg!')</script>";
         } else {
          move_uploaded_file($_FILES['image']['tmp_name'],$file); 

           $stm = $this->pdo->prepare("
            INSERT INTO posts(title, content, image, author_id) VALUES
            (:title, :content, :image, :author_id);
           ");

           $stm->bindParam(":title", $_POST['title']);
           $stm->bindParam(":content", $_POST['content']);
           $stm->bindParam(":image", $_FILES['image']['name']);
           $stm->bindParam(":author_id",$_SESSION['user_id']);

           if($stm->execute()) {
             header('location: index.php');
           }
         }
       }
     }

     public function Admin_edit()
     {
       $stm = $this->pdo->prepare("
        SELECT * FROM posts WHERE id = :id;
       ");

       $stm->bindParam(":id", $_GET['id']);

       if($stm->execute()) {
         $result = $stm->fetch(PDO::FETCH_ASSOC);
         return $result;
       }
     }

     public function Admin_update()
     {
       if($_POST) {
         if($_FILES['image']['name'] != null) {
           $file = "images/".($_FILES['image']['name']);
           $imageType = pathinfo($file,PATHINFO_EXTENSION);

           if($imageType != 'png' && $imageType != 'jpg' && $imageType != 'jpeg') {
            echo "<script>alert('Image must be jpg or png or jpeg!')</script>";
           } else {
             move_uploaded_file($_FILES['image']['tmp_name'],$file);

             $stm = $this->pdo->prepare("
              UPDATE posts SET title=:title, content=:content, image=:image WHERE id =:id
             ");

             $stm->bindParam(":id", $_GET['id']);
             $stm->bindParam(":title", $_POST['title']);
             $stm->bindParam(":content", $_POST['content']);
             $stm->bindParam(":image", $_FILES['image']['name']);

             if($stm->execute()) {
               header("location: index.php");
             }
           }
         } else {
              $stm = $this->pdo->prepare("
              UPDATE posts SET title=:title, content=:content WHERE id = :id
            ");

            $stm->bindParam(":id", $_GET['id']);
            $stm->bindParam(":title", $_POST['title']);
            $stm->bindParam(":content", $_POST['content']);

            if($stm->execute()) {
              header("location: index.php");
            }
         }
       }
     }

     public function Admin_delete()
     {
       $stm = $this->pdo->prepare("
        DELETE FROM posts WHERE id =:id
       ");

       $stm->bindParam(":id", $_GET['id']);

       if($stm->execute()) {
         header("location: index.php");
       }
     }

     public function Admin_user() 
     {
        
      if(isset($_POST['search'])) {
        setcookie('search',$_POST['search'], time() + (86400 * 30), '/');
      } else {
        if(empty($_GET['pageno'])) {
          unset($_COOKIE['search']);
          setcookie('search', null, -1, '/');
        }
      }

       if(!empty($_GET['pageno'])) {
         $pageno = $_GET['pageno'];
       } else {
         $pageno = 1;
       }

       $numOfrecs = 2;
       $offset = ($pageno-1) * $numOfrecs;

       if(empty($_POST['search']) && empty($_COOKIE['search'])) {
        $stm = $this->pdo->prepare("
        SELECT * FROM users ORDER BY id DESC
      ");

        $stm->execute();
        $rawResult = $stm->fetchAll(PDO::FETCH_ASSOC);
        $total_pages = ceil(count($rawResult) / $numOfrecs);
        
        $stm = $this->pdo->prepare("
          SELECT * FROM users ORDER BY id DESC LIMIT $offset,$numOfrecs
      ");

        $stm->execute();
        $result = $stm->fetchAll(PDO::FETCH_ASSOC);

        return array('result'=> $result, 'total_pages'=>$total_pages, 'pageno'=>$pageno);
       } else {
         $searchKey = !empty($_POST['search']) ? $_POST['search'] : $_COOKIE['search'];
         $stm = $this->pdo->prepare("
          SELECT * FROM users WHERE  name LIKE '%$searchKey%' ORDER BY id DESC
       ");

         $stm->execute();
         $rawResult = $stm->fetchAll(PDO::FETCH_ASSOC);
         $total_pages = ceil(count($rawResult) / $numOfrecs);
         
         $stm = $this->pdo->prepare("
         SELECT * FROM users WHERE name LIKE '%$searchKey%' ORDER BY id DESC LIMIT $offset,$numOfrecs
       ");

         $stm->execute();
         $result = $stm->fetchAll(PDO::FETCH_ASSOC);

         return array('result'=> $result, 'total_pages'=>$total_pages, 'pageno'=>$pageno);
       } 
     }

     public function Admin_user_store()
     {
       if($_POST) {
         if(empty($_POST['role'])) {
           $role = 0;
         } else {
           $role = 1;
         }

         $stm = $this->pdo->prepare("
          SELECT * FROM users WHERE email = :email
         ");

         $stm->bindParam(":email", $_POST['email']);

         $stm->execute();
         $user = $stm->fetch(PDO::FETCH_ASSOC);

         if($user) {
           echo "<script>alert('Email is duplicated!');</script>";
         } else {
           $stm = $this->pdo->prepare("
            INSERT INTO users (name, password, email, role) VALUES 
            (:name, :password, :email, :role)
           ");

           $stm->bindParam(":name", $_POST['name']);
           $stm->bindParam(":password", $_POST['password']);
           $stm->bindParam(":email", $_POST['email']);
           $stm->bindParam(":role", $role);

           if($stm->execute()) {
            echo "<script>alert('Successfully added');window.location.href='user.php';</script>";
           }
         }
       }
     }

     public function Admin_user_edit() 
     {
       $stm = $this->pdo->prepare("
        SELECT * FROM users WHERE id = :id
       ");

       $stm->bindParam(":id", $_GET['id']);

       if($stm->execute()) {
         $result = $stm->fetch(PDO::FETCH_ASSOC);
         return $result;
       }
     }
     
     public function Admin_user_update() 
     {
       if($_POST) {
         if(empty($_POST['role'])) {
           $role = 0;
         } else {
           $role = 1;
         }

         $stm = $this->pdo->prepare("
          SELECT * FROM users WHERE email = :email AND id != :id
         ");

         $stm->bindParam(":email", $_POST['email']);
         $stm->bindParam(":id", $_GET['id']);

         $stm->execute();

         $user = $stm->fetch(PDO::FETCH_ASSOC);

         if($user) {
          echo "<script>alert('Email is duplicated!');</script>";
         } else {
           $stm = $this->pdo->prepare("
            UPDATE users SET name=:name, email=:email, password= :password, role=:role WHERE id= :id
           ");

           $stm->bindParam(":name", $_POST['name']);
           $stm->bindParam(":email", $_POST['email']);
           $stm->bindParam(":password", $_POST['password']);
           $stm->bindParam(":role", $role);
           $stm->bindParam(":id", $_GET['id']);

           if($stm->execute()) {
             header("location: user.php");
           }
         }
       }
     }

     public function Admin_user_delete()
     {
       $stm = $this->pdo->prepare("
        DELETE FROM users WHERE id = :id
       ");

       $stm->bindParam(":id", $_GET['id']);

       if($stm->execute()) {
         header("location: user.php");
       }
     }
  }