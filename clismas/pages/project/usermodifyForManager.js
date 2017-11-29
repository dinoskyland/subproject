// Bind to the submit event of our form
$(function() {
	var table = $('#userAdminTable').DataTable( {
    	//"searching": false,
    	"autoWidth": false,
    	"order": [[0, "desc" ]],
    	"processing": true,
    	"serverSide": true,
    	"responsive": true,
    	"ajax":{
            url :"userAdmin.php", // json datasource
            type: "post"  // method  , by default get
        },
        "columns": [
        { "data": "protocol_cd" },
        { "data": "site_name" },
        { "data": "user_name" },
        { "data": "user_ID" },
        { "data": "user_email" },
        { "data": "user_contact" },
        { "data": null }, //6
        { "data": null }, //7
        { "data": null },
        { "data": null }
        ],
        "columnDefs": [ 
        {
        	"targets": 6,
        	"render": function ( data, type, row, meta ) {
        		return data;
        	}
        },
        {
        	"targets": 7,
        	"render": function ( data, type, row, meta ) {
				return "<button type='button' class='btn btn-default button-ordersum'>test</button>";
		    }
		},
		{
			"targets": 8,
			"render": function ( data, type, row, meta ) {
				return "<button type='button' class='btn btn-default button-ordersum'>test</button>";
			}
		},
		{
			"targets": 9,
			"render": function ( data, type, row, meta ) {
				return "<button type='button' class='btn btn-danger button-edit' id='"+row['user_ID']+"'>edit</button>";
			}
		}
		]
	});

	$(document).on("click", ".button-edit", function(){
		var id = $(this).prop('id');

		$.post( "useredit.php", {id:id})
		.done(function(data) {
		})
		.fail(function(data) {
			console.log(data);
		});					
	    newWindow = window.open('usermodifyForManagerEdit.php', "_self");
	});


	$('#protocol').append(function() {
		$.ajaxSetup({async:false});//execute synchronously
		var protocolSelect;

		$.post( "protocolselect2.php")
		.done(function(data) {
		   	protocolSelect = data;
		})
		.fail(function() {
			console.log(data);
		});					
		table.ajax.reload();		

		return protocolSelect;			
	});


	$('#protocol').change(function() {
		$.ajaxSetup({async:false});//execute synchronously
		var protocol = $("#protocol").val();
		var protocolname = $(this).children(":selected").prop("id");

 		if (protocolname == 'all') {
	   		$.post( "pickupsubjectlistAll.php", function(data) {
	    	})
	    	.fail(function() {
				alert( data );
			});  			
 			table.ajax.reload();
 		} else {
			$.post( "site.php", {protocol: protocol, protocolname: protocolname}, function(data) {
				$('#site > option').remove();
				$('#site').append(data);
				$("#site").selectpicker('refresh');	
			})
			.fail(function(data) {
				alert( data );
			});  			
 		}
	});

	$('#site').change(function() {
		$.ajaxSetup({async:false});//execute synchronously
		var site = $("#site").val();
		$.post( "siteselect.php", {site: site}, function(data) {
			console.log(data);
		})
		.fail(function() {
			console.log(data);
		}); 
		//kittable.ajax.reload();
		table.ajax.reload();

	});

});