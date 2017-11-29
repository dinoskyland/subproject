// Bind to the submit event of our form
$(function() {
	var level = $("#level").text();

    //phone number
    $("[data-mask]").inputmask();
    $('#userdelete').hide();

	if (level == 'User'){
        $('.pickup-group').hide();
        $('.user-group').show();	

		$.post( "userInfo.php", function(data) {
			$('#userid').text(data[0].user_ID);
			$("#password").val('');
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

	} else { //staff
        $('.user-group').hide();
        $('.pickup-group').show();	

		$.post( "staffInfo.php", function(data) {
		    console.log('data  '+data)
			$('#staffid').text(data[0].user_ID);
			$("#password").val('');
			$('#person').val(data[0].manager_name);
			$('#phone').val(data[0].mobile);
			var optionStaffRole;
			data[0].role == '주담당자' ? optionStaffRole="<option selected='selected'>주담당자</option>" : optionStaffRole="<option>주담당자</option>";
			data[0].role == '부담당자' ? optionStaffRole+="<option selected='selected'>부담당자</option>" : optionStaffRole+="<option >부담당자</option>";
	   		$.post( "siteForStaff.php", function(data) {
	   			$('#site').html(data);	
	    	})
	    	.fail(function() {
				alert( data );
			}); 
		},'json')
		.fail(function() {
			alert( "error" );
		}); 
	}

    $("#submit").click(function(){ 		

		if (level == 'Pickup Staff') {
			//pickup staff
			console.log( 'staffid'+staffid );

			var person = $("#person").val();
			var phone = $("#phone").val();
			var staffrole = $("#staffrole").val();
			var password = $("#password").val();
			var confirm = $("#confirm").val();

			var pattern = /^[0-9a-zA-Z]{1,10}$/;
			var pattern_loose = /^[ㄱ-ㅎㅏ-ㅣ가-힣\s\w-()]+$/;
			var pattern_email = /^[@.\s\w-()]+$/;

			if (password.length > 0 && confirm.length == 0) {
				alert("패스워드를 입력하세요");
			} else if (password.length == 0 && confirm.length > 0) {
				alert("패스워드를 입력하세요");
			} else if (password.length > 0 && !password.match(pattern)) {
				alert("비밀번호는 1~10자리, 문자, 순자만 가능합니다");
			} else if (password != confirm) {
				alert("패스워드가 일치하지 않습니다");
			} else if (!person.match(pattern_loose) && person.length!=0) {
				alert("담당자명은 문자, 순자, (), -, _ 만 가능합니다");
			} else {
				$.post("staffmodified.php", {
					password: password,
					person: person,
					phone: phone,
					staffrole: staffrole
				}, function(data) {
					alert('수정되었습니다');
					//window.location.href = "usermodify.php";
					})
				.fail(function(data) {
					//alert( "안건코드 입력확인" );
					alert(data);
				}); // end ajax call   	
			}
		} else if (level == 'User'){
			// var userid = $("#userid").val();
			// console.log( 'userId'+userid );
			var person = $("#person").val();
			var password = $("#password").val();
			var confirm = $("#confirm").val();
			var phone = $("#phone").val();
			var email = $("#email").val();
			var address = $("#address").val();
			var pickupLoc = $("#pickupLoc").val();
			var pickupTime = $("#pickupTime").val();

			var pattern = /^[0-9a-zA-Z]{1,10}$/;
			var pattern_loose = /^[ㄱ-ㅎㅏ-ㅣ가-힣\s\w-().:~]+$/;
			var pattern_email = /^[@.\s\w-()]+$/;

			if (!person.match(pattern_loose) && person.length!=0) {
				alert("담당자명은 문자, 순자, (), -, _ 만 가능합니다");
			} else if (!email.match(pattern_email) && email.length!=0) {
				alert("이메일은 문자, 순자, @, . 만 가능합니다");
			} else if (!address.match(pattern_loose) && address.length!=0) {
				alert("주소는 문자, 순자, (), -, _, . 만 가능합니다");
			} else if (!pickupLoc.match(pattern_loose) && address.length!=0) {
				alert("Pickup Location은 문자, 순자, ()-_:~ 만 가능합니다");
			} else if (!pickupTime.match(pattern_loose) && address.length!=0) {
				alert("Pickup Time은 문자, 순자, ()-_:~ 만 가능합니다");
			} else {
				$.post("usermodified.php", {
					person: person,
					phone: phone,
					email: email,
					address: address,
					pickupLoc: pickupLoc,
					pickupTime: pickupTime
				}, function(data) {
					alert('수정되었습니다');
					//location.reload();

				})
				.fail(function(data) {
					alert(data);
				}); // end ajax call   		
			}			
		}
	});

/*    $("#userdelete").click(function(){
 
		if ($('#pickup').is(':checked')) {
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
		var userid = $("#userid").val();
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
*/
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