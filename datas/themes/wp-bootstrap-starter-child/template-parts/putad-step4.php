<?php
global $smartwizard_required_field, $smartwizard_step1_title, $smartwizard_step2_title, $smartwizard_step3_title, $smartwizard_step4_title, $smartwizard_step4_text2;

?>
<style>
	.table.table-borderless th, .table.table-borderless td {
		border-top: 0px;
	}
	.table.table-borderless tr {
		line-height: 1em;
	}
</style>

<div class="row mt-4">
	<div class="col-md-6">
		<div class="card">
			<div class="card-header">
				<?php echo $smartwizard_step1_title; ?>
			</div>
			<div class="card-body">
				<!-- ============================ -->
				<!-- ========== STEP 1 ========== -->
				<!-- ============================ -->
				<table class="table table-borderless table-hover">
					<tbody>
						<tr>
							<td><?php _e('Firstname', EQUIPEER_ID); ?></td>
							<td id="result_putadFirstname">---</td>
						</tr>
						<tr>
							<td><?php _e('Lastname', EQUIPEER_ID); ?></td>
							<td id="result_putadLastname">---</td>
						</tr>
						<tr>
							<td><?php _e('Email', EQUIPEER_ID); ?></td>
							<td id="result_putadEmail">---</td>
						</tr>
						<tr>
							<td><?php _e('Phone', EQUIPEER_ID); ?></td>
							<td id="result_putadPhone">---</td>
						</tr>
						<tr>
							<td><?php _e('Address', EQUIPEER_ID); ?></td>
							<td id="result_putadAddress">---</td>
						</tr>
						<tr>
							<td><?php _e('I prefer to be contacted by', EQUIPEER_ID); ?></td>
							<td id="result_putadContactBy">---</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
		<div class="card mt-4">
			<div class="card-header">
				<?php echo $smartwizard_step3_title; ?>
			</div>
			<div class="card-body">
				<!-- ============================ -->
				<!-- ========== STEP 3 ========== -->
				<!-- ============================ -->
				<table class="table table-borderless table-hover">
					<tbody>
						<tr>
							<td><?php _e('Photos', EQUIPEER_ID); ?></td>
							<td id="result_putadUploadPhotos">---</td>
						</tr>
						<tr>
							<td><?php _e('Videos (upload)', EQUIPEER_ID); ?></td>
							<td id="result_putadUploadVideos">---</td>
						</tr>
						<tr>
							<td><?php _e('Videos (link)', EQUIPEER_ID); ?></td>
							<td id="result_putadLinkVideos">---</td>
						</tr>
						<tr>
							<td><?php _e('Document', EQUIPEER_ID); ?></td>
							<td id="result_putadUploadDocument">---</td>
						</tr>
						<tr>
							<td><?php _e('Date of veterinary report', EQUIPEER_ID); ?></td>
							<td id="result_putadVeterinaireDate">---</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>
	<div class="col-md-6">
		<div class="card">
			<div class="card-header">
				<?php echo $smartwizard_step2_title; ?>
			</div>
			<div class="card-body">
				<!-- ============================ -->
				<!-- ========== STEP 2 ========== -->
				<!-- ============================ -->
				<table class="table table-borderless table-hover">
					<tbody>
						<tr>
							<td><?php _e('Identification number', EQUIPEER_ID); ?></td>
							<td id="result_putadSire">---</td>
						</tr>
						<tr>
							<td><?php _e('Horse name', EQUIPEER_ID); ?></td>
							<td id="result_putadPostTitle">---</td>
						</tr>
						<tr>
							<td><?php _e('Date of Birth', EQUIPEER_ID); ?></td>
							<td id="result_putadBirthdayReal">---</td>
						</tr>
						<tr>
							<td><?php _e('Breed', EQUIPEER_ID); ?></td>
							<td id="result_putadBreed">---</td>
						</tr>
						<tr>
							<td><?php _e('Color', EQUIPEER_ID); ?></td>
							<td id="result_putadColor">---</td>
						</tr>
						<tr>
							<td><?php _e('Size', EQUIPEER_ID); ?></td>
							<td id="result_putadSize">---</td>
						</tr>
						<tr>
							<td><?php _e('Sex', EQUIPEER_ID); ?></td>
							<td id="result_putadSex">---</td>
						</tr>
						<tr>
							<td><?php _e('Discipline', EQUIPEER_ID); ?></td>
							<td id="result_putadDiscipline">---</td>
						</tr>
						<!--<tr>
							<td><?php _e('Type', EQUIPEER_ID); ?></td>
							<td id="result_putadTypeCanasson">---</td>
						</tr>-->
						<tr>
							<td><?php _e('Localization', EQUIPEER_ID); ?></td>
							<td id="result_putadLocalization">---</td>
						</tr>
						<tr>
							<td><?php _e('Strong points', EQUIPEER_ID); ?></td>
							<td id="result_putadImpression">---</td>
						</tr>
						<tr>
							<td><?php _e('Ad Type', EQUIPEER_ID); ?></td>
							<td id="result_putadTypeAnnonce">---</td>
						</tr>
						<tr>
							<td><?php _e('NET seller selling price', EQUIPEER_ID); ?></td>
							<td id="result_putadPriceReal">---</td>
						</tr>
						<tr>
							<td><?php _e('VAT', EQUIPEER_ID); ?></td>
							<td id="result_putadPriceTvaTaux">---</td>
						</tr>
						<tr>
							<td id="result_putadPriceEquipeer_title"><?php _e('Price including tax, Equipeer SPORT fees included', EQUIPEER_ID); ?></td>
							<td id="result_putadPriceEquipeer">---</td>
						</tr>
						<tr>
							<td><?php _e("Price range", EQUIPEER_ID); ?></td>
							<td id="result_putadPriceRange">---</td>
						</tr>
					</tbody>
				</table>
				<div style="height: 100px;">&nbsp;</div>
			</div>
		</div>
	</div>
</div>