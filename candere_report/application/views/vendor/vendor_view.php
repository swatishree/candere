		<br/><br/>
	
		<div>
				<div>
					<ul>
						<li>Vendors</li>
						<li>
							<a href="<?php echo base_url(); ?>index.php/vendor">
								List Vendors
							</a>
						</li>
						<li>
							<a href="<?php echo base_url(); ?>index.php/vendor/create">
								Create Vendor
							</a>
						</li>
					</ul>
				</div>
			<div>
				
			<legend>View vendor</legend>
				
				<?php
				foreach($RowInfo as $row)
				{
					$vendor_id = $row->vendor_id;
					$vendor_name = $row->vendor_name;
					$active = $row->active;
					$CreatedBy = $row->CreatedBy;
					$CreatedDate = $row->CreatedDate;
				}
				?>
				<table>
					<tr>
						<th width="20%">ID</th>
						<td width="80%"><?php echo $vendor_id;?></td>
					</tr>
<tr>
					<th width="20%">vendor_name</th>
					<td width="80%"><?php echo $vendor_name;?></td>
				</tr>
<tr>
					<th width="20%">Active</th>
					<td width="80%"><?php echo ($active =='1')?'Yes':'No'; ?></td>
				</tr>
<tr>
					<th width="20%">CreatedBy</th>
					<td width="80%"><?php echo $CreatedBy;?></td>
				</tr>

<tr>
					<th width="20%">CreatedDate</th>
					<td width="80%"><?php echo $CreatedDate;?></td>
				</tr>
				</table>
				
					<div>
						<a href="<?php echo base_url(); ?>index.php/vendor/vendor_update/<?php echo $row->vendor_id;?>">Edit</a>
						<a href="<?php echo base_url(); ?>index.php/vendor/delete/<?php echo $row->vendor_id;?>" onclick="return confirm('Confirm Delete?')">
						Delete</a>
					</div>
			</div>
		</div>