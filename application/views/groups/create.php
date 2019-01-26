

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Create New Group
      </h1>
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
            <form role="form" action="<?php base_url('groups/create') ?>" method="post">
              <div class="box-body">

                <?php if(!empty(validation_errors())) { ?>
				<div class="alert alert-error alert-dismissible" role="alert">
              		<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                	<?php echo validation_errors(); ?>
                	</div>
				<?php } ?>

                <div class="form-group">
                  <label for="group_name">Group Name</label>
                  <input type="text" class="form-control" id="group_name" name="group_name" placeholder="Enter group name" autocomplete="off">
                </div>
                <div class="form-group">
                  <label for="permission">Permission</label>

                  <table class="table table-responsive dataTables_wrapper">
                    <thead>
                      <tr>
                        <th></th>
                        <th>Create</th>
                        <th>Update</th>
                        <th>View</th>
                        <th>Delete</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td>Users</td>
                        <td><input type="checkbox" name="permission[]" id="permission" value="createUser"></td>
                        <td><input type="checkbox" name="permission[]" id="permission" value="updateUser"></td>
                        <td><input type="checkbox" name="permission[]" id="permission" value="viewUser"></td>
                        <td><input type="checkbox" name="permission[]" id="permission" value="deleteUser"></td>
                      </tr>
                      <tr>
                        <td>Groups</td>
                        <td><input type="checkbox" name="permission[]" id="permission" value="createGroup"></td>
                        <td><input type="checkbox" name="permission[]" id="permission" value="updateGroup"></td>
                        <td><input type="checkbox" name="permission[]" id="permission" value="viewGroup"></td>
                        <td><input type="checkbox" name="permission[]" id="permission" value="deleteGroup"></td>
                      </tr>
                      <tr>
                        <td>Products</td>
                        <td><input type="checkbox" name="permission[]" id="permission" value="createProduct"></td>
                        <td><input type="checkbox" name="permission[]" id="permission" value="updateProduct"></td>
                        <td><input type="checkbox" name="permission[]" id="permission" value="viewProduct"></td>
                        <td><input type="checkbox" name="permission[]" id="permission" value="deleteProduct"></td>
                      </tr>
                      <tr>
                        <td>Costs</td>
                        <td><input type="checkbox" name="permission[]" id="permission" value="createCost"></td>
                        <td><input type="checkbox" name="permission[]" id="permission" value="updateCost"></td>
                        <td><input type="checkbox" name="permission[]" id="permission" value="viewCost"></td>
                        <td><input type="checkbox" name="permission[]" id="permission" value="deleteCost"></td>
                      </tr>
                      <tr>
                        <td>Sales</td>
                        <td><input type="checkbox" name="permission[]" id="permission" value="createSale"></td>
                        <td><input type="checkbox" name="permission[]" id="permission" value="updateSale"></td>
                        <td><input type="checkbox" name="permission[]" id="permission" value="viewSale"></td>
                        <td><input type="checkbox" name="permission[]" id="permission" value="deleteSale"></td>
                      </tr>
                      <tr>
                        <td>Warehouses</td>
                        <td><input type="checkbox" name="permission[]" id="permission" value="createWarehouse"></td>
                        <td><input type="checkbox" name="permission[]" id="permission" value="updateWarehouse"></td>
                        <td><input type="checkbox" name="permission[]" id="permission" value="viewWarehouse"></td>
                        <td><input type="checkbox" name="permission[]" id="permission" value="deleteWarehouse"></td>
                      </tr>
                      <tr>
                        <td>Deliveries</td>
                        <td><input type="checkbox" name="permission[]" id="permission" value="createDelivery"></td>
                        <td><input type="checkbox" name="permission[]" id="permission" value="updateDelivery"></td>
                        <td><input type="checkbox" name="permission[]" id="permission" value="viewDelivery"></td>
                        <td><input type="checkbox" name="permission[]" id="permission" value="deleteDelivery"></td>
                      </tr>
                      <tr>
                        <td>Pickups</td>
                        <td><input type="checkbox" name="permission[]" id="permission" value="createPickup"></td>
                        <td><input type="checkbox" name="permission[]" id="permission" value="updatePickup"></td>
                        <td><input type="checkbox" name="permission[]" id="permission" value="viewPickup"></td>
                        <td><input type="checkbox" name="permission[]" id="permission" value="deletePickup"></td>
                      </tr>
                      <tr>
                        <td>Transfers</td>
                        <td><input type="checkbox" name="permission[]" id="permission" value="createTransfer"></td>
                        <td><input type="checkbox" name="permission[]" id="permission" value="updateTransfer"></td>
                        <td><input type="checkbox" name="permission[]" id="permission" value="viewTransfer"></td>
                        <td><input type="checkbox" name="permission[]" id="permission" value="deleteTransfer"></td>
                      </tr>
                      <tr>
                        <td>Withdrawals</td>
                        <td><input type="checkbox" name="permission[]" id="permission" value="createWithdrawal"></td>
                        <td><input type="checkbox" name="permission[]" id="permission" value="updateWithdrawal"></td>
                        <td><input type="checkbox" name="permission[]" id="permission" value="viewWithdrawal"></td>
                        <td><input type="checkbox" name="permission[]" id="permission" value="deleteWithdrawal"></td>
                      </tr>
                      
                      
                      <tr>
                        <td>Customers</td>
                        <td><input type="checkbox" name="permission[]" id="permission" value="createCustomer"></td>
                        <td><input type="checkbox" name="permission[]" id="permission" value="updateCustomer"></td>
                        <td><input type="checkbox" name="permission[]" id="permission" value="viewCustomer"></td>
                        <td><input type="checkbox" name="permission[]" id="permission" value="deleteCustomer"></td>
                      </tr>
                      <tr>
                        <td>Settings</td>
                        <td><input type="checkbox" name="permission[]" id="permission" value="createSetting"></td>
                        <td><input type="checkbox" name="permission[]" id="permission" value="updateSetting"></td>
                        <td><input type="checkbox" name="permission[]" id="permission" value="viewSetting"></td>
                        <td><input type="checkbox" name="permission[]" id="permission" value="deleteSetting"></td>
                      </tr>
                    </tbody>
                  </table>
                  
                </div>
              </div>
              <!-- /.box-body -->

              <div class="box-footer">
                <button type="submit" class="btn btn-primary">Save Changes</button>
                <a href="<?php echo base_url('groups/') ?>" class="btn btn-warning">Back</a>
              </div>
            </form>
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
      $('#groupMainNav').addClass('active');
      $('#createGroupSubMenu').addClass('active');
    });
  </script>

