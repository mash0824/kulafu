

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1 class="margin50">
      Create New Delivery
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


        <div class="box">
          <!-- /.box-header -->
          <form role="form" action="" method="post" enctype="multipart/form-data">
              <div class="box-body">

                <?php if(!empty(validation_errors())) { ?>
				<div class="alert alert-error alert-dismissible" role="alert">
              		<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                	<?php echo validation_errors(); ?>
                	</div>
				<?php } ?>
				<div class="col-xs-12 col-md-12" ">
					<div class="col-xs-12">
                        <div class="form-group col-md-4 col-xs-12">
        					<label for="display_id">Delivery ID</label>
                          <input type="text" class="form-control" id="display_id" name="display_id" placeholder="eg. DL-MO-000001" autocomplete="off" value="<?php echo $display_id;?>" disabled  />
                        </div>
                        <div class="form-group col-md-4 col-xs-12">
        					<label for="po_number">PO Number</label>
                          <input type="number" class="form-control" id="po_number" name="po_number" placeholder="eg. 132456987" autocomplete="off" value=""  required />
                        </div>
                        
                        <input id="mgrBuyer_new_qty_mappedFields" type='hidden' value="0" />
    				</div>
    				<div class="col-xs-12">
    					<div class="form-group col-md-4 col-xs-12">
                          <label for="store_id">Source Location</label>
                          <select class="form-control select_group" id="store_id" name="store_id" required>
                          	<option value=""></option>
                              <option value="<?php echo $warehouse_data['id'] ?>" <?php  echo "selected"; ?> ><?php echo $warehouse_data['name'] ?></option>
                          </select>
                        </div>
                        <div class="form-group col-md-4 col-xs-12">
                          <label for="customer_id">Customer or Company Name</label>
                          <select class="form-control select_group" id="customer_id" name="customer_id" required>
                          	<option value=""></option>
                              <?php foreach ($customers as $k => $v): ?>
                              <option value="<?php echo $v['id'] ?>" ><?php echo $v['customer_name'] ?></option>
                            <?php endforeach ?>
                          </select>
                        </div>
    				</div>
    				<div class="col-xs-12">
    					<div class="form-group col-md-8 col-xs-12">
                          <label for="address">Delivery Address</label>
                  		  <textarea type="text" class="form-control" id="address" name="address" placeholder="Enter Delivery Address" autocomplete="off" required></textarea>
                        </div>
    				</div>
    				
                    <div class="col-xs-12" id="allMappedFields">
                        <div class='col-xs-12 mappedFieldTemplate' id='mappedFieldTemplate_0' id='mappedFieldTemplate_0' >
                        	<div class="form-group col-md-4 col-xs-12">
                              <label for="product_id[]">Product name</label>
                              <select class="form-control select_group  prodLabel" id="product_id_0" data-row-id="row_0"  name="product_id[]" required>
                              	<option value=""></option>
                                <?php 
                                    foreach ($products as $k => $v): 
                                    $stock_count = (($v['stock_count'] - $v['less_stock']) > 0 ? intval($v['stock_count'] - $v['less_stock']) : 0);
                                
                                ?>
                                  <option value="<?php echo $v['product_id'] ?>" data-cost="<?php echo $v['cost'] ?>" data-price="<?php echo $v['sale_price'] ?>" data-stock="<?php echo $stock_count ?>" data-unit="<?php echo $v['unit_id'] ?>"><?php echo $v['name'] ?></option>
                                <?php endforeach ?>
                              </select>
                            </div>
                            <div class="form-group col-md-2 col-xs-12">
                            	<label for="instock">In Stock</label>
                            	<input type="text" class="form-control instockLabel" id="instock_0" name="instock[]" data-row-id="row_0" placeholder="eg. 100" autocomplete="off" value="" disabled />
                            	<input type="hidden" class="form-control priceLabel" id="price_0" name="price[]" data-row-id="row_0" placeholder="eg. 100" autocomplete="off" value=""  />
                            	<input type="hidden" class="form-control costLabel" id="cost_0" name="cost[]" data-row-id="row_0" placeholder="eg. 100" autocomplete="off" value=""  />
                            	
                            </div>
                            <div class="form-group col-md-2 col-xs-12">
                              <label for="quantity[]">Quantity</label>
                              <input type="number" min="0" max="" class="form-control quantityLabel" id="quantity_0"  onkeypress="return isNumber(event)" name="quantity[]" data-row-id="row_0" placeholder="eg. 100" autocomplete="off" value="" required />
                            </div>
                            <div class="form-group col-md-2 col-xs-12">
                              <label for="unit_id[]">Unit of Measure</label>
                              <select class="form-control select_group  unitLabel" id="unit_id_0" data-row-id="row_0" name="unit_id[]" disabled >
                              	<option value=""></option>
                                <?php foreach ($units as $k => $v): ?>
                                  <option value="<?php echo $v['id'] ?>"><?php echo $v['name'] ?></option>
                                <?php endforeach ?>
                              </select>
                            </div>
                            <div class="form-group col-md-2 col-xs-12">
                              <label for="sales_amount">Sales Amount</label>
                              <input type="text" class="form-control salesLabel" id="sales_amount_0" data-row-id="row_0" name="sales_amount[]" placeholder="eg.0.00" autocomplete="off" value="" disabled /> 
                            </div>
                            <div class="form-group col-md-2 col-xs-12"><a href="#" id="remove_0" class="btn btn-danger removeMappedField"><i class="fa fa-minus fa-inverse"></i></a></div>
                        </div>
                    </div>
                    <div class="col-xs-12">
                    	<div class="form-group col-md-2 col-xs-12">
                          <label for="total_sales">Total Sales</label>
                          <input type="text" class="form-control" id="total_sales" name="total_sales" data-row-id="row_0" placeholder="0.00" autocomplete="off" value="<?php echo $this->input->post('total_sales') ?>" disabled />
                        </div>
                    </div>
                    <div class="col-xs-12">
                    	<div class="form-group col-md-2 col-xs-12">
                          <label for="notes">Additional Notes</label>
                          <input type="text" class="form-control" id="notes" name="notes" data-row-id="row_0" placeholder="Additional Notes" autocomplete="off" value="<?php echo $this->input->post('notes') ?>"  />
                        </div>
                    </div>
    
				</div>
              </div>
              <!-- /.box-body -->
              <div class="box-footer margin50">
                <a href='#' id='addNewMappedField' class='greenlink '>Add more products</a> <br/>
                <input type="checkbox" id="checkme" name="checkme" value="1" /> Mark as delivered <br/>
                <button type="submit" class="btn btn-primary">Create Delivery Order</button>
                <a href="<?php echo base_url('/deliveries/'.strtolower(str_replace(" ", "-", $warehouse_data['name'])).'/'.$warehouse_data['id']) ?>" class="btn btn-warning">Back</a>
              </div>
            </form>
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
<!-- /.content-wrapper -->

<script type="text/javascript">
$(document).ready(function() {
	var total = 0;
    $("#warehouseMainNav").addClass('active');
    $("#remove_0").addClass('hide');
    $(document).on('change', '.prodLabel', function() {
    	var suffix = this.id.match(/\d+/); 
    	$('#instock_'+suffix).val($(this).find(':selected').attr('data-stock'));
    	$('#price_'+suffix).val($(this).find(':selected').attr('data-price'));
    	$('#cost_'+suffix).val($(this).find(':selected').attr('data-cost'));
    	$('#unit_id_'+suffix).val($(this).find(':selected').attr('data-unit'));
    	$('#quantity_'+suffix).attr('max', $(this).find(':selected').attr('data-stock'));
    });

    $(document).on('change', '.quantityLabel', function() {
    	var suffix = this.id.match(/\d+/); 
    	var instockVal = $('#instock_'+suffix).val();
    	var priceVal = $('#price_'+suffix).val();
    	var qtyVal = $(this).val();
    	var sum = 0;
    	if(parseFloat(qtyVal) > parseFloat(instockVal)) {
    		$("#messages").html('<div class="alert alert-warning alert-dismissible" role="alert">'+
            '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
            '<strong> <span class="glyphicon glyphicon-exclamation-sign"></span> </strong>quantity is greater than In Stock value.</div>');
			$(this).focus();
    	}
    	else if(parseFloat(qtyVal) <= 0) {
    		$("#messages").html('<div class="alert alert-warning alert-dismissible" role="alert">'+
            '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
            '<strong> <span class="glyphicon glyphicon-exclamation-sign"></span> </strong>quantity should be greater than zero.</div>');
			$(this).focus();
    	}
    	else {
    		$("#messages").html('');
    		sum = parseFloat(priceVal) * parseFloat(qtyVal);
    		var sumd = sum;
    		$('#sales_amount_'+suffix).val(sumd.toLocaleString("en"));
    		total += sum;
    		var totald = total;
    		$('#total_sales').val(totald.toLocaleString("en"));
    	}
    });

    // mapped fields
    $('#addNewMappedField').click(function(e){
      // increment count
      newMappedFieldCount = parseInt($('#mgrBuyer_new_qty_mappedFields').val()) + 1;
      $('#mgrBuyer_new_qty_mappedFields').val(newMappedFieldCount);
      e.preventDefault();

      // copy, prep, and place new fields
      var clone = $('.mappedFieldTemplate:first').clone();

      var prodLabel = clone.find('.prodLabel');
      var instockLabel = clone.find('.instockLabel');
      var priceLabel = clone.find('.priceLabel');
      var quantityLabel = clone.find('.quantityLabel');
      var unitLabel = clone.find('.unitLabel');
      var salesLabel = clone.find('.salesLabel');
      var costLabel = clone.find('.costLabel');
      var removeLabel = clone.find('.removeMappedField');

      prodLabel.find("input").val("");
      prodLabel.attr('id', 'product_id_'+newMappedFieldCount);
      prodLabel.attr('name', 'product_id[]');
      prodLabel.val("");

      instockLabel.find("input").val("");
      instockLabel.attr('id', 'instock_'+newMappedFieldCount);
      instockLabel.attr('name', 'instock[]');
      instockLabel.val("");
      
      priceLabel.find("input").val("");
      priceLabel.attr('id', 'price_'+newMappedFieldCount);
      priceLabel.attr('name', 'price[]');
      priceLabel.val("");
      
      costLabel.find("input").val("");
      costLabel.attr('id', 'cost_'+newMappedFieldCount);
      costLabel.attr('name', 'cost[]');
      costLabel.val("");
      
      quantityLabel.find("input").val("");
      quantityLabel.attr('id', 'quantity_'+newMappedFieldCount);
      quantityLabel.attr('name', 'quantity[]');
      quantityLabel.val("");

      unitLabel.find("input").val("");
      unitLabel.attr('id', 'unit_id_'+newMappedFieldCount);
      unitLabel.attr('name', 'unit_id[]');
      unitLabel.val("");

      
      salesLabel.find("input").val("");
      salesLabel.attr('id', 'sales_amount_'+newMappedFieldCount);
      salesLabel.attr('name', 'sales_amount[]');
      salesLabel.val("");

      removeLabel.attr('id', 'remove_'+newMappedFieldCount);
      removeLabel.removeClass('hide')
	  
      clone.attr('id', 'mappedField_'+ (newMappedFieldCount));
      clone.appendTo('#allMappedFields');
      clone.show('slide');
   });

   $('#allMappedFields').on('click','.removeMappedField', function(e){
      e.preventDefault();
      var curHeader = $(e.target).closest('.mappedFieldTemplate');

      curHeader.remove();

      var newCount = 0;
      $.each($('.mappedFieldTemplate:not(:first)'), function(key, field){

         newCount++;

         prodLabel = $(field).find('.prodLabel');
         instockLabel = $(field).find('.instockLabel');
         quantityLabel = $(field).find('.quantityLabel');
         unitLabel = $(field).find('.unitLabel');
         salesLabel = $(field).find('.salesLabel');
         priceLabel = clone.find('.priceLabel');

         prodLabel.find("input").val("");
         prodLabel.attr('id', 'product_id_'+newCount);
         prodLabel.attr('name', 'product_id[]');

         instockLabel.find("input").val("");
         instockLabel.attr('id', 'instock_'+newCount);
         instockLabel.attr('name', 'instock[]');

         priceLabel.find("input").val("");
         priceLabel.attr('id', 'price_'+newCount);
         priceLabel.attr('name', 'price[]');

         costLabel.find("input").val("");
         costLabel.attr('id', 'cost_'+newCount);
         costLabel.attr('name', 'cost[]');

         quantityLabel.find("input").val("");
         quantityLabel.attr('id', 'quantity_'+newCount);
         quantityLabel.attr('name', 'quantity[]');

         unitLabel.find("input").val("");
         unitLabel.attr('id', 'unit_id_'+newCount);
         unitLabel.attr('name', 'unit_id[]');

         salesLabel.find("input").val("");
         salesLabel.attr('id', 'sales_amount_'+newCount);
         salesLabel.attr('name', 'sales_amount[]');
      });

      $('#mgrBuyer_new_qty_mappedFields').val(newCount);
   });
});
</script>