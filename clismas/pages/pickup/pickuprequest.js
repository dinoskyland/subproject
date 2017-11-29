$(function() {
	var level = $("#level").text();
    console.log('level'+level);

	var table = $('#subjectListTable').DataTable( {
    	//"searching": false,
    	"autoWidth": false,
		"order": [[0, "desc" ]],
        "processing": true,
        "serverSide": true,
        "responsive": true,
        "ajax":{
            url :"pickupsubjectlist2.php", // json datasource
            type: "post"  // method  , by default get
        },
        "columns": [
        { "data": "pick_req_cd" },
        { "data": "protocol_name" },
        { "data": "site_name" },
        { "data": "requester" },
        { "data": "sbj_no" },
        { "data": "visit_name" },
        { "data": null },
        { "data": "pickup_date" }, //6
        { "data": "status" }, //7
        { "data": "change_datetime" },
        { "data": "changer" } //9
    	],
    	"columnDefs": [ 
    	{
		    "targets": 2,
		    "render": function ( data, type, row, meta ) {
		    	if (level == 'Pickup Staff') {
					return "<button type='button' " 
					+ "class='btn btn-warning locForStaff' data-toggle='modal' "
					+ "data-target='#pickupModal' id='"+row['pick_req_cd']+"'>"+data+"</button>";
		    	} else {
		    		return data;	    				    		
		    	}
		    }
		},
    	{
		    "targets": 6,
		    "orderable": false,
		    "render": function ( data, type, row, meta ) {
		    	var condition;
                row['spl_freezed_cnt'] == 1 ? condition = ' Y /' : condition = ' N /';
                row['spl_cold_cnt'] == 1 ? condition += ' Y /' : condition += ' N /';
                row['spl_room_temp_cnt'] == 1 ? condition += ' Y ' : condition += ' N ';
		    	return condition;
		    }
		},
    	{
		    "targets": 8,
		    "render": function ( data, type, row, meta ) {
		    	if (level == 'Pickup Staff') {
			    	if (row["status"] == 'requested') {
			    		return "<a href='javascript:void(0)' class='btn btn-info btn-block statusChangedForStaff' id='"+row['id']+"'>"+row["status"];	    		
			    	} else if (row["status"] == 'complete') {
			    		return "<a href='javascript:void(0)' class='btn btn-success btn-block statusChangedForStaff' id='"+row['id']+"'>"+row["status"];	    		
			    	} else {
			    		return "<a href='javascript:void(0)' class='btn btn-danger btn-block statusChangedForStaff' id='"+row['id']+"'>"+row["status"];	    		
			    	}		    		
		    	} else {
			    	if (row["status"] == 'requested') {
			    		return "<a href='javascript:void(0)' class='btn btn-info btn-block statusChangedForUser' id='"+row['id']+"' "
			    			+ "data-regidate='"+row['regidate']+"'>"+row["status"];	    		
			    	} else if (row["status"] == 'complete') {
			    		return "<a href='javascript:void(0)' class='btn btn-success btn-block statusChangedForUser' id='"+row['id']+"' "
			    			+ "data-regidate='"+row['regidate']+"'>"+row["status"];	    		
			    	} else { //canceled
			    		return "<a href='javascript:void(0)' class='btn btn-danger btn-block statusChangedForUser' id='"+row['id']+"' "
			    			+ "data-regidate='"+row['regidate']+"'>"+row["status"];	    		
			    	}		    		
		    	}
		    }
		}
		]
    });

 	if (level == 'Pickup Staff') {
		$('#top').hide();
	} 

   //Date picker
    $('#datepicker').datepicker({
    	language: 'kr',
    	format: 'yyyy-mm-dd',
    	autoclose: true
    });

    //Timepicker
    $(".timepicker").timepicker({
    	showInputs: false
    });

    $('#myModal').modal({
    	show: false,
    	backdrop: 'static'
    });

	$("#quantityTableShow").hide();

	// if visit dropdown is selected
	$(document).on('change', '.visit', function(){ 
		var $this = $(this).parent().parent().next();
		var dong = false, jang = false, shil = false;
		//console.log('this.value ', this.value);
		//console.log('td.dong ', $(this).hasClass('selectpicker'));
		//console.log('td.dong text ', $(this).parent().parent().next().text());
		if (this.value == null) {

		} else {
			$.post( "samplesFromSelect.php", {
				visitName: this.value
			}, function(data) {
				$.each(data, function(key, val) {
					if (val.ps_spl_condition == '냉동') {
						dong = true;
					} else if (val.ps_spl_condition == '냉장') {
						jang = true;
					} else if (val.ps_spl_condition == '실온') {
						shil = true;
					}
				});
				console.log('dong ', dong);
				console.log('jang ', jang);
				console.log('shil ', shil);	
				dong ? $this.text('Y') : $this.text('');
				jang ? $this.next().text('Y') : $this.next().text('');
				shil ? $this.next().next().text('Y') : $this.next().next().text('');
				//console.log('samples ', data[0].ps_spl_condition);
				// $(this).find("td.shil").val() = data[2].ps_spl_condition;
			},'json')
			.fail(function(data) {
				console.log(data);
			});
		}
	});

	$(document).on('click', '#submitRequest', function(){ 
		$.ajaxSetup({async:false});//execute synchronously
		var pickup_no = '';
		var isRequestSaved = 0;

		var quantity = $("#quantity").val();
		var pattern_num = /^([0-9]|[0-9][0-9]|[0-9][0-9][0-9])$/;

		if (quantity.length == 0) {
    		alert("Quantity = 0\n요청불가");
		} else if (quantity.match(pattern_num)) {
			$('#quantityTable2 > tbody  > tr').each(function() {
				$this = $(this);
				//var counter = $this.find("#counter").text();
				var subject = $this.find("select.subject").val();
				var subjectCode = $this.find("select.subject").prop('id');
				console.log('subject '+subject);
				console.log('subjectCode '+subjectCode);
				if (subject == '') {
					subject = 'UNKNOWN';
					subjectCode = 'UNKNOWN';
				}
				var visitName = $this.find("select.visit").val();
				var dong = $this.find("td.dong").text();
				var jang = $this.find("td.jang").text();
				var shil = $this.find("td.shil").text();
				var pattern_num = /^([0-9]|[0-9][0-9]|[0-9][0-9][0-9])$/;
				var pattern = /^[ㄱ-ㅎㅏ-ㅣ가-힣\s\w-()]+$/;

				$.post( "pickup_no.php", function(data) {
					pickup_no = data;			
				})
				.fail(function() {
					alert(data);
				}); // end ajax call	

				console.log('dong '+dong);
				console.log('jang '+jang);
				console.log('shil '+shil);
				if (dong) {
					dong = 1;
				} else {
					dong = 0;
				}
				if (jang) {
					jang = 1;
				} else {
					jang = 0;
				}
				if (shil) {
					shil = 1;
				} else {
					shil = 0;
				}

				$.post( "pickupdetail.php", {
					pickup_no:pickup_no, 
					subject:subject, 
					subjectCode:subjectCode, 
					visitName:visitName,
					dong:dong, 
					jang:jang, 
					shil:shil
					}, function(data) {
					isRequestSaved = 1;
					//alert( data );
				})
				.fail(function() {
					alert(data);
				}); // end ajax call				
			});		

			if (isRequestSaved == 1) {
				var datepicker = $("#datepicker").val();
				var sendtext = $("#sendtext").val();
				// var dongCondition = $('input:radio[name=dong]:checked').val();
				var staff1name = $("#staff1").attr('name');
				var staff2name = $("#staff2").attr('name');
				var staff1phone = $("#staff1").text();
				var staff2phone = $("#staff2").text();
				var phone = $("#phone").text();
				console.log("phone "+phone);

/*				var visitTimeFrom = $("#visitTimeFrom").val();
				var visitTimeTo = $("#visitTimeTo").val();
				var visitTime = visitTimeFrom+'-'+visitTimeTo;
*/				
				var pickupTime = $("#pickupTime").val();
				var pickupLoc = $("#pickupLoc").val();
				console.log('pickupTime', pickupTime);
				console.log('pickupTime', pickupLoc);
/*				if (dongCondition == 'dongYes') {
					dongCondition = '동결검체있음';
				} else {
					dongCondition = '동결검체없음';

				}
*/				
				$.post( "pickupmaster.php", {
					pickup_no:pickup_no, 
					datepicker:datepicker, 
					// dongCondition:dongCondition, 
					staff1name:staff1name, 
					staff2name:staff2name, 
					staff1phone:staff1phone, 
					staff2phone:staff2phone, 
					phone:phone, 
					pickupTime:pickupTime, 
					pickupLoc:pickupLoc, 
					quantity:quantity,
					sendtext:sendtext
					}, function(data) {
						console.log(data);
						backToDefault();
						$("#quantityTableShow").hide();
						// $('#pickupRequestTitle').text('Request List (Request Has Been Submitted...)');
						// setTimeout(function(){ $('#pickupRequestTitle').text('Request List')}, 3000);
		    			$("#quantity").selectpicker('refresh');	
						table.ajax.reload();
				})
				.fail(function() {
					alert(data);
				}); // end ajax call		
		
			} else {
				
			}
		} else {
    		alert("Quantity: 숫자만 입력가능합니다(1~999)\n요청불가");

		}

 	});

	var pickupNumber;
	var pickupStatus;
	var pickupIdDetail;
	$(".pickupNumber").click(function(){
		pickupStatus = $(this).parent().next().next().children().text();
		pickupNumber = $(this).text();
		pickupIdDetail = $(this).prop('id');
	});
	
	//when modal for 동결, 냉장, 실온 개수 is open 
	$('#myModal').on('show.bs.modal', function (event) {
		if(pickupStatus == 'canceled') {
			e.stopPropagation();
		}  
		var res = pickupNumber.split("/");
		$("#myModalTable > tbody > tr").remove();
		tr = "<tr>";
		tr = tr + "<td>"+(res[0].split("("))[0]+"</td>";
		tr = tr + "<td>"+(res[1].split("("))[0]+"</td>";
		tr = tr + "<td>"+(res[2].split("("))[0]+"</td>";
		tr = tr + "<tr>";
		tr = tr + "<tr>";
		tr = tr + "<td><input type='text' id='pickupDong' class='form-control'></td>";
		tr = tr + "<td><input type='text' id='pickupNang' class='form-control'></td>";
		tr = tr + "<td><input type='text' id='pickupShil' class='form-control'></td>";
		tr = tr + "<tr>";
		
		$("#myModalTable > tbody").append(tr);					
	});

	//save
	$("#pickedup").click(function(){
    	$('#myModal').modal('hide');
		$this = $('#myModalTable > tbody  > tr').eq(2);
		var pickupDong = $this.find("#pickupDong").val();
		console.log(pickupDong);
		var pickupNang = $this.find("#pickupNang").val();
		console.log(pickupNang);
		var pickupShil = $this.find("#pickupShil").val();
		console.log(pickupShil);
		var pattern_num = /^([0-9]|[0-9][0-9]|[0-9][0-9][0-9])$/;
		console.log('id '+pickupIdDetail);

		if (!pickupDong.match(pattern_num) && pickupDong!='') {
			alert('동결검체수: 숫자만 입력하세요');
			//blank
		//update send_qty(kits sent) from csm04_KIT_order_detail;_
		} else if (!pickupNang.match(pattern_num) && pickupNang!='') {
			alert('냉장검체수: 숫자만 입력하세요');
			//blank
		//update send_qty(kits sent) from csm04_KIT_order_detail;_
		} else if (!pickupShil.match(pattern_num) && pickupShil!='') {
			alert('실온검체수: 숫자만 입력하세요');
			//blank
		//update send_qty(kits sent) from csm04_KIT_order_detail;_
		} else if (pickupDong=='' && pickupNang=='' && pickupShil=='') {
			alert('숫자를 입력하세요');
			//blank
		//update send_qty(kits sent) from csm04_KIT_order_detail;_
		} else {
			$.post( "pickedup.php", {
				id:pickupIdDetail,
				pickupDong:pickupDong,
				pickupNang:pickupNang,
				pickupShil:pickupShil
				}, function(data) {
				//console.log("delivered");
				//alert( data );
				window.location.href = $("#pickuprequest").prop('href');
			})
			.fail(function() {
				alert(data);
			}); // end ajax call				

		}

	});

	var statusOriginal;
	var statusChanged = false;
	$(document).on("mouseenter", ".statusChangedForUser", function(){
		statusOriginal = $(this).text();
		if (statusChanged == false) {
			if (statusOriginal == 'requested') {
			    $(this).removeClass("btn-info");		
			    $(this).addClass("btn-danger");		
			    $(this).text('canceled');		
			} else if (statusOriginal == 'canceled') { //canceled
			    $(this).removeClass("btn-danger");		
			    $(this).addClass("btn-info");		
			    $(this).text('requested');		
			}			
		}
    });

	$(document).on("mouseleave", ".statusChangedForUser", function(){
		if (statusOriginal == 'requested') {
		    $(this).removeClass("btn-danger");		
		    $(this).addClass("btn-info");		
		    $(this).text('requested');		
		} else if (statusOriginal == 'canceled') { //canceled
		    $(this).removeClass("btn-info");		
		    $(this).addClass("btn-danger");		
		    $(this).text('canceled');		
		}
		statusChanged = false;
    });

	$(document).on("click", ".statusChangedForUser", function(){
		var id = $(this).prop('id');    

		if (level == 'User') {
			//user can't change status the day pickup requested 
			var regidate = $(this).data('regidate');
			regidate = regidate.slice(0,10);

			var d = new Date();

			var month = d.getMonth()+1;
			var day = d.getDate();

			var output = d.getFullYear() + '-' +
			    (month<10 ? '0' : '') + month + '-' +
			    (day<10 ? '0' : '') + day;
			console.log(output);

			var status = $(this).text();    
			console.log('status  ' + status);

			if (regidate == output) {
				//if (status == 'canceled'){
					//when requested
					alert('Pick up 요청 당일에는 Status를 변경하지 못합니다. CROCENT 담당자에게 연락주세요. 02-2088-6277');
					$.get( "unchangeable.php" )
					.done(function(data) {
						console.log(data);
					})
					.fail(function() {
						console.log(data);
					});	

					return;					
				//} else return; //when complete or canceled
			}			
		}

		if (statusOriginal != 'complete') {
			$.post( "statusChanged.php", {
				id:id,
				statusOriginal: statusOriginal
				}, function(data) {
				//window.location.href = $("#pickuprequest").prop('href');
			})
			.fail(function(data) {
				alert(data);
			}); // end ajax call	
			if (statusOriginal == 'requested') {
				statusOriginal = 'canceled';
			} else if (statusOriginal == 'canceled'){ //canceled
				statusOriginal = 'requested';
			}
			statusChanged = true;
	    	table.ajax.reload(null, false);
		}

	});

	$(document).on("mouseenter", ".statusChangedForStaff", function(){
		statusOriginal = $(this).text();
		if (statusChanged == false) {
			if (statusOriginal == 'requested') {
			    $(this).removeClass("btn-info");		
			    $(this).addClass("btn-success");		
			    $(this).text('complete');		
			} else if (statusOriginal == 'complete') { //canceled
			    $(this).removeClass("btn-success");		
			    $(this).addClass("btn-danger");		
			    $(this).text('canceled');		
			} else if (statusOriginal == 'canceled') { //canceled
			    $(this).removeClass("btn-danger");		
			    $(this).addClass("btn-info");		
			    $(this).text('requested');		
			}
		}
    });

	$(document).on("mouseleave", ".statusChangedForStaff", function(){
		if (statusOriginal == 'requested') {
		    $(this).removeClass("btn-success");		
		    $(this).addClass("btn-info");		
		    $(this).text('requested');		
		} else if (statusOriginal == 'complete') { //canceled
		    $(this).removeClass("btn-danger");		
		    $(this).addClass("btn-success");		
		    $(this).text('complete');		
		} else if (statusOriginal == 'canceled') { //canceled
		    $(this).removeClass("btn-info");		
		    $(this).addClass("btn-danger");		
		    $(this).text('canceled');		
		}
		statusChanged = false;
    });

	$(document).on("click", ".statusChangedForStaff", function(){
		var id = $(this).prop('id');

		$.post( "statusChanged.php", {
			id:id,
			statusOriginal: statusOriginal
			}, function(data) {
			console.log('status', data );
			//window.location.href = $("#pickuprequest").prop('href');
		})
		.fail(function(data) {
			alert(data);
		}); // end ajax call	

		if (statusOriginal == 'requested') {
			statusOriginal = 'complete';
		} else if (statusOriginal == 'complete') { // 'complete'
			statusOriginal = 'canceled';
		} else if (statusOriginal == 'canceled') { // 'complete'
			statusOriginal = 'requested';
		}
		statusChanged = true;
    	table.ajax.reload(null, false);
	});

	$(document).on("click", ".locForStaff", function(){
		var id = $(this).prop('id');
		console.log('id  ', id);

		$("#pickupModalTable > tbody").remove();
		$.getJSON( "pickuplocation.php", {id: id}, function(data) {
			var items = [];
			items.push( "<tr>" );
			items.push( "<th>Pickup Location</th>" );
			items.push( "<td>"+data[0].desig_location+"</td>" );
			items.push( "</tr>" );
			items.push( "<tr>" );
			items.push( "<th>Pickup Time</th>" );
			items.push( "<td>"+data[0].desig_time+"</td>" );
			items.push( "</tr>" );
			items.push( "<tr>" );
			items.push( "<th>연구간호사</th>" );
			items.push( "<td>"+data[0].requester+"</td>" );
			items.push( "</tr>" );
			items.push( "<tr>" );
			items.push( "<th>연락처</th>" );
			items.push( "<td>"+data[0].requester_mobile+"</td>" );
			items.push( "</tr>" );
			$( "<tbody />", {
				"class": "my-new-list",
				html: items.join( "" )
			}).appendTo( "#pickupModalTable" );
			console.log(items.join(""));
		}).done(function() {
			//console.log( "success" + order_no );
		}).fail(function() {
			console.log(data);
		});
	});

	$('#quantity').append(function() {
		return _.range(1, 21).map(function(item) { 
			return "<option>"+item+"</option>"
		}).join( "" );
	});

	function backToDefault() {
		$('#quantity option').prop('selected', function() {
			console.log(this.defaultSelected);
			return this.defaultSelected;
		});
	}

    $('#quantity').change(function() {
		$.ajaxSetup({async:false});//execute synchronously

		var protocol = $('#protocol').val();
		var site = $('#site').val();
		var datepicker = $("#datepicker").val();
		var subjectList, visitList, samples;

		if (site.length == 0) {
		    alert('안건코드 search를 먼저 해주세요'); //for manager	
			backToDefault();
		} else if (datepicker.length == 0) {
			alert('Pickup Date을 입력해주세요');	
			backToDefault();
		} else {
			$.post( "subjectlist.php", function(data) {
				//console.log('subjectList ', data );
				subjectList = data;
			})
			.fail(function(data) {
				console.log(data);
			}); // end ajax call	

			$.post( "visitList.php", function(data) {
				//console.log('visitList ', data );
				visitList = data;
			})
			.fail(function(data) {
				console.log(data);
			}); // end ajax call	

			$.post( "samples.php", {
			}, function(data) {
				console.log('samples ', data );
				samples = data;
			})
			.fail(function(data) {
				console.log(data);
			}); // end ajax call				

			
			var quantity = $(this).val();
			var pattern_num = /^([0-9]|[0-9][0-9]|[0-9][0-9][0-9])$/;

			 if (quantity.match(pattern_num)) {
				$("#quantityTableShow").show();
				$("#quantityTable2 > tbody > tr").remove();
	    		$("#quantityTableDiv button").remove();
				//quantity=Number(quantity);
	    		tr='';
				console.log('match'+quantity);
	    		for (i = 0; i < quantity; i++) {
	    			tr = tr + "<tr>";
	    			//tr = tr + "<td id='counter'>"+(i+1)+"</td>";
	    			tr = tr + "<td><select class='form-control selectpicker subject'>"+subjectList+"</select></td>";
	    			tr = tr + "<td><select class='form-control selectpicker visit'>"+visitList+"</select></td>";
	    			tr = tr + samples;
	    			tr = tr + "</tr>";
	    		}

	    		$("#quantityTable2 > tbody").append(tr);	
	    		$("#quantityTable2 > tbody .subject").selectpicker('refresh');	
	    		$("#quantityTable2 > tbody .visit").selectpicker('refresh');	
	    		var finished = '<button type="button" class="btn btn-primary pull-right" id="submitRequest">Submit Request</button>';
	    		$("#quantityTableDiv").append(finished);

			} else {
				$("#quantityTableShow").hide();
				$("#quantityTable2 > tbody > tr").remove();
	    		$("#quantityTableDiv button").remove();

				alert('수량을 입력해 주세요');
			}		
			
		}

    });

	$('#protocol').append(function() {
		$.ajaxSetup({async:false});//execute synchronously
		var protocolSelect;

		if (level == 'Manager') {
	   		$.post( "protocolselect2.php", function(data) {
			   	protocolSelect = data;
	    	})
	    	.fail(function(data) {
				alert(data);
			});
			table.ajax.reload();							
		} else if (level == 'User') {
	   		$.post( "requester.php", function(data) {
				$('#protocolname').text(data[1].protocolname);
				protocolSelect = "<option selected='selected'>"+data[0].protocol+"</option>";
				$('#site').append("<option selected='selected'>"+data[2].site+"</option>");
				$('#phone').text(data[4].phone);
				$('#staff1').attr('name', data[6].manager_name);
				$('#staff1').text(data[6].mobile);
				$('#staff2').attr('name', data[7].manager_name);
				$('#staff2').text(data[7].mobile);
				data[6].mobile || data[7].mobile ? $('#staffSeperator').text('/') : $('#staffSeperator').text('');
				$('#pickupTime').val(data[8].pickupTime);
				$('#pickupLoc').val(data[9].pickupLoc);
				$('#protocolFormGroup').toggle();
	    	},'json')
	    	.fail(function(data) {
				console.log( data );
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
	    	.fail(function(data) {
				alert( data );
			});  			
			$('#site > option').remove();
			$("#site").selectpicker('refresh');	
			$('#staff1').text('');		
			$('#staff2').text('');		
			$('#staffSeperator').text('');		
			$('#phone').text('');
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

	});

    $('#site').change(function() {
		$.ajaxSetup({async:false});//execute synchronously
 		var site = $("#site").val();
   		$.post( "siteselect.php", {site: site}, function(data) {
   			console.log(data);
    	})
    	.fail(function(data) {
   			console.log(data);
		}); 
    	table.ajax.reload();

		$.getJSON( "requestFromManager.php" )
		.done(function(data) {
   			console.log('data.length '+data.length);
			$('#phone').text(data[0].phone);
			$('#pickupTime').val(data[0].pickupTime);
			$('#pickupLoc').val(data[0].pickupLoc);
			$('#staff1').attr('name', data[1].manager_name);
			$('#staff1').text(data[1].mobile);						
			$('#staff2').attr('name', data[2].manager_name);
			$('#staff2').text(data[2].mobile);
			data[1].mobile && data[2].mobile ? $('#staffSeperator').text('/') : $('#staffSeperator').text('');
		})
		.fail(function() {
			console.log(data);
		});	
	});

});
