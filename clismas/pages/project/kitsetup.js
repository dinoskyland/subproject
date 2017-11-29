// Bind to the submit event of our form
$(function() {
    var level = $("#level").text();

    $('#protocol').append(function() {
        $.ajaxSetup({async:false});//execute synchronously
        var protocolSelect;

        if (level == 'Manager') {
            $.post( "protocolselect2.php", function(data) {
                protocolSelect = data;
            })
            .fail(function() {
                alert( "error" );
            });                 
        } 
        return protocolSelect;          
    });

    $('#protocol').change(function() {
		$.ajaxSetup({async:false});//execute synchronously
 		var protocol = $("#protocol").val();
 		var protocolname = $(this).children(":selected").prop("id");
		$('#protocolname').text(protocolname);

    	$.post( "protocolInfo.php", {protocol: protocol, protocolname: protocolname}, function(data) {
			// alert( data );
			$('#period').text(data[0].pl_study_begin+' - '+data[0].pl_study_end);
			$('#info').html("대표PI: "+data[0].pl_PI_name+"<br>대상질병: "+data[0].pl_diseases+"<br>견적비용: "+data[0].pl_estimate_cost);
			data[0].pl_sponser_name
			$('#sponsor').text(data[0].pl_sponser_name);
    	},'json')
    	.fail(function() {
			alert( data );
		}); // end ajax call

		table.ajax.reload();
    });

	$(document).on("click", ".kitmodify", function(){
    	var values = $(this).attr("id");
    	var kitname = $(this).parent().prevAll().eq(2).children().val();

		console.log(kitname);
    	$.post( "kitmodify.php", {id: values, kitname:kitname}, function(data) {
			// alert( data );
    	})
    	.fail(function() {
			alert( data );
		}); // end ajax call
		$('#kitList').text('Kit List (Kit Name has been modified...)')
		setTimeout(function(){ $('#kitList').text('Kit List')}, 3000);
	});

	$(document).on("click", ".kitdelete", function(){
    	var values = $(this).attr("id");
		// $(this).parent().prev().children().hide();
    	console.log('kitdelete id '+values);
		var returnVal = confirm("Order를 삭제하시겠습니까?");
        if (returnVal) {
	    	$.post( "kitdelete.php", {id: values}, function(data) {
				console.log('kitdelete return: '+data);
	    		if (data==1) {
					$("#search").click(); //refresh webpage
	    		} else {
		    		alert("Kit Order가 있어 삭제할 수 없습니다");
	    		}
	    	})
	    	.fail(function() {
				alert(data);
			}); // end ajax call
			table.ajax.reload(null, false);
        }
	});

	$("#kitinsert").click(function(){
 		var protocol = $("#protocol").val();
 		if (protocol.length == 0){
			alert('안건코드를 선택해주세요'); 	
			return;		
 		}
 		
    	var kitname = $('#kitname').val();
		var pattern = /^[ㄱ-ㅎㅏ-ㅣ가-힣\s\w-().]+$/;
    	console.log('kitname '+kitname);

		if (!kitname.match(pattern)) {
			alert("Kit Name은 문자,순자,(),-,_,. 만 가능합니다");
		} else {
	    	$.post( "kitinsert.php", {kitname: kitname}, function(data) {
				console.log('kitinsert '+data);
	    	})
	    	.fail(function() {
				alert(data);
			}); // end ajax call
	    }
		table.ajax.reload();
    	$('#kitname').val('');
	});

    var table = $('#kitListTable').DataTable( {
    	"autoWidth": false,
		"order": [[0, "desc" ]],
        "processing": true,
        "serverSide": true,
        "responsive": true,
        "ajax":{
            url :"kitlist.php", // json datasource
            type: "post"  // method  , by default get
        },
        "columns": [
        { "data": "id" },
        { "data": "protocol_cd" },
        { "data": "kit_name" },
        { "data": "regidate" },
        { "data": "register" },
        { "data": null },
        { "data": null }
    	],
    	"columnDefs": [ 
    	{
		    "targets": 2,
		    "render": function ( data, type, row, meta ) {
		    	return "<input type='text' class='form-control' id='"+row["id"]+"' value='"+row["kit_name"]+"'>";
		    }
		},
		{
		    "targets": -2,
		    "render": function ( data, type, row, meta ) {
		    	return "<button type='button' class='btn btn-info kitmodify' id='"+row["id"]+"'>수정</button>";
		    }
		},
		{
		    "targets": -1,
		    "render": function ( data, type, row, meta ) {
		    	return "<button type='button' class='btn btn-danger kitdelete' id='"+row["id"]+"'>삭제</button>";
			}
		}
		]
    });


});