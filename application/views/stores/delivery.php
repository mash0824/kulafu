

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
  	<div class="col-xs-12 col-sm-12 col-md-6">
      <h1>
       	<?php echo $warehouse_data['name']?><br/>
       	<small><?php echo $warehouse_data['address']?></small>
      </h1>
      </div>
      
      <?php if(in_array('createProduct', $user_permission) || in_array('createWarehouse', $user_permission) || in_array('updateWarehouse', $user_permission)): ?>
      <div class="col-xs-12 col-sm-12 col-md-6 text-right">
            <?php if(in_array('createWarehouse', $user_permission)): ?><a href="<?php echo base_url('warehouse/create') ?>" class="btn btn-primary">Create New Warehouse</a><?php endif; ?>
            <?php if(in_array('createProduct', $user_permission)): ?><a href="<?php echo base_url('products/create') ?>" class="btn btn-primary">Create New Product</a><?php endif; ?>
            <?php if(in_array('updateWarehouse', $user_permission)): ?><a href="<?php echo base_url('warehouse/edit/'.$warehouse_data['id']) ?>" class="btn btn-warning">Edit Warehouse Details</a><?php endif; ?>
       </div>
          <?php endif; ?>
  </section>

  <!-- Main content -->
  <section class="content">
    <!-- Small boxes (Stat box) -->
    <div class="row">
      <div class="col-md-12 col-xs-12">
		<div class="pipe-separated-list-container">
			<ul>
				<li class="first"><a id="listOfProductsNav" href="/lists-of-products/<?php echo $warehouseNameLink."/".$warehouse_data['id']; ?>">List of Products</a></li>
				<li><a id="deliveriesNav" href="/deliveries/<?php echo $warehouseNameLink."/".$warehouse_data['id']; ?>">Deliveries</a></li>
				<li><a id="pickupsNav" href="/pickups/<?php echo $warehouseNameLink."/".$warehouse_data['id']; ?>">Pickups</a></li>
				<li><a id="transfersNav" href="/transfers/<?php echo $warehouseNameLink."/".$warehouse_data['id']; ?>">Transfers</a></li>
				<li><a id="withdrawalsNav" href="/withdrawals/<?php echo $warehouseNameLink."/".$warehouse_data['id']; ?>">Withdrawals</a></li>
			</ul>
			<div class="listbutons col-md-12 col-xs-12">
    			<div class="col-md-6 col-xs-12 text-left">
    				<input type="text" id="myInputTextField" placeholder="Search" />
    			</div>
    			<div class="col-md-6 col-xs-12 text-right">
    				<?php if(in_array('createDelivery', $user_permission)): ?>
                	<a href="<?php echo base_url('deliveries-create/'.$warehouseNameLink.'/'.$warehouse_data['id']) ?>" class="btn btn-primary">Create New Delivery</a>
                	<?php endif; ?>
                	<a href="#" id="download-csv" class="btn btn-warning">Download List</a>
           		</div>
    		</div>	
			
		</div>
		
		
        <div id="messages"></div>

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
          <!-- /.box-header -->
          <div class="box-body hdsearch">
          	<h4>Pending Deliveries</h4>
          	<div class="table-responsive">
          	<table id="customerTable" class="table table-bordered table-striped">
                <thead>
                <tr>
                  	<th>Date</th>
                    <th>Delivery ID</th>
                    <th>PO Number</th>
                    <th>Customer/Company</th>
                    <th>Total Sales</th>
                    <th>Status</th>
                    <?php if(in_array('updateDelivery', $user_permission) || in_array('viewDelivery', $user_permission) ): ?>
                      <th>Action</th>
                    <?php endif; ?>
                </tr>
                </thead>
                <tbody>
                  <?php if($delivery_data): ?>                  
                    <?php foreach ($delivery_data as $k => $v): ?>
                    <?php 
                        $status = $v['transaction_status'];
                        if($status == "pending") {
                            $status = "<span class='redlink'>".ucfirst($status)."</span>";
                        }
                        else {
                            $status = "<span class='greenlink'>Delivered</span>";
                        }
                    ?>
                      <tr>
                        <td><?php echo date("m-d-Y", strtotime($v['create_date'])) ?></td>
                        <td><?php echo $v['display_id']; ?></td>
                        <td><?php echo $v['po_number']; ?></td>
                        <td><?php echo $v['customer_name']; ?></td>
                        <td><?php echo number_format($v['sales_total'],2); ?></td>
                        <td><?php echo $status; ?></td>
                        <td>
                           <?php if(in_array('viewDelivery', $user_permission)): ?>
                          <a href="<?php echo base_url('deliveries-view/'.$warehouseNameLink.'/'.$v['id']."/".$warehouse_data['id']) ?>" class="">View Report</a>  
                          <?php endif; ?>&nbsp;
                        </td>
                      </tr>
                    <?php endforeach ?>
                  <?php endif; ?>
                </tbody>
              </table>
              </div>
              <div>&nbsp;</div>
              <h4>All Deliveries</h4>
              <div class="table-responsive">
              <table id="customerTable2" class="table table-bordered table-striped">
                <thead>
                <tr>
                  	<th>Date</th>
                    <th>Delivery ID</th>
                    <th>PO Number</th>
                    <th>Customer/Company</th>
                    <th>Total Sales</th>
                    <th>Status</th>
                    <?php if(in_array('updateDelivery', $user_permission)  || in_array('viewDelivery', $user_permission) ): ?>
                      <th>Action</th>
                    <?php endif; ?>
                </tr>
                </thead>
                <tbody>
                  <?php if($delivery_data): ?>                  
                    <?php foreach ($delivery_data as $k => $v): ?>
                    <?php 
                        $status = $v['transaction_status'];
                        if($status == "pending") {
                            $status = "<span class='redlink'>".ucfirst($status)."</span>";
                        }
                        else {
                            $status = "<span class='greenlink'>Delivered</span>";
                        }
                    ?>
                      <tr>
                        <td><?php echo date("m-d-Y", strtotime($v['create_date'])) ?></td>
                        <td><?php echo $v['display_id']; ?></td>
                        <td><?php echo $v['po_number']; ?></td>
                        <td><?php echo $v['customer_name']; ?></td>
                        <td><?php echo number_format($v['sales_total'],2); ?></td>
                        <td><?php echo $status; ?></td>
                        <td>
                           <?php if(in_array('viewDelivery', $user_permission)): ?>
                          <a href="<?php echo base_url('deliveries-view/'.$warehouseNameLink.'/'.$v['id']."/".$warehouse_data['id']) ?>" class="">View Report</a>  
                          <?php endif; ?>&nbsp;
                        </td>
                      </tr>
                    <?php endforeach ?>
                  <?php endif; ?>
                </tbody>
              </table>
              </div>
          </div>
          <!-- /.box-body -->
        </div>
        <!-- /.box -->
      </div>
      <!-- col-md-12 -->
    </div>
    <!-- /.row -->
    

  </section>
  <!-- /.content -->
</div>

<script type="text/javascript">
var manageTable;
var base_url = "<?php echo base_url(); ?>";

$(document).ready(function() {

	var table = $('#customerTable').DataTable({
	  	  dom: 'Bfrtip',
	        buttons: [
                {
                    extend: 'csv',
                    exportOptions: {
                        columns: [0,1,2,3,4,5]
                    },
                    footer: false
                   
                },
	        ],
	        "oSearch": {"sSearch": "Pending"}
	    });

	var table2 = $('#customerTable2').DataTable({
	  	  dom: 'Bfrtip',
	        buttons: [
	                  {
	                      extend: 'csv',
	                      exportOptions: {
	                          columns: [0,1,2,3,4,5]
	                      },
	                      footer: false
	                     
	                  },
	  	        ]
	    });
	$('#myInputTextField').keyup(function(){
		table.search($(this).val()).draw() ;
	})
  $("#warehouseMainNav").addClass('active');
  $("#deliveriesNav").addClass('active');
  $("#download-csv").on("click", function() {
	    table2.button( '.buttons-csv' ).trigger();
	});

});

</script>
