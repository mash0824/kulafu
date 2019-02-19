

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Withdrawal Summary
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
                  <th class="thwidth">Date</th>
                  <td><?php echo $warehouse_data['order_date'];?></td>
                </tr>
                <tr>
                  <th  class="thwidth">Withdrawal ID</th>
                  <td><?php echo $warehouse_data['display_id']; ?></td>
                </tr>
                <tr>
                  <th  class="thwidth">Source Location</th>
                  <td><?php echo $warehouse_data['destination_location']; ?></td>
                </tr>
                <tr>
                  <th  class="thwidth">Reason for Withdrawal</th>
                  <td><?php echo $warehouse_data['notes']; ?></td>
                </tr>
              </table>
              
              <div class="row">
                <div class="col-md-12 col-xs-12">
                	
                	<div class="box">
                    <!-- /.box-header -->
                    <div class="box-body hdsearch">
                      <table id="customerTable" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                          <th>Product Name</th>
                          <th>Order Quantity</th>
                          <th>Unit</th>
                        </tr>
                        </thead>
                        <tbody>
                          <?php if($products): ?>                  
                            <?php foreach ($products as $k => $v): ?>
                              <tr>
                                <td><?php echo $v['product_name']; ?></td>
                                <td><?php echo $v['quantity']; ?></td>
                                <td><?php echo $v['unit_name']; ?></td>
                              </tr>
                            <?php endforeach ?>
                          <?php endif; ?>
                        </tbody>
                      </table>
                      <div>
                      <br/>
                      <input type="checkbox" id="checkme" name="checkme" value="1" <?php if($warehouse_data['transaction_status'] == "withdrew"): echo "checked"; endif;?> /> <label for="checkme">Mark as withdrew</label> <br/>
                      <?php if($warehouse_data['transaction_status'] != "withdrew"): ?>
                      <?php if(in_array('updateWithdrawal', $user_permission)): ?>
                      <a href="javascript:void(0);" onclick="confirmOrder('<?php echo $warehouseId;?>','<?php echo $tid;?>');"  class="btn btn-primary">Confirm Withdrawal Order</a>
                      <?php endif;?>
                      <?php else: ?> 
                      <a href="javascript:void(0);" onclick="myFunction();" class="btn btn-primary">Download Withdrawal Order</a>
                      <?php endif;?>
                      <?php if(in_array('updateWithdrawal', $user_permission) || in_array('viewWithdrawal', $user_permission)): ?>
                      <a href="<?php echo base_url('/withdrawals-edit/'.$warehouseNameLink.'/'.$warehouseId.'/'.$tid) ?>" class="btn btn-warning">Edit Withdrawal Order</a>
                      <?php endif;?>
                      <a href="<?php echo base_url('/withdrawals/'.$warehouseNameLink.'/'.$warehouseId) ?>" class="btn btn-warning">Back</a>
                      
                      </div>
                    </div>
                    <!-- /.box-body -->
                  </div>
                </div>
              </div>
        </div>
        <!-- col-md-12 -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
<!-- /.content-wrapper -->
<?php if(in_array('updateWarehouse', $user_permission)): ?>
<!-- remove brand modal -->
<div class="modal fade" tabindex="-1" role="dialog" id="removeModal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Confirm Withdrawal</h4>
      </div>

      <form role="form" action="<?php echo base_url('withdrawals-confirm/'.$warehouseId.'/'.$tid) ?>" method="get" id="confirmForm">
        <div class="modal-body">
          <p>Do you really want to confirm withdrawal?</p>
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
      $('#warehouseMainNav').addClass('active');
      var numFormat = $.fn.dataTable.render.number( '\,', '.', 2, 'Php' ).display;
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
                  .column( 3 )
                  .data()
                  .reduce( function (a, b) {
                      return intVal(a) + intVal(b);
                  }, 0 );
   
              // Total over this page
              pageTotal = api
                  .column( 3, { page: 'current'} )
                  .data()
                  .reduce( function (a, b) {
                      return intVal(a) + intVal(b);
                  }, 0 );
   
              // Update footer
              $( api.column( 3 ).footer() ).html(
            		  numFormat(pageTotal)
              );
			}
      });
      
    });

    function confirmOrder(storeid,tid){
        if(!$('#checkme').prop('checked')){
        	$("#messages").html('<div class="alert alert-warning alert-dismissible" role="alert">'+
                    '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
                    '<strong> <span class="glyphicon glyphicon-exclamation-sign"></span> </strong>Please check the box to confirm.</div>');
        	$('#checkme').focus(); 
        	return false;
        }
        $('#removeModal').modal('toggle');
        if(storeid && tid) {
            $("#confirmForm").on('submit', function() {
              var form = $(this);
              // remove the text-danger
              $(".text-danger").remove();
              $.ajax({
                url: form.attr('action'),
                type: form.attr('method'),
                dataType: 'json',
                success:function(response) {
            
                  if(response.success === true) {
                    $("#messages").html('<div class="alert alert-success alert-dismissible" role="alert">'+
                      '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
                      '<strong> <span class="glyphicon glyphicon-ok-sign"></span> </strong>'+response.messages+
                    '</div>');
                    // hide the modal
                    $("#removeModal").modal('hide');
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
    function myFunction() {
  	  window.print();
  	}
  </script>  

