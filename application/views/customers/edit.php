

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Edit <?php echo $customers_data['customer_name'] ?>
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
            <form role="form" action="<?php base_url('customers/edit') ?>" method="post">
              <div class="box-body">
                <?php if(!empty(validation_errors())) { ?>
				<div class="alert alert-error alert-dismissible" role="alert">
              		<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                	<?php echo validation_errors(); ?>
                	</div>
				<?php } ?>
                <div class="form-group">
                  <label for="cs_id">Customer ID</label>
                  <input type="text" class="form-control" id="cs_id" name="cs_id" placeholder="Customer ID" value="<?php echo $customers_data['cs_id'] ?>" disabled autocomplete="off">
                </div>
                
                <div class="form-group">
                  <label for="customer_name">Customer Name</label>
                  <input type="text" class="form-control" id="customer_name" name="customer_name" placeholder="Customer Name" value="<?php echo $customers_data['customer_name'] ?>" autocomplete="off">
                </div>
                
                <div class="form-group">
                  <label for="address">Delivery Address</label>
                  <textarea type="text" class="form-control" id="address" name="address" placeholder="Enter Company Address" autocomplete="off"><?php echo $customers_data['address'] ?>
                  </textarea>
                </div>
				<div class="form-group">
                  <label for="contact_person">Contact Person</label>
                  <input type="text" class="form-control" id="contact_person" name="contact_person" placeholder="Contact Person" value="<?php echo $customers_data['contact_person'] ?>" autocomplete="off">
                </div>
                <div class="form-group">
                  <label for="email">Email</label>
                  <input type="email" class="form-control" id="email" name="email" placeholder="Email" value="<?php echo $customers_data['email'] ?>" autocomplete="off">
                </div>                
              </div>
              <!-- /.box-body -->
              <div class="box-footer">
                <button type="submit" class="btn btn-primary">Update Customer</button>
                <a href="<?php echo base_url('customers/') ?>" class="btn btn-warning">Back</a>
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

    $("#customerMainNav").addClass('active');
  });
</script>
