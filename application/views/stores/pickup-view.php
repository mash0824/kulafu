

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Pickup Summary
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
            <?php elseif($this->session->flashdata('confirm')): ?>
           <div id="confirm-disp" class="alert alert-success alert-dismissible" role="alert">
              <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <?php echo $this->session->flashdata('confirm'); ?>
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
                  <th  class="thwidth">Pickup ID</th>
                  <td><?php echo $warehouse_data['display_id']; ?></td>
                </tr>
                <tr>
                  <th  class="thwidth">PO NUMBER</th>
                  <td><?php echo $warehouse_data['po_number']; ?></td>
                </tr>
                <tr>
                  <th  class="thwidth">Customer Name</th>
                  <td><?php echo $warehouse_data['customer_name']; ?></td>
                </tr>
                <tr>
                  <th  class="thwidth">Additional Notes</th>
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
                          <th>Sales Amount</th>
                        </tr>
                        </thead>
                        <tfoot>
                    		<tr>
                    			<td></td>
                    			<td></td>
                    			<td>Total Sales</td>
                    			<td></td>
                    		</tr>
                    	</tfoot>
                        <tbody>
                          <?php if($products): ?>                  
                            <?php foreach ($products as $k => $v): ?>
                              <tr>
                                <td><?php echo $v['product_name']; ?></td>
                                <td><?php echo $v['quantity']; ?></td>
                                <td><?php echo $v['unit_name']; ?></td>
                                <td><?php echo number_format($v['sale_amount'],2); ?></td>
                              </tr>
                            <?php endforeach ?>
                          <?php endif; ?>
                        </tbody>
                      </table>
                      <div>
                      <br/>
                      <input type="checkbox" id="checkme" name="checkme" value="1" <?php if(!in_array('updatePickup', $user_permission)): ?> disabled <?php endif;?>  <?php if($warehouse_data['transaction_status'] == "delivered"): echo "checked"; endif;?> /> <label for="checkme">Mark as picked up</label> <br/>
                      
                      <a id="confirm-download-link" href="javascript:void(0);" onclick="myFunction();" class="btn btn-primary">Download Pickup Order</a>
                      <?php if(in_array('updatePickup', $user_permission)): ?>
                      <a href="<?php echo base_url('/pickups-edit/'.$warehouseNameLink.'/'.$warehouseId.'/'.$tid) ?>" class="btn btn-warning">Edit Pickup Order</a>
                      <?php endif;?>
                      <a href="<?php echo base_url('/pickups/'.$warehouseNameLink.'/'.$warehouseId) ?>" class="btn btn-warning">Back</a>
                      
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
        <h4 class="modal-title">Confirm Order</h4>
        
      </div>

      <form role="form" action="<?php echo base_url('pickups-confirm/'.$warehouseId.'/'.$tid) ?>" method="get" id="confirmForm">
        <div class="modal-body">
          <p>Do you really want to confirm order?</p>
          <input type="hidden" id="tvalue" name="tvalue" value="" class="form-control"/>
        </div>
        <div class="modal-footer">
          <button type="button"  id="closeModal" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Save changes</button>
        </div>
      </form>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<?php endif; ?>
  <script type="text/javascript">
  var warehouseID = <?php echo $warehouseId; ?>;
  var tid = <?php echo $tid; ?>;
  var tvalue = <?php if($warehouse_data['transaction_status'] == "delivered"){ echo "'checked';\n";} else {echo "'pending';\n"; }?>
  var manageTable;
  var base_url = "<?php echo base_url(); ?>";
    $(document).ready(function() {
    	$('#checkme').click(function(e) {
            var checkstatus = 'pending';
      	  if(!$('#checkme').prop('checked')){
      		  tvalue = 'pending';
      	  }
      	  else {
      		  tvalue = 'checked';
      	  }
      	  $('#tvalue').val(tvalue);
      	  confirmOrder(warehouseID,tid);
        } ); 
        $("#closeModal").click(function(e) {
      	  if(!$('#checkme').prop('checked')){
      		  tvalue = 'checked';
      		  $( "#checkme" ).prop( "checked", true );
      	  }
      	  else {
      		  tvalue = 'pending';
      		  $( "#checkme" ).prop( "checked", false );
      	  }
      	  $('#tvalue').val(tvalue);
        });
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
        $('#removeModal').modal('toggle');
        if(storeid && tid) {
            $("#confirmForm").on('submit', function() {
              var form = $(this);
              // remove the text-danger
              $(".text-danger").remove();
              $.ajax({
            	  url: form.attr('action')+'?'+$('#confirmForm').serialize(),
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
                    $("#confirm-disp").hide();
                    $("#confirm-download-link").removeClass('hide');
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
    	$('#customerTable_info').remove();
        $('#customerTable_paginate').remove();
    	var restorepage = $('body').html();
    	var printcontent = $('.table').clone();
    	$('body').empty().html(printcontent);
    	window.print();
    	$('body').html(restorepage);
  	}
  </script>  

