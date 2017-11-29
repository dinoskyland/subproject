// Bind to the submit event of our form
$(function() {
    var level = $("#level").text();
    console.log('level'+level);
    var periodFrom = 0;
    var periodTo = 999999;
    var periodCondition = null;
    var buttonTestResult = false;

	var table = $('#subjectList').DataTable({
    	//"searching": false,
    	"autoWidth": false,
		"order": [[0, "desc" ]],
        "processing": true,
        "serverSide": true,
        "responsive": true,
        "ajax":{
            "url" :"reportsubjectlist.php", // json datasource
            "type": "post",  // method  , by default get
            "data": function (d) {
      				d.buttonTestResult = buttonTestResult;
      				d.periodFrom = periodFrom;
      				d.periodTo = periodTo;
      				d.periodCondition = periodCondition;
      		}
        },
        "columns": [
        { "data": "t_receipt_cd" },
        { "data": null }, //
        { "data": null }, //2
        { "data": "sbj_initial" },
        { "data": "sbj_no" },
        { "data": null }, 
        { "data": null }, 
        { "data": null }, //7
        { "data": null }, //8
        { "data": null } //9
    	],
    	"columnDefs": [ 
    	{
		    "targets": 0,
		    "render": function ( data, type, row, meta ) {
			    return '20'+data.substr(0,6);				    		
		    }
		},
    	{
		    "targets": 3,
		    "orderable": false
		},
    	{
		    "targets": 4,
		    "orderable": false
		},
    	{
		    "targets": 7,
		    "orderable": false,
		    "render": function ( data, type, row, meta ) {
			    return "<button type='button' class='btn btn-info button-result' value='"+row['sbj_cd']+"' name='"+row['max(t_visit_cd)']+"'>"+row['max(t_visit_cd)']+"</button>";	    		
		    }
		},
    	{
		    "targets": 8,
		    "orderable": false,
		    "defaultContent": "",
		    "render": function ( data, type, row, meta ) {
			    return "<button type='button' class='btn btn-info button-result' value='"+row['sbj_cd']+"' name='"+row['max(t_visit_cd)']+"'>"+row['max(t_visit_cd)']+"</button>";	    		
		    }
		}
		]
    });

    //iCheck for checkbox and radio inputs
    $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
      checkboxClass: 'icheckbox_minimal-blue',
      radioClass: 'iradio_minimal-blue'
    });


    $("#result").click(function(){
        var period = $("#period").val();
        periodCondition = $('input:radio[name=periodCondition]:checked').val();

        //console.log('site '+ site);
        if (periodCondition == 'all') {
            periodFrom = 0;
            periodTo = 999999;
        } else if (periodCondition == 'period' && period.length == 0) {
            alert('Period를 선택해주세요');
            return;
        } else {
            periodFrom = period.substr(0, 10).split('-');
            periodFrom = periodFrom[0].substr(2,2) + periodFrom[1] + periodFrom[2];
            periodTo = period.substr(13).split('-');
            periodTo = periodTo[0].substr(2,2) + periodTo[1] + periodTo[2];         
        } 

        buttonTestResult = true;
        table.ajax.reload();            

    });

   $('#period').daterangepicker({
        locale: {
            format: 'YYYY-MM-DD'
        }
    }, 
    function(start, end, label) {
        //alert("A new date range was chosen: " + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
        $('#periodPeriod').iCheck('check');
    });

    $('#periodAll').on('ifChecked', function() {
        $('#period').val('');
    });

	$(".button-send").click(function(){
        var values = $(this).attr("id");
        $.post( "buttonsend.php", {id: values}, function(data) {
            alert(data);
        })
        .fail(function() {
            alert( "error" );
        }); // end ajax call
    });

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