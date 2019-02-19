<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">
        
        <li id="dashboardMainMenu">
          <a href="<?php echo base_url('dashboard') ?>">
            <i class="fa fa-dashboard"></i> <span>Dashboard</span>
          </a>
        </li>

        <?php if($user_permission): ?>
          

        <!-- <li class="header">Settings</li> -->
        <?php if(in_array('createProduct', $user_permission) || in_array('updateProduct', $user_permission) || in_array('viewProduct', $user_permission) || in_array('deleteProduct', $user_permission)): ?>
        	<li id="productMainNav"><a href="<?php echo base_url('products/') ?>"><i class="fa fa-industry"></i> <span>Products</span></a></li>
          <?php endif; ?>
          <?php if(in_array('createWarehouse', $user_permission) || in_array('updateWarehouse', $user_permission) || in_array('viewWarehouse', $user_permission) || in_array('deleteWarehouse', $user_permission)
              || in_array('createDelivery', $user_permission) || in_array('updateDelivery', $user_permission) || in_array('viewDelivery', $user_permission) || in_array('deleteDelivery', $user_permission)
              || in_array('createPickup', $user_permission) || in_array('updatePickup', $user_permission) || in_array('viewPickup', $user_permission) || in_array('deletePickup', $user_permission)
              || in_array('createTransfer', $user_permission) || in_array('updateTransfer', $user_permission) || in_array('viewTransfer', $user_permission) || in_array('deleteTransfer', $user_permission)
              || in_array('createWithdrawal', $user_permission) || in_array('updateWithdrawal', $user_permission) || in_array('viewWithdrawal', $user_permission) || in_array('deleteWithdrawal', $user_permission)
              ): ?>
		<?php echo $this->warehouse_menu->build_menu(); ?>
          <?php endif; ?>
          
          <?php if(in_array('viewCustomer', $user_permission) || in_array('createCustomer', $user_permission) || in_array('deleteCustomer', $user_permission) || in_array('updateCustomer', $user_permission)): ?>
            <li id="customerMainNav"><a href="<?php echo base_url('customers/') ?>"><i class="fa fa-address-book-o"></i> <span>Customers</span></a></li>
          <?php endif; ?>

			<?php if(in_array('createUser', $user_permission) || in_array('updateUser', $user_permission) || in_array('viewUser', $user_permission) || in_array('deleteUser', $user_permission)): ?>
			<li id="createUserMainNav"><a href="<?php echo base_url('users/') ?>"><i class="fa fa-users"></i> <span>Users</span></a></li>
          <?php endif; ?>

          <?php if(in_array('viewGroup', $user_permission) || in_array('createGroup', $user_permission) || in_array('deleteGroup', $user_permission) || in_array('updateGroup', $user_permission)): ?>
          	<li id="groupMainNav"><a href="<?php echo base_url('groups') ?>"><i class="fa fa-user-circle"></i> <span>Groups</span></a></li>
          <?php endif; ?>
			
           <li id="profileMainNav"><a href="<?php echo base_url('users/myAccount/') ?>"><i class="fa fa-vcard-o"></i> <span>My Account</span></a></li>
          
          <?php if(in_array('viewSetting', $user_permission) || in_array('createSetting', $user_permission) || in_array('deleteSetting', $user_permission) || in_array('updateSetting', $user_permission)): ?>
            <li class="treeview" id="settingMainNav">
              <a href="#">
                <i class="fa fa-wrench"></i> 
                <span>Setting</span>
                <span class="pull-right-container">
                  <i class="fa fa-angle-right pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu">
                <?php if(in_array('updateSetting', $user_permission) || in_array('viewSetting', $user_permission) || in_array('deleteSetting', $user_permission)): ?>
                  <li id="viewSettingsSubMenu"><a href="<?php echo base_url('settings/brands') ?>"><i class="fa fa-angle-right"></i> Manage Brands</a></li>
                <?php endif; ?>
                <?php if(in_array('updateSetting', $user_permission) || in_array('viewSetting', $user_permission) || in_array('deleteSetting', $user_permission)): ?>
                	<li id="viewSettingsSubMenu"><a href="<?php echo base_url('settings/units') ?>"><i class="fa fa-angle-right"></i> Manage Unit of Measure</a></li>
                <?php endif; ?>
              </ul>
            </li>
          <?php endif; ?>

        <?php endif; ?>
        

        <li><a href="<?php echo base_url('auth/logout') ?>"><i class="glyphicon glyphicon-log-out"></i> <span>Logout</span></a></li>

      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>