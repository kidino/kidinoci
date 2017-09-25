<?php
function is_checked($access_ids, $aid) {
	if (in_array($aid, $access_ids)) echo ' checked=checked';
}
?>
<div class="row">
	<div class="col-md-12">
		<p><a href="<?php echo site_url('users/groups');?>">&larr; Back to Groups</a></p>
<h1>Access for <?php echo $user_group['name'].' ('.$user_group['code'].')'?></h1>		

<?php if($error) : ?>
<p class="alert alert-danger">No access type selected. Please revise.</p>
<?php endif; ?>

<?php if($success) : ?>
<p class="alert alert-success">Access for group has been updated.</p>
<?php endif; ?>

	</div>
</div>

<form method="post" action="<?php echo current_url();?>">
<div class="row">
<?php foreach($user_access_types as $k => $atype) : ?>
	<div class="col-md-2">
	  <div class="checkbox">
		<label>
		  <input type="checkbox" name="access_ids[]" value="<?php echo $atype['acctype_id']?>"<?php is_checked($access_ids, $atype['acctype_id'])?>> <?php echo $atype['code']?>
		</label>
	  </div>		
	</div>
<?php endforeach; ?>
</div>
<div class="row">
	<div class="col-md-12">
		<button class="btn btn-primary" type="submit">Save Access for Group</button>
	</div>
</div>
</form>
