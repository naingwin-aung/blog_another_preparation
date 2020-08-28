<?php
  require_once('auth.php');

?>

<?php include_once('header.php'); ?>
    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <!-- /.card-header -->
              <div class="card-body">
                <form action="user_store.php" method="POST">
                    <div class="form-group">
                      <label for="">Name</label>
                      <input type="text" class="form-control" name="name" required>
                    </div>

                    <div class="form-group">
                      <label for="">Email</label>
                      <input type="email" class="form-control" name="email" required>
                    </div>

                    <div class="form-group">
                      <label for="">Password</label>
                      <input type="text" class="form-control" name="password" required>
                    </div>

                    <div class="form-group">
                      <label for="">Role</label><br>
                      <input type="checkbox" name="role">
                    </div>

                    <div class="form-group">
                      <button class="btn btn-success">SUBMIT</button>
                      <a href="user.php" class="btn btn-warning">Back</a>
                    </div>
                  </form>                
              </div>
              <!-- /.card-body -->
              
            </div>

          </div>
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>

  <?php include('footer.html'); ?>