

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Add Stocks Summary
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
                  <th class="thwidth">Sales Invoice No.</th>
                  <td><?php echo $stock_data[0]['sales_invoice']; ?></td>
                </tr>
                <tr>
                  <th  class="thwidth">Destination Location</th>
                  <td><?php echo $stores['name']; ?></td>
                </tr>
              </table>
              
              <div class="row">
                <div class="col-md-12 col-xs-12">
                	
                	<div class="box">
                    <!-- /.box-header -->
                    <div class="box-body">
                      <table id="customerTable" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                          <th>Product Name</th>
                          <th>Quantity</th>
                          <th>Unit</th>
                          <th>Expiry Date</th>
                        </tr>
                        </thead>
                        <tbody>
                          <?php if($stock_data): ?>                  
                            <?php foreach ($stock_data as $k => $v): ?>
                              <tr>
                                <td><?php echo $v['product_name']; ?></td>
                                <td><?php echo $v['quantity']; ?></td>
                                <td><?php echo $v['unit_name']; ?></td>
                                <td><?php echo $v['expiry_date']; ?></td>
                              </tr>
                            <?php endforeach ?>
                          <?php endif; ?>
                        </tbody>
                      </table>
                      <div>
                      <br/>
                      <a href="<?php echo base_url('stocks-edit/'.$stock_id) ?>" class="btn btn-primary">Edit Stock</a> <a href="<?php echo base_url('products') ?>" class="btn btn-warning">Back</a>
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
  </script>  

