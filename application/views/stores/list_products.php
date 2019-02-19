

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
    				<?php if(in_array('createProduct', $user_permission) && in_array('createWarehouse', $user_permission)): ?>
                	<a href="<?php echo base_url('warehouse-stocks-create/'.$warehouse_data['id']) ?>" class="btn btn-primary">Add Stocks</a>
                	<?php endif; ?>
                	<a href="#" id="download-csv" class="btn btn-warning">Download CSV</a>
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
          	<div class="table-responsive">
              	<table id="customerTable" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                      	<th>Supplier SKU</th>
                        <th>Product Name</th>
                        <th>Brand</th>
                        <th>In Stock</th>
                        <th>Unit</th>
                        <th>Sale Price</th>
                        <th>Cost</th>
                        <?php if(in_array('updateProduct', $user_permission) || in_array('deleteProduct', $user_permission)): ?>
                          <th>Action</th>
                        <?php endif; ?>
                    </tr>
                    </thead>
                    <tbody>
                      <?php if($products): ?>                  
                        <?php foreach ($products as $k => $v): ?>
                          <tr>
                            <td><?php echo $v['sku']; ?></td>
                            <td><?php echo $v['name']; ?></td>
                            <td><?php echo $v['brand_name']; ?></td>
                            <td><?php echo (($v['stock_count'] - $v['less_stock']) > 0 ? $v['stock_count'] - $v['less_stock'] : 0); ?></td>
                            <td><?php echo $v['unit_name']; ?></td>
    						<td><?php echo $v['sale_price']; ?></td>
    						<td><?php echo $v['cost']; ?></td>
                            <td>
                               <?php if(in_array('viewProduct', $user_permission)): ?>
                              <a href="<?php echo base_url('warehouse-product-view/'.$warehouseNameLink.'/'.$v['product_id']."/".$warehouse_data['id']) ?>" class="">View</a>  
                              <?php endif; ?>&nbsp;
                              <?php if(in_array('deleteProduct', $user_permission)): ?>
                              <a href="#" onclick="removeFuncWarehouse(<?php echo $v['product_id'];?>,<?php echo $warehouse_data['id'];?>);" data-toggle="modal" data-target="#removeModal" class="redlink">Remove</a>
                              <?php endif; ?>
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
<?php if(in_array('deleteProduct', $user_permission)): ?>
<!-- remove brand modal -->
<div class="modal fade" tabindex="-1" role="dialog" id="removeModal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Remove Product From Warehouse</h4>
      </div>

      <form role="form" action="<?php echo base_url('products/removeProductStore/') ?>" method="get" id="removeForm">
        <div class="modal-body">
          <p>Do you really want to remove?</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Save changes</button>
        </div>
      </form>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<?php endif; ?>


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
                        columns: [0,1,2,3,4,5,6]
                    },
                    footer: false
                   
                },
	 
	        ]
	    });
	$('#myInputTextField').keyup(function(){
		table.search($(this).val()).draw() ;
	})
  $("#warehouseMainNav").addClass('active');
  $("#listOfProductsNav").addClass('active');
  $("#download-csv").on("click", function() {
	    table.button( '.buttons-csv' ).trigger();
	});

});

//remove functions 
function removeFuncWarehouse(id,storeid)
{
	if(id && storeid) {
	    $("#removeForm").on('submit', function() {
	      var form = $(this);
	      // remove the text-danger
	      $(".text-danger").remove();
	      $.ajax({
		        url: '/products/removeProductStore/'+id+'/'+storeid,
		        type: 'get',
		        dataType: 'json',
		        success:function(response) {
		          if(response.success === true) {
		            $("#messages").html('<div class="alert alert-success alert-dismissible" role="alert">'+
		              '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
		              '<strong> <span class="glyphicon glyphicon-ok-sign"></span> </strong>'+response.messages+
		            '</div>');
		            // hide the modal
		            $("#removeModal").modal('hide');
		            var delay = 1000; 
		            setTimeout(function(){ window.location = '/lists-of-products/<?php echo $warehouseNameLink;?>/<?php echo $warehouseId;?>'; }, delay);
		            
		          } else {
		            $("#messages").html('<div class="alert alert-warning alert-dismissible" role="alert">'+
		              '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
		              '<strong> <span class="glyphicon glyphicon-exclamation-sign"></span> </strong>'+response.messages+
		            '</div>'); 
		          }
		        }
		      }); 
	      return false;
	    });
	  }
}
</script>
