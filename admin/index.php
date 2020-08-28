<?php
  require_once('auth.php');
  $i = 1;
  $db = new DB();
  $array = $db->Admin_index();
  $result = $array['result'];
  $total_pages = $array['total_pages'];
  $pageno = $array['pageno'];

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
                <a href="add.php" type="button" class="btn btn-success mb-4">New Blog Posts</a>
                <table class="table table-bordered">
                  <thead>                  
                    <tr>
                      <th style="width: 10px">#</th>
                      <th>Title</th>
                      <th>Content</th>
                      <th style="width: 160px;">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php if($result): ?>
                        <?php foreach($result as $results): ?>
                          <tr>
                            <td><?php echo $i; ?></td>
                            <td><?php echo $results['title']; ?></td>
                            <td>
                              <?php echo substr($results['content'],0,50); ?>
                            </td>
                              <td>
                                <a href="edit.php?id=<?php echo $results['id']; ?>" class="btn btn-warning">Edit</a>
                                <a href="delete.php?id=<?php echo $results['id']; ?>" onclick="return confirm('Are you sure you want to delete this item')" class="btn btn-danger">Delete</a>
                              </td>
                          </tr>
                          <?php $i++; ?>        
                        <?php endforeach; ?>
                    <?php endif;?>                 
                  </tbody>
                </table>

                <div class="float-right mt-4">
                  <nav aria-label="Page navigation example">
                      <ul class="pagination">
                        <li class="page-item"><a class="page-link" href="?pageno=1">First</a></li>
                        <li class="page-item <?php if($pageno <= 1) {echo 'disabled';} ?>">
                          <a class="page-link" href="<?php if($pageno <= 1) {echo '#';} else{ echo "?pageno=".($pageno-1);} ?>">Previous</a>
                        </li>
                        <li class="page-item"><a class="page-link" href="#"><?php echo $pageno; ?></a></li>
                        <li class="page-item <?php if($pageno >= $total_pages) {echo 'disabled';} ?>">
                          <a class="page-link" href="<?php if($pageno >= $total_pages) {echo '#';} else{ echo "?pageno=".($pageno+1);} ?>">Next</a>
                        </li>
                        <li class="page-item"><a class="page-link" href="?pageno=<?php echo $total_pages?>">Last</a></li>
                      </ul>
                  </nav>
                </div>
                
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