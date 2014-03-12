<div class="filter">
	<p>Vehicle Filter</p>

	<?php 
		echo $this->Form->create('Page');

		echo $this->Form->input('make', array(
			'options' => $makes,
			'empty' => 'Make',
			'label' => '',
			'selected' => (empty($make_selected)?null:$make_selected),
		));

		if (isset($years)) {
			echo '<br />';

			echo $this->Form->input('year', array(
				'options' => $years,
				'empty' => 'Year',
				'label' => '',
				'selected' => (empty($year_selected)?null:$year_selected),
			));
		}

		if (isset($models)) {
			echo '<br />';

			echo $this->Form->input('model', array(
				'options' => $models,
				'empty' => 'Model',
				'label' => '',
				'selected' => (empty($model_selected)?null:$model_selected),
			));
		}

		if (isset($years) || isset($models)) {
			echo '<br /><button id="clearform">Clear</button>';
		}
	?>
</div>

<h3>Latest entries</h3>

<table class="table bulletins table-striped table-condensed table-hover table-bordered tablesorter">
	<thead>
		<tr>
			<th class="bul_no">Bulletin No.</th>
			<th class="bul_date">Bulletin Date</th>
			<th class="year">Year</th>
			<th class="make">Make</th>
			<th class="model">Model</th>
			<th class="component">Component</th>
			<th class="summary">Summary</th>
		</tr>
	</thead>
	<tbody>
	<?php
		if (isset($bulletins) && count($bulletins) > 0) {
			foreach ($bulletins as $bulletin) { ?>
				<tr>
					<td><?php echo $bulletin['Bulletin']['BUL_NO']; ?></td>
					<td><?php echo date('m/d/y', strtotime($bulletin['Bulletin']['BUL_DATE'])); ?></td>
					<td><?php echo $bulletin['Bulletin']['YEAR']; ?></td>
					<td><?php echo $bulletin['Bulletin']['MAKE']; ?></td>
					<td><?php echo $bulletin['Bulletin']['MODEL']; ?></td>
					<td><?php echo $bulletin['Bulletin']['COMPONENT']; ?></td>
					<td><?php echo $bulletin['Bulletin']['SUMMARY']; ?></td>
				</tr>
			<?php } 
		} else { ?>
			<tr>
				<td colspan="7" style="font-weight:bold; text-align:center;">
					No Bulletins
				</td>
			</tr>
		<?php } ?>
	</tbody>
</table>

<script>
	$(document).ready(function() {
		//alert('Test');
		$('table').tablesorter();

		$('#PageMake').change(function() {
			$('#PageYear').val('');
			$('#PageModel').val('');
			$('#PageDisplayForm').submit();
		});

		$('#PageYear').change(function() {
			$('#PageModel').val('');
			$('#PageDisplayForm').submit();
		});

		$('#PageModel').change(function() {
			$('#PageDisplayForm').submit();
		});

		$('#clearform').click(function() {
			$('#PageMake').val('');
		});

	});
</script>

<style>

	.filter {
		margin-left:10px;
		display:inline;
	}

	table.bulletins {
		width: 100%;
	}

	th.bul_no {
		width:110px;
	}

	th.bul_date {
		width:120px;
	}

	th.year {
		width:60px;
	}

	th.model, th.make {
		width: 70px;
	}

	th.summary, th.component {
		text-align: center;
	}
</style>