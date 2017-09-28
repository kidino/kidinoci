    <nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container-fluid">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="<?php echo site_url('')?>"><?php echo $appname;?></a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
         
         
          <ul class="nav navbar-nav">
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="glyphicon glyphicon-folder-close"></span> Apps <span class="caret"></span></a>
              <ul class="dropdown-menu">
                <li><a href="<?php echo site_url('contacts')?>">Contacts </a></li>
              </ul>
            </li>
            
			</ul>
         
         
          <ul class="nav navbar-nav navbar-right">
           
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="glyphicon glyphicon-cog"></span> Settings <span class="caret"></span></a>
              <ul class="dropdown-menu">
                <li><a href="<?php echo site_url('settings');?>">App Settings </a></li>
                <li role="separator" class="divider"></li>
                <li class="dropdown-header">User Management</li>
                <li><a href="<?php echo site_url('users');?>">Users</a></li>
                <li><a href="<?php echo site_url('users/groups');?>">Groups</a></li>
                <?php if (check_access('admin_access_types')) { ?><li><a href="<?php echo site_url('users/access_types');?>">Access Type</a></li><?php } ?>
              </ul>
            </li>
            
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="glyphicon glyphicon-user"></span> <?php echo $_SESSION['username']?> <span class="caret"></span></a>
              <ul class="dropdown-menu">
                <li><a href="<?php echo site_url('profile');?>">Profile</a></li>
                <li><a href="<?php echo site_url('profile/password');?>">Update Password</a></li>
                <li role="separator" class="divider"></li>
                <li><a href="<?php echo site_url('auth/logout');?>">Logout</a></li>
              </ul>
            </li>
          </ul>
        </div>
      </div>
    </nav>