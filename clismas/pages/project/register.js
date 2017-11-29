// Bind to the submit event of our form
$(function() {
    //iCheck for checkbox and radio inputs
    $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
    	checkboxClass: 'icheckbox_minimal-blue',
    	radioClass: 'iradio_minimal-blue'
    });

    //phone number
	$("[data-mask]").inputmask();

	$('.pickup-group').hide();

	$('#pickup').on('ifChecked', function() {
        $('#manager').iCheck('uncheck');
        $('.user-group').hide();
        $('.pickup-group').show();

		$.post( "hospitalselect.php", {staffid: null}, function(data) {
			console.log(data);
			$('#assignSite').empty();
			$('#assignSite').append(data);
			$('#assignSite').selectpicker('refresh');
		})
		.fail(function() {
			alert( data );
		}); 

    });

	$('#pickup').on('ifUnchecked', function() {
        $('.pickup-group').hide();
        $('.user-group').show();
    });

	$('#manager').on('ifChecked', function() {
        $('#pickup').iCheck('uncheck');
        $('.user-group').hide();
        $('.pickup-group').hide();
    });

	$('#manager').on('ifUnchecked', function() {
        $('.pickup-group').hide();
        $('.user-group').show();
    });

	$("#submit").click(function(){
		if ($('#pickup').is(':checked')) {
			//for pickup staff
			var userid = $("#userid").val();
			var password = $("#password").val();
			var person = $("#person").val();
			var phone = $("#phone").val();
			var role = $("#role").val();
			var site = $('#assignSite').val();

			var taken = $("#taken").prop('value');
			var confirm = $("#confirm").val();
			var pattern = /^[0-9a-zA-Z]{1,10}$/;
			var pattern_loose = /^[ㄱ-ㅎㅏ-ㅣ가-힣\s\w-()]+$/;
			//console.log('site' + site[0]);
			//var pattern = /^[0-9a-zA-Z]{6,10}+$/;

			// if ($("#lab2").prop('checked')) {
			// 	alert("Result Statistics");
			// } 

			if (site == null) {
				alert("Site를 선택하세요");
			} else if (userid.length == 0) {
				alert("아이디를 입력하세요");
			} else if (password.length == 0) {
				alert("패스워드를 입력하세요");
			} else if (confirm.length == 0) {
				alert("패스워드확인을 입력하세요");
			} else if (taken == 'taken') {
				alert("아이디 중복 확인을 해주세요");
			} else if (!userid.match(pattern)) {
				alert("User ID는 1~10자리, 문자, 순자만 가능합니다");
			} else if (!password.match(pattern)) {
				alert("비밀번호는 1~10자리, 문자, 순자만 가능합니다");
			} else if (!person.match(pattern_loose) && person.length!=0) {
				alert("담당자명은 문자, 순자, (), -, _ 만 가능합니다");
			} else if (password != confirm) {
				alert("패스워드가 일치하지 않습니다");
			} else {
				$.post("createstaff.php", {
					userid: userid,
					password: password,
					person: person,
					phone: phone,
					role: role
				}, function(data) {
					if (data == '1') {
						alert('등록되었습니다');
						$("#taken").prop('value', 'taken');
					}
				})
				.fail(function() {
					alert(data );
				}); 		

				$.post("hospitalAllocated.php", {
					userid: userid,
					site: site,
					person: person,
					phone: phone,
					staffrole: role
				}, function(data) {
					//console.log(data);
					//alert(data);
					window.location.href = "register.php";
					})
				.fail(function() {
					//alert( "안건코드 입력확인" );
					alert( data );
				});		    	
			}

		} else if ($('#manager').is(':checked')) {
			//for pickup staff
			var userid = $("#userid").val();
			var password = $("#password").val();
			var person = $("#person").val();
			var phone = $("#phone").val();
			var manager = $("#manager").prop('checked');

			var taken = $("#taken").prop('value');
			var confirm = $("#confirm").val();
			var pattern = /^[0-9a-zA-Z]{1,10}$/;
			var pattern_loose = /^[ㄱ-ㅎㅏ-ㅣ가-힣\s\w-()]+$/;
			//var pattern = /^[0-9a-zA-Z]{6,10}+$/;

			// if ($("#lab2").prop('checked')) {
			// 	alert("Result Statistics");
			// } 

			if (userid.length == 0) {
				alert("아이디를 입력하세요");
			} else if (person.length == 0) {
				alert("담당자명을 입력하세요");
			} else if (phone.length == 0) {
				alert("연락처를 입력하세요");
			} else if (password.length == 0) {
				alert("패스워드를 입력하세요");
			} else if (confirm.length == 0) {
				alert("패스워드확인을 입력하세요");
			} else if (taken == 'taken') {
				alert("아이디 중복 확인을 해주세요");
			} else if (!userid.match(pattern)) {
				alert("User ID는 1~10자리, 문자, 순자만 가능합니다");
			} else if (!password.match(pattern)) {
				alert("비밀번호는 1~10자리, 문자, 순자만 가능합니다");
			} else if (!person.match(pattern_loose) && person.length!=0) {
				alert("담당자명은 문자, 순자, (), -, _ 만 가능합니다");
			} else if (password != confirm) {
				alert("패스워드가 일치하지 않습니다");
			} else {
				$.post("createmanager.php", {
					manager: manager,
					userid: userid,
					password: password,
					person: person,
					phone: phone
				}, function(data) {
					if (data == '1') {
						alert('등록되었습니다');
						$("#taken").prop('value', 'taken');
						//window.location.href = "../login/index.php";
						window.location.href = "register.php";
						//location.reload();

					}
				})
				.fail(function() {
					//alert( "안건코드 입력확인" );
					alert(data );
				}); // end ajax call   		
			}

		} else { // for user
			var protocol = $("#protocol").val();
			var protocolname = $("#protocolname").text();
			var userid = $("#userid").val();
			var manager = $("#manager").prop('checked');
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
			// var report1 = $("#report1").prop('checked');
			// var report2 = $("#report2").prop('checked');
			// var report3 = $("#report3").prop('checked');

			var taken = $("#taken").prop('value');
			var confirm = $("#confirm").val();
			var pattern = /^[0-9a-zA-Z]{1,10}$/;
			var pattern_loose = /^[ㄱ-ㅎㅏ-ㅣ가-힣\s\w-().:~]+$/;
			var pattern_email = /^[@.\s\w-()]+$/;
			//var pattern = /^[0-9a-zA-Z]{6,10}+$/;

			// if ($("#lab2").prop('checked')) {
			// 	alert("Result Statistics");
			// } 

			console.log(protocolname);
			console.log(protocol);
			if (protocol.length == 0) {
				alert("안건코드를 입력하세요");
			} else if (site.length == 0) {
				alert("Site를 입력하세요");
			} else if (userid.length == 0) {
				alert("아이디를 입력하세요");
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
			} else if (taken == 'taken') {
				alert("아이디 중복 확인을 해주세요");
			} else if (!userid.match(pattern)) {
				alert("User ID는 1~10자리, 문자, 순자만 가능합니다");
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
				$.post("createuser.php", {
					protocol: protocol,
					protocolname: protocolname,
					userid: userid,
					manager: manager,
					password: password,
					site: site,
					person: person,
					phone: phone,
					email: email,
					address: address,
					pickupLoc: pickupLoc,
					pickupTime: pickupTime,
					lab1: lab1,
					lab2: lab2,
					pick1: pick1,
					pick2: pick2,
					kit1: kit1,
					kit2: kit2
				}, function(data) {
					if (data == '1') {
						alert('등록되었습니다');
						$("#taken").prop('value', 'taken');
						//window.location.href = "../login/index.php";
						window.location.href = "register.php";
						location.reload();

					}
				})
				.fail(function() {
					//alert( "안건코드 입력확인" );
					alert(data );
				}); // end ajax call   		
			}

		}
	});


	//id is already taken?
	$("#taken").click(function(){
		var userid = $("#userid").val();
		var pattern = /^[0-9a-zA-Z]{1,10}$/;

		if (userid == '') {
			alert("Please fill id field...!!!!!!");
		} else if (!userid.match(pattern)) {
			alert("아이디는 1~10자리, 문자, 순자만 가능합니다");
		} else {
			if ($('#pickup').is(':checked')) { //for pickup staff
				$.post("confirmPickupStaff.php", { //for users
					userid: userid,
				}, function(data) {
					if (data == 1) {
						alert("이미 사용중인 아이디입니다" );
						$("#taken").prop('value', 'taken');
							//$("#userid").prop('name', 'unconfirmed');
					} else {
						alert("사용 가능 아이디");
						$("#taken").prop('value', 'usalble');
						//$("#userid").prop('name', 'confirmed');
						//console.log($("#taken").prop('value'));
					}
				})
				.fail(function() {
					alert(data);
				}); // end ajax call   						

			} else {
				$.post("confirm.php", { //for users
					userid: userid,
				}, function(data) {
					if (data == 1) {
						alert("이미 사용중인 아이디입니다" );
						$("#taken").prop('value', 'taken');
							//$("#userid").prop('name', 'unconfirmed');
					} else {
						alert("사용 가능 아이디");
						$("#taken").prop('value', 'usalble');
						//$("#userid").prop('name', 'confirmed');
						//console.log($("#taken").prop('value'));
					}
				})
				.fail(function() {
					alert(data);
				}); // end ajax call   						
			}

		}
	});

	//userid is modified
	$("#userid").keyup(function(){
		//$("#userid").prop('name', 'unconfirmed');
		$("#taken").prop('value', 'taken');
	});

	$('#protocol').append(function() {
		$.ajaxSetup({async:false});//execute synchronously
		var protocolSelect;

   		$.post( "protocolselect2.php", function(data) {
		   	protocolSelect = data;
    	})
    	.fail(function() {
			alert( data );
		});					
		return protocolSelect;			
	});

    $('#protocol').change(function() {
		$.ajaxSetup({async:false});//execute synchronously
 		var protocol = $("#protocol").val();
 		var protocolname = $(this).children(":selected").prop("id");
 		console.log('protocolname '+protocolname);
		$('#protocolname').text(protocolname);

   		$.post( "site.php", {protocol: protocol, protocolname: protocolname}, function(data) {
   			$('#site > option').remove();
			$('#site').append(data);
			$("#site").selectpicker('refresh');	
    	})
    	.fail(function() {
			alert( data );
		}); 
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
	});
});