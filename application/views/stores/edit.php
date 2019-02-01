

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Edit <?php echo $warehouses_data['name'] ?>
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

          <div class="box">
            <form role="form" action="<?php base_url('warehouse/edit') ?>" method="post">
              <div class="box-body">
                <?php if(!empty(validation_errors())) { ?>
				<div class="alert alert-error alert-dismissible" role="alert">
              		<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                	<?php echo validation_errors(); ?>
                	</div>
				<?php } ?>
                <div class="form-group">
                  <label for="cs_id">Warehouse ID</label>
                  <input type="text" class="form-control" id="warehouse_disp_id" name="warehouse_disp_id" placeholder="Warehouse ID" value="<?php echo $warehouses_data['warehouse_disp_id'] ?>" disabled autocomplete="off">
                </div>
                
                <div class="form-group">
                  <label for="customer_name">Warehouse</label>
                  <input type="text" class="form-control" id="name" name="name" placeholder="Warehouse Name" value="<?php echo $warehouses_data['name'] ?>" autocomplete="off">
                </div>
                
                <div class="form-group">
                  <label for="address">Address</label>
                  <textarea type="text" class="form-control" id="address" name="address" placeholder="Enter Warehouse Address" autocomplete="off"><?php echo $warehouses_data['address'] ?></textarea>
                </div>
              </div>
              <!-- /.box-body -->
              <div class="box-footer">
                <button type="submit" class="btn btn-primary">Update Warehouse</button>
                <a href="<?php echo base_url('warehouses/') ?>" class="btn btn-warning">Back</a>
              </div>
            </form>
          </div>
          <!-- /.box -->
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

    $("#warehouseMainNav").addClass('active');
  });
</script>
