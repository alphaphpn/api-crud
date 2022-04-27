<!DOCTYPE html>
<html>
<head>
	<title>PHP API CRUD</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="assets/fontawesome/releases/v5.7.0/css/all.css">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">
	<style>
		#listRecView .btn-sm {
			padding: .25rem!important;
		}

		.dataTables_wrapper input, 
		.dataTables_wrapper select {
			background-color: #fff!important;
		}

		#listRecView tfoot tr td input, 
		#listRecView select {
			width: 100%;
		}
		#listRecView tfoot tr td.remove-dropdown select, 
		#listRecView tfoot tr td.remove-dropdown input, 
		#listRecView thead tr th.remove-dropdown select, 
		#listRecView thead tr th.remove-dropdown input {
			display: none;
		}

		.tbl-td-min-width {
			min-width: 320px;
		}

		@media only screen and (max-width: 1440px) {
			.table-responsive-sm {
				display: block;
				width: 100%;
				overflow-x: auto;
				webkit-overflow-scrolling: touch;
			}
		}
	</style>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.slim.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
	<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>
</head>
<body>
	<div class="container-fluid p-5 bg-primary text-white text-center">
		<h1>My First PHP API CRUD Bootstrap Page</h1>
		<p>Resize this responsive page to see the effect!</p> 
	</div>

	<div class="container my-5">
		<div class="d-flex">
			<h4 class="mr-2 mb-2">CRUD DataTable</h4>
			<a href="#" class="btn btn-outline-info btn-sm mx-2 mb-2">Add New</a>
		</div>

		<div id="" class="table-responsive">
			<table id="listRecView" class="table table-striped table-hover">
				<thead>
					<tr>
						<th>No.</th>
						<th>Fieldtext</th>
						<th>Status</th>
						<th>Modified</th>
						<th>Created</th>
						<th>Ctrl#</th>
						<th class="text-right">Action</th>
					</tr>
				</thead>

				<tbody>
					<?php
						$tblname = "tblcrud";
						$prim_id = "id";
						$cnn = new PDO("mysql:host=localhost;dbname=alphaphpndb", 'root', '');
						$qry = "SELECT * FROM {$tblname} WHERE deletedx=0 ORDER BY {$prim_id} DESC";
						$stmt = $cnn->prepare($qry);
						$stmt->execute();
						$xno = 0;

						for($i=0; $row = $stmt->fetch(); $i++) {
							$xno++;
							$id2=$row['id'];
							$id=sprintf('%04d',$id2);
							$fieldtxt=$row['fieldtxt'];
							$status=$row['status'];
							$modified2=$row['modified'];
							$modified=date_format(new DateTime($modified2),'Y/m/d');
							$created2=$row['created'];
							$created=date_format(new DateTime($created2),'Y/m/d');
					?>

							<tr>
								<td><?php echo $xno; ?></td>
								<td data-filter="<?php echo $fieldtxt; ?>"><?php echo $fieldtxt; ?></td>
								<td data-filter="<?php echo $status; ?>"><?php echo $status; ?></td>
								<td data-filter="<?php echo $modified; ?>"><?php echo $modified; ?></td>
								<td data-filter="<?php echo $created; ?>"><?php echo $created; ?></td>
								<td><?php echo $id; ?></td>
								<td class="text-right tbl-action">
									<a href="#?id=<?php echo $id; ?>" class="btn-sm btn-success btn-inline" title="Edit">
										<span class="far fa-edit"></span>
									</a>
									<a class="btn-sm btn-dark btn-inline ml-1" href="#" onclick="trash(<?php echo $id2; ?>)" title="Delete">
										<span class="fas fa-trash-alt"></span>
									</a>
								</td>
							</tr>
					<?php
						}
					?>
				</tbody>

				<tfoot>
					<tr>
						<td class="remove-dropdown"></td>
						<td>Fieldtext</td>
						<td>Status</td>
						<td class="remove-dropdown">Modified</td>
						<td class="remove-dropdown">Created</td>
						<td class="remove-dropdown">Ctrl#</td>
						<td class="remove-dropdown"></td>
					</tr>
				</tfoot>

			</table>
		</div>
	</div>

	<script type="text/javascript">
		$(document).ready( function () {
			$('#listRecView').DataTable( {
				initComplete: function () {
					this.api().columns().every( function () {

						/** Filter Group for each column Start **/
						var column = this;
						var select = $('<select><option value=""></option></select>')
						.appendTo( $(column.footer()).empty() )
						.on( 'change', function () {
							var val = $.fn.dataTable.util.escapeRegex(
							$(this).val()
						);

						column
							.search( val ? '^'+val+'$' : '', true, false )
							.draw();
						});

						column.data().unique().sort().each( function ( d, j ) {
							select.append( '<option value="'+d+'">'+d+'</option>' )
						});
						/** Filter Group for each column End **/

						/** Search for each column Start **/
						// var that = this;
						// var input = $('<input type="text" placeholder="Search" />')
						// .appendTo($(this.footer()).empty())

						// .on('keyup change', function() {
						// 	if (that.search() !== this.value) {
						// 		that
						// 		.search(this.value)
						// 		.draw();
						// 	}
						// });
						/** Search for each column End **/

					});
				}
			} );
		});	

		function trash(id) {
			var answer = confirm('Delete record Ctrl#'+id+' ?');
			if (answer) {
				window.location = '#?upidid=' + id;
			} 
		}
	</script>
</body>
</html>