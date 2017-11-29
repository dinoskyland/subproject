
$(function() {
	var level = $("#level").text();
	var options;

	var table = $('#yourOrderTable').DataTable( {
    	//"searching": false,
    	"autoWidth": false,
    	"order": [[0, "desc" ]],
    	"processing": true,
    	"serverSide": true,
    	"responsive": true,
    	"ajax":{
            url :"yourorder2.php", // json datasource
            type: "post"  // method  , by default get
        },
        "columns": [
        { "data": "order_no" },
        { "data": "site_name" },
        { "data": "request_date" },
        { "data": "requester" },
        { "data": "desired_date" },
        { "data": "order_sum" },
        { "data": "expired_date" }, //6
        { "data": "senddate" }, //7
        { "data": "received_date" },
        { "data": "status" } //9
        ],
        "columnDefs": [ 
        {
        	"targets": 5,
        	"orderable": false,
			"render": function ( data, type, row, meta ) {
				return "<button type='button' class='btn btn-default button-ordersum' data-toggle='modal' data-target='#myModalOrderSum' id='"+row['order_no']+"'>"+data+"</button>";
			}
        },
        {
        	"targets": 6,
        	"render": function ( data, type, row, meta ) {
        		return data;
        	}
        },
        {
        	"targets": 7,
        	"render": function ( data, type, row, meta ) {
        		if (level == 'Manager') {
        			return row['status'] == 'requested' ? "<button type='button' class='btn btn-info button-set' data-toggle='modal' data-target='#myModal' id='"+row['order_no']+"' name='"+row['order_sum']+"'>Set</button>" : data;
		    	} else { //user
		    		return data;
		    	}
		    }
		},
		{
			"targets": 8,
			"render": function ( data, type, row, meta ) {
				return row['status'] == 'shipped' ? "<button type='button' class='btn btn-success button-received' id='"+row['order_no']+"'>Received</button>" : data;
			}
		},
		{
			"targets": 9,
			"render": function ( data, type, row, meta ) {
				return row['status'] == 'canceled' ? "<button type='button' class='btn btn-danger'>canceled</button>" : "<button type='button' class='btn btn-default button-status' id='"+row['order_no']+"'>"+data+"</button>";
			}
		}
		]
	});

	$('#myModal').modal({
		show: false,
		backdrop: 'static'
	});

    //Date picker
    $('#datepicker').datepicker({
    	language: 'kr',
    	format: 'yyyy-mm-dd',
    	autoclose: true
    });

    var d = new Date();
	d.setDate(d.getDate() + 14);
	$("#datepicker").datepicker("setDate", d);

    $('#myModal').on('show.bs.modal', function (e) {
		$('#expiration').datepicker({
			language: 'kr',
			format: 'yyyy-mm-dd',
			autoclose: true
		});

 	});

	var order_no; //modal title from button-set, used in #delivered
	var order_sum; // from button-set, used in #delivered
	$('#yourOrderTable tbody').on("click", ".button-set", function(){
		order_no = $(this).prop('id');
		order_sum = $(this).prop('name');
		console.log('order_sum'+order_sum);

		$("#deliverytable > tbody").remove();
		$.getJSON( "order_no_kitname.php", {order_no: order_no}, function(data) {
			var items = [];
/*			items.push( "<tr>" );
			items.push( "<td class='kitname'>Expiration Date</td>" );
			items.push( "<td><input type='text' class='form-control pull-right' id='expiration'></td>" );
			items.push( "</tr>" );
*/			$.each( data, function( key, val ) {
				items.push( "<tr>" );
				items.push( "<td class='kitname'>"+data[key].kit_name+"</td>" );
				items.push( "<td><input type='text' id='"+data[key].id+"' class='form-control'></td>" );
				items.push( "</tr>" );
			});

			$( "<tbody />", {
				"class": "my-new-list",
				html: items.join( "" )
			}).appendTo( "#deliverytable" );
			console.log('tbody '+ items);
		}).done(function() {
			console.log( "success" + order_no );
			var modal = $("#myModal");
			modal.find('#delivery_order_no').text(order_no);
		}).fail(function() {
			console.log(data);
		});
	});

	$('#yourOrderTable tbody').on("click", ".button-received", function(){
		order_no = $(this).prop('id');
		console.log('button-received id '+order_no);
		$.post( "received.php", {order_no: order_no}, function(data) {
    		// if (data==order_no) {
	    	//alert("수신 처리 되었습니다");	    			
    		// }
    		table.ajax.reload(null, false);
    	})
		.fail(function() {
			alert( "error" );
		}); // end ajax call			
	});

	$(document).on("click", ".button-ordersum", function(){
		order_no = $(this).prop('id');

		$("#orderSumTable > tbody").remove();
		$.getJSON( "order_no_kitname.php", {order_no: order_no}, function(data) {
			var items = [];
/*			items.push( "<tr>" );
			items.push( "<th>Visit Name/Material</th>" );
			items.push( "<th>Quantity</th>" );
			items.push( "</tr>" );
*/			$.each( data, function( key, val ) {
				items.push( "<tr>" );
				items.push( "<td>"+data[key].kit_name+"</td>" );
				items.push( "<td>"+data[key].reqest_qty+"</td>" );
				items.push( "</tr>" );
			});

			$( "<tbody />", {
				"class": "my-new-list",
				html: items.join( "" )
			}).appendTo( "#orderSumTable" );
			console.log('tbody '+ items);
		}).done(function() {
			console.log( "success" + order_no );
			var modal = $("#myModalOrderSum");
			modal.find('#orderSumTitle').text(order_no);
		}).fail(function() {
			console.log(data);
		});
	});

	//save button from modal
	$("#delivered").click(function(){
		var expiration = $('#deliverytable').find("input.form-control").val();
		console.log('expiration '+expiration);

		if (expiration == '') {
			alert("Expiration Date을 입력해주세요");
			return;
		}
		
		var total=0;
		$('#myModal').modal('hide');
		$('#deliverytable > tbody  > tr').each(function() {
			$this = $(this);
			var kitname = $this.find(".kitname").text();
			var quantity = $this.find("input.form-control").val();
			var id = $this.find("input.form-control").prop('id');
			var pattern_num = /^([0-9]|[0-9][0-9]|[0-9][0-9][0-9])$/;

			if (quantity.length == 0) {
				//blank
			} else if (quantity.match(pattern_num)) {
				total += Number(quantity);		
				console.log('total '+total);

				$.post( "delivered.php", {
					order_no:order_no, 
					id:id,
					quantity:quantity
				}, function(data) {
					//console.log("delivered");
					//alert( data );
				})
				.fail(function() {
					alert(data);
				}); // end ajax call				

			} else {
				alert("Quantity: 숫자만 입력가능합니다(1~999)\n입력불가: "+kitname);

			}					
		});

		console.log('order_sum-total '+order_sum-total);
		//if total is 0, exit
		if (total) {
			order_sum=order_sum-total;					
			if (order_sum<0) {
				order_sum=0;
			}
			$.post( "delivered_sum.php", {
				order_no:order_no, 
				order_sum:order_sum,
				expiration:expiration
			}, function(data) {
				//console.log("delivered");
				//alert( data );
			})
			.fail(function() {
				alert(data);
			}); // end ajax call			
			table.ajax.reload(null, false);
		} 
		//subtract total(kits sent) from order_sum from csm04_KIT_order;_
	});



	$("#order").click(function(){
		var protocol = $("#protocol").val();
		var site = $("#site").val();
		var protocolname = $("#protocolname").text();
		var address = $("#address").val();
		var phone = $("#phone").val();
		var requester = $("#requester").val();
		var datepicker = $("#datepicker").val();
		var pattern = /^[ㄱ-ㅎㅏ-ㅣ가-힣\s\w-()]+$/;

		if (protocol.length == 0){
			alert("안건코드를 선택해주세요");
		} else if (site.length == 0){
			alert("Site를 선택해주세요");
		} else if (address.length == 0){
			alert("배송주소를 입력해주세요");
		} else if (phone.length == 0){
			alert("전화번호를 입력해주세요");
		} else if (requester.length == 0){
			alert("요청자를 입력하세요");
		} else if (datepicker.length == 0){
			alert("수령희망일을 입력하세요");
		} else if (!address.match(pattern)){
			alert("배송주소: 문자,순자,(),_,-만 가능합니다");
		} else if (!phone.match(pattern)){
			alert("전화번호: 순자,(),_,-만 가능합니다");
		} else if (!requester.match(pattern)){
			alert("요청자: 문자,순자,(),_,-만 가능합니다");
		} else {
			$.post( "order_no.php" , function(data){
				var ordersummary = kitorderdetail(data);			
				kitordermaster(data, ordersummary);				
			})
			.done(function() {
				table.ajax.reload();
				// $('#yourOrder').text($("#yourOrder").text()+'(Order Submitted...)')
				// setTimeout(function(){ $('#yourOrder').text('Order List')}, 3000);
				$(".kitquantity").val(''); //empty Qunatity
			})
			.fail(function() {
				alert(data);
			});
		}
		

		function kitorderdetail(order_no) {
			var total=0;
			$('#kittable > tbody  > tr').each(function() {
				$this = $(this);
				var id = $this.find("span.kitname").prop('id');
				var kitname = $this.find("span.kitname").text();
				var quantity = $this.find("input.kitquantity").val();
				var pattern_num = /^([0-9]|[0-9][0-9]|[0-9][0-9][0-9])$/;

				if (quantity.length == 0) {
					//blank
				} else if (quantity.match(pattern_num)) {
					total += Number(quantity);		
					console.log('total '+total);
					$.post( "kitorderdetail.php", {
						order_no:order_no, 
						id:id, 
						kitname:kitname, 
						quantity:quantity, 
						requester:requester, 
						datepicker:datepicker
					}, function(data) {
						console.log("kitorderdetail");
						//alert( data );
					})
					.fail(function() {
						alert(data);
					}); // end ajax call				
				} else {
					alert("Quantity: 숫자만 입력가능합니다(1~999)\n입력불가: "+kitname);
				}
				
				//alert( quantity);
			});
			return total;
		}

		function kitordermaster(order_no, ordersummary) {
			//if total of kit orders > 0
			if (ordersummary > 0) {
				$.post( "kitordermaster.php", {
					order_no: order_no, 
					protocol: protocol,
					protocolname: protocolname,
					site: site,
					address: address,
					phone: phone,
					requester: requester,
					datepicker: datepicker,
					ordersummary: ordersummary}, function(data) {
						console.log("kitordermaster");
					// var json = $.parseJSON(data);
		   			//alert(json.result[0].pl_protocol_name);
					//alert(data);
				})
				.fail(function() {
					alert(data);
				}); // end ajax call   	
			}
		}
	});	




	var statusOriginal; //status when mouse on button
	$('#yourOrderTable tbody').on("mouseenter", ".button-status", function(){
		statusOriginal = $(this).text();
		if (statusOriginal == 'requested') {
			$(this).removeClass("btn-default");		
			$(this).addClass("btn-danger");		
			$(this).text('canceled');		
		}
	});

	$('#yourOrderTable tbody').on("mouseleave", ".button-status", function(){
		if (statusOriginal == 'requested') {
			$(this).removeClass("btn-danger");		
			$(this).addClass("btn-default");		
			$(this).text('requested');		
		}
	});

	$('#yourOrderTable tbody').on("click", ".button-status", function(){
		if (statusOriginal == 'requested') {
			order_no = $(this).prop('id');
			$.post( "cancel.php", {order_no: order_no}, function(data) {
	    		// if (data==order_no) {
		    	//alert("삭제처리 되었습니다");
	    		// }
				//window.location.href = $("#kitorder").prop('href');
			})
			.fail(function() {
				alert( "error" );
			}); // end ajax call
			statusOriginal = 'canceled';
			table.ajax.reload(null, false);
		}
	});


	$('#protocol').append(function() {
		$.ajaxSetup({async:false});//execute synchronously
		var protocolSelect;

		if (level == 'Manager') {
			$.post( "protocolselect2.php")
			.done(function(data) {
			   	protocolSelect = data;
			})
			.fail(function() {
				console.log(data);
			});					
			table.ajax.reload();					
		} else { //user
			$.getJSON( "requester.php" )
			.done(function(data) {
				$('#protocolname').text(data[1].protocolname);
				protocolSelect = "<option selected='selected'>"+data[0].protocol+"</option>";
				$('#site').append("<option selected='selected'>"+data[2].site+"</option>");
				$('#requester').val(data[3].person);
				$('#phone').val(data[4].phone);
				$('#address').val(data[5].address);
				$('#protocolFormGroup').toggle();
			})
			.fail(function() {
				console.log(data);
			});	
		}		
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
			$('#site > option').remove();
			$("#site").selectpicker('refresh');	
			$('#requester').val('');
			$('#protocolname').text('');
 			table.ajax.reload();
 		} else {
			$('#protocolname').text(protocolname);
			$.post( "site.php", {protocol: protocol, protocolname: protocolname}, function(data) {
				$('#site > option').remove();
				$('#site').append(data);
				$("#site").selectpicker('refresh');	
			})
			.fail(function(data) {
				alert( data );
			});  			
 		}

		$('#address').val('');
		$('#phone').val('');
		$('#datepicker').val('');
		kittable.ajax.reload();
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

		$.getJSON( "requestFromManager.php" )
		.done(function(data) {
			//$('#requester').val(data[0].person);
			$('#requester').val(data[1].manager);
			$('#phone').val(data[0].phone);
			$('#address').val(data[0].address);
			$('#datepicker').val('');
		})
		.fail(function() {
			console.log(data);
		});	
	});

	var kittable = $('#kittable').DataTable( {
		"paging": false,
		"lengthChange": false,
		"searching": false,
		"ordering": false,
		"info": false,
		"autoWidth": false,
		"processing": true,
		"serverSide": true,
		"responsive": true,
		"ajax":{
            url :"kitlist2.php", // json datasource
            type: "post"  // method  , by default get
        },
        "columns": [
        { "data": "id" },
        { "data": null }
        ],
        "columnDefs": [ 
        {
        	"targets": 0,
        	"render": function ( data, type, row, meta ) {
        		return "<span class='kitname' id='"+row["id"]+"'>"+row["kit_name"]+"</span>";
        	}
        },
        {
        	"targets": 1,
        	"render": function ( data, type, row, meta ) {
        		return "<input type='text' class='form-control kitquantity'>";
        	}
        }
        ]
    });


});

