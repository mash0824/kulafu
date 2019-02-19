

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <?php if($product_data): ?>
        	<?php echo $product_data['name']; ?>
        <?php endif; ?>
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
      <div class="row">
        <div class="col-md-12 col-xs-12">
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

		 <table class="table table-bordered table-condensed table-hovered">
                <tr>
                  <th class="thwidth">Product ID</th>
                  <td><?php echo $product_data['pd_disp_id']; ?></td>
                </tr>
                <tr>
                  <th  class="thwidth">Supplier SKU</th>
                  <td><?php echo $product_data['sku']; ?></td>
                </tr>
                <tr>
                  <th  class="thwidth">Brand</th>
                  <td><?php echo $product_data['brand_id']; ?></td>
                </tr>
                <tr>
                  <th  class="thwidth">Unit of Measure</th>
                  <td><?php echo $product_data['unit_id']; ?></td>
                </tr>
                <tr>
                  <th  class="thwidth">Maximum Quantity</th>
                  <td><?php echo $product_data['max_quantity']; ?></td>
                </tr>
                <tr>
                  <th  class="thwidth">Quantity inside 1 box</th>
                  <td><?php echo $product_data['quantity_in_box']; ?></td>
                </tr>
                <tr>
                  <th  class="thwidth">Cost</th>
                  <td><?php echo $product_data['cost']; ?></td>
                </tr>
                <tr>
                  <th  class="thwidth">Sale Price</th>
                  <td><?php echo $product_data['sale_price']; ?></td>
                </tr>
              </table>
          <?php if(in_array('updateProduct', $user_permission)): ?>
		  <a href="<?php echo base_url('products/update/'.$product_data['id']) ?>" class="btn btn-primary">Edit Product</a>
		  <?php endif; ?>
		  <?php if(in_array('deleteProduct', $user_permission)): ?>
		  <a href="#" class="btn btn-danger" onclick="removeFunc('<?php echo $product_data['id'];?>')" data-toggle="modal" data-target="#removeModal">Delete Product</a>
		  <?php endif; ?>	
        </div>
        <!-- col-md-12 -->
      </div>
      <!-- /.row -->
      

    </section>
    <section class="content-header">
    	<div class="col-xs-12 col-sm-12 col-md-6">
      <h1>
        Stock History
      </h1>
      </div>
      <?php /*if(in_array('createProduct', $user_permission)): ?>
      <div class="col-xs-12 col-sm-12 col-md-6 text-right">
            <a href="<?php echo base_url('/stocks-create') ?>" class="btn btn-primary">Add Stocks</a>
       </div>
          <?php endif; */?>
    </section>
    <!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
      <div class="row">
        <div class="col-md-12 col-xs-12">
        	
        	<div class="box">
            <!-- /.box-header -->
            <div class="box-body">
              <table id="customerTable" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Location</th>
                  <th>Quantity</th>
                  <th>Unit</th>
                  <th>Expiry Date</th>
                  <th>Status</th>
                  <?php if(in_array('updateProduct', $user_permission) || in_array('viewProduct', $user_permission)): ?>
                    <th>Action</th>
                  <?php endif; ?>
                </tr>
                </thead>
                <tfoot>
            		<tr>
            			<td>Total</td>
            			<td></td>
            			<td><?php if($stock_data): echo $stock_data[0]['unit_name']; endif;?></td>
            			<td></td>
            			<td></td>
            			<td></td>
            		</tr>
            	</tfoot>
                <tbody>
                  <?php if($stock_data): ?>                  
                    <?php foreach ($stock_data as $k => $v): ?>
                      <tr>
                        <td><?php echo $v['store_name']; ?></td>
                        <td><?php echo $v['quantity']; ?></td>
                        <td><?php echo $v['unit_name']; ?></td>
                        <td><?php if($v['expiry_date'] == "1970-01-01"){echo "";} else {echo $v['expiry_date'];} ?></td>
                        <td><?php if($v['transaction_id'] > 0) {echo "<span class='normal'>Transferred</span>";} else { echo $v['stock_status'];} ?></td>
                        <td>
                           <?php if(in_array('updateProduct', $user_permission) && $v['stock_status_flag'] == 1): ?>
                          <a href="<?php echo base_url('withdrawals-create/manage/'.$v['store_id']) ?>" class="">Withdraw</a>  
                          <?php endif; ?>
                        </td>
                      </tr>
                    <?php endforeach ?>
                  <?php endif; ?>
                </tbody>
              </table>
              <div>
              <br/>
              <a href="<?php echo base_url('products') ?>" class="btn btn-warning">Back</a>
              </div>
            </div>
            <!-- /.box-body -->
          </div>
        	
        	
        </div>
      </div>
      </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
<!-- /.content-wrapper -->
<?php if(in_array('deleteProduct', $user_permission)): ?>
<!-- remove brand modal -->
<div class="modal fade" tabindex="-1" role="dialog" id="removeModal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Remove Product</h4>
      </div>

      <form role="form" action="<?php echo base_url('products/remove') ?>" method="post" id="removeForm">
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
      $('#productMainNav').addClass('active');

      $('#customerTable').DataTable({
    	  dom: 'Bfrtip',
    	  "footerCallback": function ( row, data, start, end, display ) {
    		  var api = this.api(), data;
    		  
              // Remove the formatting to get integer data for summation
              var intVal = function ( i ) {
                  return typeof i === 'string' ?
                      i.replace(/[\$,]/g, '')*1 :
                      typeof i === 'number' ?
                          i : 0;
              };
   
              // Total over all pages
              total = api
                  .column( 1 )
                  .data()
                  .reduce( function (a, b) {
                      return intVal(a) + intVal(b);
                  }, 0 );
   
              // Total over this page
              pageTotal = api
                  .column( 1, { page: 'current'} )
                  .data()
                  .reduce( function (a, b) {
                      return intVal(a) + intVal(b);
                  }, 0 );
   
              // Update footer
              $( api.column( 1 ).footer() ).html(
                  pageTotal
              );
			}
      });
      
    });


    // remove functions 
    function removeFunc(id)
    {
      if(id) {
        $("#removeForm").on('submit', function() {

          var form = $(this);

          // remove the text-danger
          $(".text-danger").remove();

          $.ajax({
            url: form.attr('action'),
            type: form.attr('method'),
            data: { product_id:id }, 
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
                setTimeout(function(){ window.location = '/products/'; }, delay);
                
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

