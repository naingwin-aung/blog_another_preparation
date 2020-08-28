<?php
  require_once('auth.php');
?>

<?php include_once('header.php'); ?>
    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Blog Listings</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">

              <form action="store.php" method="POST" enctype="multipart/form-data">
                  <div class="form-group">
                    <label for="">Title</label>
                    <input type="text" class="form-control" name="title" required>
                  </div>

                  <div class="form-group">
                    <label for="">Content</label>
                    <textarea name="content" id="" cols="30" rows="10" class="form-control"></textarea>
                  </div>

                  <div class="form-group">
                    <label for="">Image</label>
                    <input type="file" name="image" required>
                  </div>

                  <div class="form-group">
                    <button class="btn btn-success">SUBMIT</button>
                    <a href="index.php" class="btn btn-warning">Back</a>
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