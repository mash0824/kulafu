

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <?php if($brands_data): ?>
        	<?php echo $brands_data['name']; ?>
        <?php endif; ?>
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
      <div class="row">
        <div class="col-md-12 col-xs-12">
          
          <?php if($this->session->flashdata('success')): ?>
            <div class="alert alert-success alert-dismissible" role="alert">
              <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <?php echo $this->session->flashdata('success'); ?>
            </div>
          <?php elseif($this->session->flashdata('error')): ?>
            <div class="alert alert-error alert-dismissible" role="alert">
              <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <?php echo $this->session->flashdata('error'); ?>
            </div>
          <?php endif; ?>

		 <table class="table table-bordered table-condensed table-hovered">
                <tr>
                  <th class="thwidth">Brand ID</th>
                  <td><?php echo $brands_data['id']; ?></td>
                </tr>
                <tr>
                  <th  class="thwidth">Name</th>
                  <td><?php echo $brands_data['name']; ?></td>
                </tr>
              </table>
          
		  <a href="<?php echo base_url('settings/brandEdit/'.$brands_data['id']) ?>" class="btn btn-primary">Edit Brand</a>
		  <a href="<?php echo base_url('settings/brandDelete/'.$brands_data['id']) ?>" class="btn btn-danger">Delete Brand</a>
		  <a href="<?php echo base_url('settings/brands') ?>" class="btn btn-warning">Back</a>

        </div>
        <!-- col-md-12 -->
      </div>
      <!-- /.row -->
      

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <script type="text/javascript">
    $(document).ready(function() {
      $('#settingMainNav').addClass('active');
    });
  </script>  

