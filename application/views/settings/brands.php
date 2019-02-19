

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="col-xs-12 col-sm-12 col-md-6">
      <h1>
       	Brands
      </h1>
      </div>
      
      <?php if(in_array('createSetting', $user_permission)): ?>
      <div class="col-xs-12 col-sm-12 col-md-6 text-right">
            <a href="<?php echo base_url('settings/brandCreate') ?>" class="btn btn-primary">Create New Brand</a> 
       </div>
          <?php endif; ?>
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
            <div class="box-body">
              <table id="customerTable" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Brand ID</th>
                  <th>Brand Name</th>
                  <?php if(in_array('updateSetting', $user_permission) || in_array('deleteSetting', $user_permission) || in_array('viewSetting', $user_permission)): ?>
                    <th>Action</th>
                  <?php endif; ?>
                </tr>
                </thead>
                <tbody>
                  <?php if($brands_data): ?>                  
                    <?php foreach ($brands_data as $k => $v): ?>
                      <tr>
                        <td><?php echo $v['id']; ?></td>
                        <td><?php echo $v['name']; ?></td>
                        <td>
                           <?php if(in_array('viewSetting', $user_permission)): ?>
                          <a href="<?php echo base_url('settings/brandView/'.$v['id']) ?>" class="">view</a>  
                          <?php endif; ?>&nbsp;
                          <?php if(in_array('updateSetting', $user_permission)): ?>
                          <a href="<?php echo base_url('settings/brandEdit/'.$v['id']) ?>" class="greenlink">edit</a>  
                          <?php endif; ?>&nbsp;
                          <?php if(in_array('deleteSetting', $user_permission)): ?>
                          <a href="#" onclick="removeFunc('<?php echo $v['id'];?>')" data-toggle="modal" data-target="#removeModal" class="redlink">delete</a>
                          <?php endif; ?>
                        </td>
                      </tr>
                    <?php endforeach ?>
                  <?php endif; ?>
                </tbody>
              </table>
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
  <!-- /.content-wrapper -->
 <!-- /.content-wrapper -->
<?php if(in_array('deleteSetting', $user_permission)): ?>
<!-- remove brand modal -->
<div class="modal fade" tabindex="-1" role="dialog" id="removeModal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Remove Brand</h4>
      </div>

      <form role="form" action="<?php echo base_url('settings/brandDelete/') ?>" method="get" id="removeForm">
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
    $(document).ready(function() {
      $('#customerTable').DataTable({
    	  'order' : [],
      });
      $('#settingMainNav').addClass('active');
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
            url: form.attr('action')+id,
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
                var delay = 1000; 
                setTimeout(function(){ window.location = '/settings/brands'; }, delay);
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
