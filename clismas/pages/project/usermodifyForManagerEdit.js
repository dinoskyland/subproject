// Bind to the submit event of our form
$(function() {
	var level = 'Manager';
	var prevProtocol;
	var prevSite;

    //phone number
    $("[data-mask]").inputmask();

	$.getJSON( "userInfoForManager.php", function(data) {
		$.ajaxSetup({async:false});//execute synchronously
		$('#userid').val(data[0].user_ID);
		prevProtocol = data[0].protocol_cd;
		prevSite = data[0].site_name;
		$('#protocolname').text(data[0].protocol_name);
		$('#person').val(data[0].user_name);
		$('#phone').val(data[0].user_contact);
		$('#email').val(data[0].user_email);
		$('#address').val(data[0].user_address);
		$('#pickupLoc').val(data[0].desig_locaiton);
		$('#pickupTime').val(data[0].desig_time);
		data[0].check_lab1 == 't' ? $('#lab1').iCheck('check') : $('#lab1').iCheck('uncheck');
		data[0].check_lab2 == 't' ? $('#lab2').iCheck('check') : $('#lab2').iCheck('uncheck');
		data[0].check_pick1 == 't' ? $('#pick1').iCheck('check') : $('#pick1').iCheck('uncheck');
		data[0].check_pick2 == 't' ? $('#pick2').iCheck('check') : $('#pick2').iCheck('uncheck');
		data[0].check_kit1 == 't' ? $('#kit1').iCheck('check') : $('#kit1').iCheck('uncheck');
		data[0].check_kit2 == 't' ? $('#kit2').iCheck('check') : $('#kit2').iCheck('uncheck');
	}).done(function() {
   		$.post( "protocolselect3.php", {prevProtocol: prevProtocol}, function(data) {
   			$('#protocol > option').remove();
			$('#protocol').append(data);
			$("#protocol").selectpicker('refresh');	
    	})
    	.fail(function() {
			alert( data );
		}); 
   		$.post( "site3.php", {prevProtocol: prevProtocol, prevSite: prevSite}, function(data) {
   			$('#site > option').remove();
			$('#site').append(data);
			$("#site").selectpicker('refresh');	
    	})
    	.fail(function() {
			alert( data );
		}); 
	}).fail(function(data) {
		console.log(data);
	});

    $("#submit").click(function(){ 		
		var protocol = $("#protocol").val();
		var protocolname = $("#protocolname").text();
		var userid = $("#userid").text();
		var password = $("#password").val();
		var site = $("#site").val();
		var person = $("#person").val();
		var phone = $("#phone").val();
		var email = $("#email").val();
		var address = $("#address").val();
		var pickupLoc = $("#pickupLoc").val();
		var pickupTime = $("#pickupTime").val();
		var lab1 = $("#lab1").prop('checked');
		var lab2 = $("#lab2").prop('checked');
		var pick1 = $("#pick1").prop('checked');
		var pick2 = $("#pick2").prop('checked');
		var kit1 = $("#kit1").prop('checked');
		var kit2 = $("#kit2").prop('checked');


		var userid = $("#userid").val();
 		if (userid.length == 0){
			alert('user id를 입력해주세요'); 	
			return;		
 		}
 		
		var person = $("#person").val();
		var phone = $("#phone").val();
		var email = $("#email").val();
		var address = $("#address").val();
		var lab1 = $("#lab1").prop('checked');
		var lab2 = $("#lab2").prop('checked');
		var pick1 = $("#pick1").prop('checked');
		var pick2 = $("#pick2").prop('checked');
		var kit1 = $("#kit1").prop('checked');
		var kit2 = $("#kit2").prop('checked');

		var confirm = $("#confirm").val();
		var pattern = /^[0-9a-zA-Z]{1,10}$/;
		var pattern_loose = /^[ㄱ-ㅎㅏ-ㅣ가-힣\s\w-().:~]+$/;
		var pattern_email = /^[@.\s\w-()]+$/;

		if (protocol.length == 0) {
			alert("안건코드를 입력하세요");
		} else if (site.length == 0) {
			alert("Site를 입력하세요");
		} else if (password.length == 0) {
			alert("패스워드를 입력하세요");
		} else if (confirm.length == 0) {
			alert("패스워드확인을 입력하세요");
		} else if (person.length == 0) {
			alert("담당자명을 입력하세요");
		} else if (phone.length == 0) {
			alert("연락처를 입력하세요");
		} else if (email.length == 0) {
			alert("이메일을 입력하세요");
		} else if (address.length == 0) {
			alert("주소를 입력하세요");
		} else if (!password.match(pattern)) {
			alert("비밀번호는 1~10자리, 문자, 순자만 가능합니다");
		} else if (!person.match(pattern_loose) && person.length!=0) {
			alert("담당자명은 문자, 순자, (), -, _ 만 가능합니다");
		} else if (!email.match(pattern_email) && email.length!=0) {
			alert("이메일은 문자, 순자, @, . 만 가능합니다");
		} else if (!address.match(pattern_loose) && address.length!=0) {
			alert("주소는 문자, 순자, (), -, _, : 만 가능합니다");
		} else if (!pickupLoc.match(pattern_loose) && address.length!=0) {
			alert("Pickup Location은 문자, 순자, ()-_:~ 만 가능합니다");
		} else if (!pickupTime.match(pattern_loose) && address.length!=0) {
			alert("Pickup Time은 문자, 순자, ()-_:~ 만 가능합니다");
		} else if (password != confirm) {
			alert("패스워드가 일치하지 않습니다");
		} else {
			$.post("usermodified.php", {
				userid: userid,
				person: person,
				phone: phone,
				email: email,
				address: address,
				lab1: lab1,
				lab2: lab2,
				pick1: pick1,
				pick2: pick2,
				kit1: kit1,
				kit2: kit2
			}, function(data) {
				alert('수정되었습니다');
				console.log('수정되었습니다');
				//location.reload();
			})
			.fail(function() {
				alert("error" );
			}); // end ajax call   		
		}			
	});

    $("#userdelete").click(function(){
 		
/*		if ($('#pickup').is(':checked')) {
			var staffid = $("#staffid").val();
	 		if (staffid.length == 0){
				alert('staff id를 선택해주세요'); 	
				return;		
	 		}
	    	$.post("staffdelete.php", {staffid:staffid}, function(data) {
	    		alert(data);
	    		window.location.href = "usermodify.php";
	    	})
	    	.fail(function() {
				//alert( "안건코드 입력확인" );
				alert(data);
			}); // end ajax call   		
		} else { //user or manager
			
		}
*/		var userid = $("#userid").val();
 		if (userid.length == 0){
			alert('user id를 선택해주세요'); 	
			return;		
 		}
    	$.post("userdelete.php", {
    		userid: userid
    	}, function(data) {
    		alert(data);
    		window.location.href = "usermodify.php";
    	})
    	.fail(function() {
			//alert( "안건코드 입력확인" );
			alert(data);
		}); // end ajax call   		
    });


	$('#protocol').change(function() {
		$.ajaxSetup({async:false});//execute synchronously
		var protocol = $("#protocol").val();
		var protocolname = $(this).children(":selected").prop("id");

 		if (protocolname == 'all') {
 			alert('all은 지정할수 없습니다. 다시 지정해 주세요.')
			$('#site > option').remove();
			$("#site").selectpicker('refresh');	
			$('#protocolname').text('');
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
	});


/*    $('#userid').append(function() {
		$.ajaxSetup({async:false});//execute synchronously
		var userSelect;

		$.post( "userselect2.php", function(data) {
			userSelect = data;
		})
		.fail(function() {
			alert( "error" );
		});					
		if (level == 'User') {
			var userId = $(".hidden-xs").text();

			$.post( "userInfo.php", {userid: userId}, function(data) {
				$('#person').val(data[0].user_name);
				$('#phone').val(data[0].user_contact);
				$('#email').val(data[0].user_email);
				$('#address').val(data[0].user_address);
				$('#pickupLoc').val(data[0].desig_locaiton);
				$('#pickupTime').val(data[0].desig_time);
			},'json')
			.fail(function(data) {
				alert(data);
			}); 
		}
		return userSelect;			
	});
*/
/*    $('#staffid').append(function() {
		$.ajaxSetup({async:false});//execute synchronously
		var staffSelect;

		$.post( "staffselect.php", function(data) {
			staffSelect = data;
		})
		.fail(function() {
			alert( "error" );
		});					
		if (level == 'Pickup Staff') {
			var staffId = $(".hidden-xs").text();

			$.post( "staffInfo.php", {staffid: staffId}, function(data) {
				$('#person').val(data[0].manager_name);
				$('#phone').val(data[0].mobile);
				var optionStaffRole;
				data[0].role == '주담당자' ? optionStaffRole="<option selected='selected'>주담당자</option>" : optionStaffRole="<option>주담당자</option>";
				data[0].role == '부담당자' ? optionStaffRole+="<option selected='selected'>부담당자</option>" : optionStaffRole+="<option >부담당자</option>";
				$('#staffrole > option').remove();
				$('#staffrole').append(optionStaffRole);
				$("#staffrole").selectpicker('refresh');	

			},'json')
			.fail(function() {
				alert( "error" );
			}); 
		}
		return staffSelect;			
	});
*/
/*    $('#userid').change(function() {
		$.ajaxSetup({async:false});//execute synchronously
		var userid = $(this).val();
		var manager = $(this).children(":selected").prop("id");
		console.log('manager '+manager);

		if (manager == 't') {
	        $('.pickup-group').hide();
	        $('.user-group').hide();
	        $('.manager-group').show();
		} else {
	        $('.pickup-group').hide();
	        $('.user-group').show();
		}

		$.post( "userInfo.php", {userid: userid}, function(data) {
			$('#protocolname').text(data[0].protocol_name);
			$('#person').val(data[0].user_name);
			$('#phone').val(data[0].user_contact);
			$('#email').val(data[0].user_email);
			$('#address').val(data[0].user_address);
			data[0].check_lab1 == 't' ? $('#lab1').iCheck('check') : $('#lab1').iCheck('uncheck');
			data[0].check_lab2 == 't' ? $('#lab2').iCheck('check') : $('#lab2').iCheck('uncheck');
			data[0].check_pick1 == 't' ? $('#pick1').iCheck('check') : $('#pick1').iCheck('uncheck');
			data[0].check_pick2 == 't' ? $('#pick2').iCheck('check') : $('#pick2').iCheck('uncheck');
			data[0].check_kit1 == 't' ? $('#kit1').iCheck('check') : $('#kit1').iCheck('uncheck');
			data[0].check_kit2 == 't' ? $('#kit2').iCheck('check') : $('#kit2').iCheck('uncheck');
		},'json')
		.fail(function() {
			alert( "error" );
		}); 
	});
*/
/*    $('#staffid').change(function() {
		$.ajaxSetup({async:false});//execute synchronously
		var staffid = $("#staffid").val();

		$.post( "staffInfo.php", {staffid: staffid}, function(data) {
			$('#person').val(data[0].manager_name);
			$('#phone').val(data[0].mobile);
			var optionStaffRole;
			data[0].role == '주담당자' ? optionStaffRole="<option selected='selected'>주담당자</option>" : optionStaffRole="<option>주담당자</option>";
			data[0].role == '부담당자' ? optionStaffRole+="<option selected='selected'>부담당자</option>" : optionStaffRole+="<option >부담당자</option>";
			$('#staffrole > option').remove();
			$('#staffrole').append(optionStaffRole);
			$("#staffrole").selectpicker('refresh');	

		},'json')
		.fail(function() {
			alert( "error" );
		}); 
		
		$.post( "hospitalselect.php", {staffid: staffid}, function(data) {
			console.log(data);
			$('#assignSite').empty();
			$('#assignSite').append(data);
			$('#assignSite').selectpicker('refresh');
		})
		.fail(function() {
			alert( data );
		}); 
	});
*/


});