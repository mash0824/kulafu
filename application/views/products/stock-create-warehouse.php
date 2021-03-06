

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Add Stock
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
                        <div class="form-group col-md-3 col-xs-12">
        					<label for="pd_disp_id">Sales Invoice No.</label>
                          <input type="text" class="form-control" id="sales_invoice_id" name="sales_invoice_id" placeholder="eg. SI-000001" autocomplete="off" value=""  required />
                        </div>
                        <div class="form-group col-md-3 col-xs-12">
                          <label for="unit_id">Destination Location</label>
                          <select class="form-control select_group" id="store_id" name="store_id">
                          	<option value=""></option>
                            <?php foreach ($stores as $k => $v): ?>
                              <option value="<?php echo $v['id'] ?>" <?php if($v['id'] == $store_id): echo "selected"; endif;?> ><?php echo $v['name'] ?></option>
                            <?php endforeach ?>
                          </select>
                        </div>
                        <input id="mgrBuyer_new_qty_mappedFields" type='hidden' value="0" />
    				</div>
    				<div class="col-xs-12 col-md-12">
    					<div class="form-group col-md-3 col-xs-12">
                          <label for="supplier_name">Supplier Name</label>
                          <input type="text" class="form-control" id="supplier_name" name="supplier_name" placeholder="eg Supplier Name" autocomplete="off" value=""  />
                        </div>
                        <div class="form-group col-md-3 col-xs-12">
                          <label for="location">Location</label>
                          <input type="text" class="form-control" id="location" name="location" placeholder="eg Room A" autocomplete="off" value=""  />
                        </div>
    				</div>
                    <div class="col-xs-12" id="allMappedFields">
                        <div class='mappedFieldTemplate' id='mappedFieldTemplate_1' id='mappedFieldTemplate_1' >
                        	<div class="form-group col-md-5 col-xs-12">
                              <label for="product_id[]">Product name</label>
                              <select class="form-control select_group  fieldLabel" id="product_id_1" data-row-id="row_1"  name="product_id[]" required>
                              	<option value=""></option>
                                <?php foreach ($products as $k => $v): ?>
                                  <option value="<?php echo $v['id'] ?>"><?php echo $v['name'] ?></option>
                                <?php endforeach ?>
                              </select>
                            </div>
                            <div class="form-group col-md-2 col-xs-12">
                              <label for="max_quantity">Quantity</label>
                              <input type="number" min="0" max="" class="form-control fieldLabel1"  onkeypress="return isNumber(event)" id="quantity_1" name="quantity[]" placeholder="eg. 100" autocomplete="off" value="" required />
                            </div>
                            
                            <div class="form-group col-md-2 col-xs-12">
                              <label for="expiry_date">Expiry Date</label>
                              <input type="text" class="form-control datepicker fieldLabel2" id="expiry_date_1" name="expiry_date[]" placeholder="eg. 12/24/2019" autocomplete="off" value="" readonly /> 
                            </div>
                            <div class="form-group col-md-2 col-xs-12"><a href="#" class="btn btn-danger removeMappedField"><i class="fa fa-minus fa-inverse"></i></a></div>
                        </div>
                    </div>
    
				</div>
              </div>
              <!-- /.box-body -->
              <div class="box-footer">
                <a href='#' id='addNewMappedField' class='greenlink '>Add more products</a> <br/>
                <button type="submit" class="btn btn-primary">Update</button>
                <a href="<?php echo base_url('/lists-of-products/'.$store_name.'/'.$store_id) ?>" class="btn btn-warning">Back</a>
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
    $(".datepicker").datepicker();  
    $("#warehouseMainNav").addClass('active');

    // mapped fields
    $('#addNewMappedField').click(function(e){
      // increment count
      newMappedFieldCount = parseInt($('#mgrBuyer_new_qty_mappedFields').val()) + 1;
      $('#mgrBuyer_new_qty_mappedFields').val(newMappedFieldCount);
      e.preventDefault();

      // copy, prep, and place new fields
      var clone = $('.mappedFieldTemplate:first').clone();

      var fieldLabel = clone.find('.fieldLabel');
      var fieldLabel1 = clone.find('.fieldLabel1');
      var fieldLabel2 = clone.find('.fieldLabel2');

      fieldLabel.attr('id', 'mgrBuyer_new_varField_'+newMappedFieldCount);
    fieldLabel.attr('name', 'product_id[]');
    fieldLabel1.attr('id', 'mgrBuyer_new_varField_b_'+newMappedFieldCount);
    fieldLabel1.attr('name', 'quantity[]');
    fieldLabel2.attr('id', 'mgrBuyer_new_varField_c_'+newMappedFieldCount);
    fieldLabel2.attr('name', 'expiry_date[]');
    fieldLabel2.datepicker();

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

         fieldLabel = $(field).find('.fieldLabel');
         fieldLabel1 = $(field).find('.fieldLabel1');
         fieldLabel2 = $(field).find('.fieldLabel2');

         fieldLabel.attr('id', 'mgrBuyer_new_varField_'+newCount);
	    fieldLabel.attr('name', 'product_id[]');
	    fieldLabel1.attr('id', 'mgrBuyer_new_varField_b_'+newCount);
	    fieldLabel1.attr('name', 'quantity[]');
	    fieldLabel2.attr('id', 'mgrBuyer_new_varField_c_'+newCount);
	    fieldLabel2.attr('name', 'expiry_date[]');

      });

      $('#mgrBuyer_new_qty_mappedFields').val(newCount);
   });






    
});
</script>