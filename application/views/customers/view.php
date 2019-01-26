

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <?php if($customers_data): ?>
        	<?php echo $customers_data['customer_name']; ?>
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
                  <th class="thwidth">Customer ID</th>
                  <td><?php echo $customers_data['cs_id']; ?></td>
                </tr>
                <tr>
                  <th  class="thwidth">Delivery Address</th>
                  <td><?php echo $customers_data['address']; ?></td>
                </tr>
                <tr>
                  <th  class="thwidth">Contact Person</th>
                  <td><?php echo $customers_data['contact_person']; ?></td>
                </tr>
                <tr>
                  <th  class="thwidth">Email Address</th>
                  <td><?php echo $customers_data['email']; ?></td>
                </tr>
              </table>
          
		  <a href="<?php echo base_url('customers/edit/'.$customers_data['id']) ?>" class="btn btn-primary">Edit Customer</a>
		  <a href="<?php echo base_url('customers/delete/'.$customers_data['id']) ?>" class="btn btn-danger">Delete Customer</a>
		  <a href="<?php echo base_url('customers') ?>" class="btn btn-warning">Back</a>

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
      $('#customerMainNav').addClass('active');
    });
  </script>  

