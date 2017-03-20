<table width="100%" cellspacing=0 cellpadding=0>
				<tbody>
					<tr style="height:40px;">
						<th class="th_color">entity_id</th>
						<th class="th_color">state</th>
						<th class="th_color">status</th>
						<th class="th_color">increment_id</th>
					</tr>

<?php 

if($selectdata) {
	foreach($selectdata as $row) {
?>
		<tr>
						<td><?php echo $row->entity_id ?></td>
						<td><?php echo $row->state ?></td>
						<td><?php echo $row->status ?></td>
						<td><?php echo $row->increment_id ?></td>
					</tr>
		<?php
	}
}
?>
	<?php 
if($selectdata) {
	echo $this->pagination->create_links();
} ?>				
	</tbody>
</table>
