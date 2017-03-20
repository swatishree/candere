	<br/>		
	<div>
		<div>
			<ul>
				<li>Events</li>
				<li>
					<a href="<?php echo base_url(); ?>index.php/vendor">
						List vendors
					</a>
				</li>
				<li>
					<a href="<?php echo base_url(); ?>index.php/vendor/create">
						Create vendor
					</a>
				</li>
			</ul>
		</div>
	</div>
				    
	<div><strong>List vendor</strong></div>
			
			<?php
			if(!empty($RowsSelected))
			{
			?>
			<table border=1>
					<thead>
						<tr>
							<th>ID</th>
							<th>VendorName</th>
							<th>Active</th>
							<th>CreatedBy</th>
							<th>CreatedDate</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
					<?php
					foreach($RowsSelected as $row) {
					$active = isset($row->active)?'Active':'Non-active';	
					?>
						<tr>
							<td><?php echo $row->vendor_id;?></td>
							<td><?php echo $row->vendor_name;?></td>
							<td><?php echo $active;?></td>
							<td><?php echo $row->created_by;?></td>
							<td><?php echo $row->created_date;?></td>
							<td>
								<a href="<?php echo base_url(); ?>index.php/vendor/view/<?php echo $row->vendor_id;?>" title="View">
								View</a>
								<a href="<?php echo base_url(); ?>index.php/vendor/vendor_update/<?php echo $row->vendor_id;?>" title="Edit">
								Edit</a>
								<a href="<?php echo base_url(); ?>index.php/vendor/delete/<?php echo $row->vendor_id;?>" title="Delete" onclick="return confirm('Confirm Delete?')">
								Delete</a>
							</td>
						</tr>
					<?php
					}
					?>
					</tbody>
				</table>
				<?php
				}
				else
				{
				?>
				<table><tr>
				<td>There is no record</td></tr></table>
				<?php
				}
				?>
				
		</div>