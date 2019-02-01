

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Create New Product
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
        					<label for="pd_disp_id">Product ID</label>
                          <input type="text" class="form-control" id="pd_disp_id" name="pd_disp_id" placeholder="" autocomplete="off" value="<?php echo $products_data['pd_disp_id'];?>" disabled />
                        </div>
    				</div>
    				<div class="col-xs-12">
                        <div class="form-group col-md-3 col-xs-12">
                          <label for="sku">Supplier SKU</label>
                          <input type="text" class="form-control" id="sku" name="sku" placeholder="Enter Supplier SKU" autocomplete="off" value="<?php echo $this->input->post('sku') ?>" />
                        </div>
                        
                        <div class="form-group col-md-3 col-xs-12">
                          <label for="brand_id">Brand</label>
                          <select class="form-control select_group" id="brand_id" name="brand_id">
                          	<option value=""></option>
                            <?php foreach ($brands as $k => $v): ?>
                              <option value="<?php echo $v['id'] ?>"><?php echo $v['name'] ?></option>
                            <?php endforeach ?>
                          </select>
                        </div>
                    </div>
                    <div class="col-xs-12">
                        <div class="form-group col-md-9 col-xs-12">
                          <label for="product_name">Product name</label>
                          <input type="text" class="form-control" id="name" name="name" placeholder="Enter product name" autocomplete="off" value="<?php echo $this->input->post('name') ?>" />
                        </div>
                    </div>
                    
                    <div class="col-xs-12">
                        <div class="form-group col-md-3 col-xs-12">
                          <label for="unit_id">Unit of Measure</label>
                          <select class="form-control select_group" id="unit_id" name="unit_id">
                          	<option value=""></option>
                            <?php foreach ($units as $k => $v): ?>
                              <option value="<?php echo $v['id'] ?>"><?php echo $v['name'] ?></option>
                            <?php endforeach ?>
                          </select>
                        </div>
                        <div class="form-group col-md-3 col-xs-12">
                          <label for="max_quantity">Maximum Quantity</label>
                          <input type="text" class="form-control" id="max_quantity" name="max_quantity" placeholder="eg. 0" autocomplete="off" value="<?php echo $this->input->post('max_quantity') ?>" />
                        </div>
                        
                        <div class="form-group col-md-3 col-xs-12">
                          <label for="quantity_in_box">Quantity inside 1 box</label>
                          <input type="text" class="form-control" id="quantity_in_box" name="quantity_in_box" placeholder="eg. 0" autocomplete="off" value="<?php echo $this->input->post('quantity_in_box') ?>" />
                        </div>
                    </div>
    				<div class="col-xs-12">
                        <div class="form-group col-md-3 col-xs-12">
                          <label for="price">Price</label>
                          <input type="text" class="form-control" id="cost" name="cost" placeholder="eg. 20.00" autocomplete="off" value="<?php echo $this->input->post('cost') ?>"/>
                        </div>
                        
                        <div class="form-group  col-md-3 col-xs-12">
                          <label for="sale_price">Cost</label>
                          <input type="text" class="form-control" id="sale_price" name="sale_price" placeholder="eg. 40.00" autocomplete="off" value="<?php echo $this->input->post('sale_price') ?>"/>
                        </div>
                    </div>
    
				</div>
              </div>
              <!-- /.box-body -->
              <div class="box-footer">
                <button type="submit" class="btn btn-primary">Save Changes</button>
                <a href="<?php echo base_url('products/') ?>" class="btn btn-warning">Back</a>
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
    $(".select_group").select2();
    $("#description").wysihtml5();

    $("#productMainNav").addClass('active');
    $("#createProductSubMenu").addClass('active');
    
    var btnCust = '<button type="button" class="btn btn-secondary" title="Add picture tags" ' + 
        'onclick="alert(\'Call your custom code here.\')">' +
        '<i class="glyphicon glyphicon-tag"></i>' +
        '</button>'; 
    $("#product_image").fileinput({
        overwriteInitial: true,
        maxFileSize: 1500,
        showClose: false,
        showCaption: false,
        browseLabel: '',
        removeLabel: '',
        browseIcon: '<i class="glyphicon glyphicon-folder-open"></i>',
        removeIcon: '<i class="glyphicon glyphicon-remove"></i>',
        removeTitle: 'Cancel or reset changes',
        elErrorContainer: '#kv-avatar-errors-1',
        msgErrorClass: 'alert alert-block alert-danger',
        // defaultPreviewContent: '<img src="/uploads/default_avatar_male.jpg" alt="Your Avatar">',
        layoutTemplates: {main2: '{preview} ' +  btnCust + ' {remove} {browse}'},
        allowedFileExtensions: ["jpg", "png", "gif"]
    });

  });
</script>