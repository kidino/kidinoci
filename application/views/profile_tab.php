<?php
$tabs = array(
	'user' => '',
	'profile' => ''
);
$tabs[$active_tab] = ' class="active"';
?>
<h2><?php echo $user['username'].' ('.$user['email'].')';?></h2>
 <ul class="nav nav-tabs">
  <li role="presentation"<?php echo $tabs['user']?>><a href="<?php echo site_url('profile/index/edit/'.$user['id']);?>">Account</a></li>
  <li role="presentation"<?php echo $tabs['profile']?>><a href="<?php echo site_url('profile/user_profile/edit/'.$user_profile['id']);?>">Profile</a></li>
</ul>
<p>&nbsp;</p>