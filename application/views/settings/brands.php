

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
                  <?php if(in_array('updateSetting', $user_permission) || in_array('deleteSetting', $user_permission)): ?>
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
                          <a href="<?php echo base_url('settings/brandView/'.$v['id']) ?>" class="">view</i></a>  
                          <?php endif; ?>&nbsp;
                          <?php if(in_array('updateSetting', $user_permission)): ?>
                          <a href="<?php echo base_url('settings/brandEdit/'.$v['id']) ?>" class="greenlink">edit</i></a>  
                          <?php endif; ?>&nbsp;
                          <?php if(in_array('deleteSetting', $user_permission)): ?>
                          <a href="<?php echo base_url('settings/brandDelete/'.$v['id']) ?>" class="redlink">delete</i></a>
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

  <script type="text/javascript">
    $(document).ready(function() {
      $('#customerTable').DataTable({
    	  'order' : [],
      });
      $('#settingMainNav').addClass('active');
    });
  </script>
