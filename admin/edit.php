<?php
  require_once('auth.php');
  $db = new DB();
  $result = $db->Admin_edit();
  
?>

<?php include_once('header.php'); ?>
    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-body">
                <form action="update.php?id=<?php echo $result['id']; ?>" method="POST" enctype="multipart/form-data">
                  <div class="form-group">
                    
                    <label for="">Title</label>
                    <input type="text" class="form-control" name="title" value="<?php echo $result['title'];?>" required>
                  </div>

                  <div class="form-group">
                    <label for="">Content</label>
                    <textarea name="content" id="" cols="30" rows="10" class="form-control"><?php echo $result['content']; ?></textarea>
                  </div>

                  <div class="form-group">
                    <label for="">Image</label>
                    <img src="images/<?php echo $result['image']; ?>" width="150" height="150" alt=""><br><br>
                    <input type="file" name="image">
                  </div>

                  <div class="form-group">
                    <button class="btn btn-success">SUBMIT</button>
                    <a href="index.php" class="btn btn-warning">Back</a>
                  </div>
                </form>
              </div>  
            </div>

          </div>
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>

  <?php include('footer.html'); ?>