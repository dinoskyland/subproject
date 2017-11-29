// Bind to the submit event of our form
$(function() {
    var level = $("#level").text();
    var periodFrom = 0;
    var periodTo = 999999;
    var periodCondition = null;
    var buttonTestResult = false;
    var subjectCodeResult = null;

    //iCheck for checkbox and radio inputs
    $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
        checkboxClass: 'icheckbox_minimal-blue',
        radioClass: 'iradio_minimal-blue'
    });

    var table = $('#subjectList').DataTable({
        //"searching": false,
        "autoWidth": false,
        "order": [
            [0, "desc"]
        ],
        "processing": true,
        "serverSide": true,
        "responsive": true,
        "ajax": {
            "url": "labsubjectlist2.php", // json datasource
            "type": "post", // method  , by default get
            "data": function(d) {
                d.buttonTestResult = buttonTestResult;
                d.periodFrom = periodFrom;
                d.periodTo = periodTo;
                d.periodCondition = periodCondition;
                d.subjectCodeResult = subjectCodeResult;
            }
        },
        "columns": [{
                "data": "t_receipt_cd"
            }, {
                "data": "sbj_initial"
            }, {
                "data": "sbj_no"
            }, {
                "data": "sbj_random_no"
            }, {
                "data": "sbjf_sample_date1"
            }, {
                "data": "sbj_gender"
            }, //5
            {
                "data": "sbj_birthdate"
            }, {
                "data": null
            }, //7
            {
                "data": null
            } //8
        ],
        "columnDefs": [{
            "targets": 0,
            "render": function(data, type, row, meta) {
                return '20' + data.substr(0, 6);
            }
        }, {
            "targets": 3,
            "orderable": false
        }, {
            "targets": 4,
            "orderable": false
        }, {
            "targets": 7,
            "orderable": false,
            "render": function(data, type, row, meta) {
                return "<button type='button' class='btn btn-info button-result' value='" + row['sbj_cd'] + "' name='" + row['t_visit_name'] + "'>" + row['t_visit_name'] + "</button>";
                // return "<button type='button' class='btn btn-info button-result' value='"+row['sbj_cd']+"' name='"+row['max(t_visit_cd)']+"'>"+row['max(t_visit_cd)']+"</button>";	    		
            }
        }, {
            "targets": 8,
            "orderable": false,
            "defaultContent": "",
            "render": function(data, type, row, meta) {
                return "<button type='button' class='btn btn-info button-result' value='" + row['sbj_cd'] + "' name='" + row['prev'] + "'>" + row['prev'] + "</button>";
                /*		    	if (temp > 11) {
                				    // return "<button type='button' class='btn btn-info button-result' value='"+row['sbj_cd']+"' name='V"+(temp-1)+"'>V"+(temp-1)+"</button>";	    						    		
                		    	} else if (temp > 0) {
                				    // return "<button type='button' class='btn btn-info button-result' value='"+row['sbj_cd']+"' name='V0"+(temp-1)+"'>V0"+(temp-1)+"</button>";
                		    	} 
                */
            }
        }]
    });

    $("#result").click(function() {
        var protocol = $("#protocol").val();
        if (protocol.length == 0) {
            alert('안건코드를 선택해주세요');
            return;
        }
        var site = $("#site").val();
        if (site.length == 0) {
            alert('Site를 선택해주세요');
            return;
        }
        var period = $("#period").val();
        var pattern = /^[ㄱ-ㅎㅏ-ㅣ가-힣\s\w-()\.]+$/;
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
            periodFrom = periodFrom[0].substr(2, 2) + periodFrom[1] + periodFrom[2];
            periodTo = period.substr(13).split('-');
            periodTo = periodTo[0].substr(2, 2) + periodTo[1] + periodTo[2];
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

    $('#myModal').on('show.bs.modal', function(event) {
        //console.log(subjectCode);
    });

    $('#subjectList').on('click', '.button-result', function() {
        $.ajaxSetup({
            async: false
        }); //execute synchronously
        var subjectCode = $(this).val();
        var visitName = $(this).prop('name');
        var subjectSex = $(this).parent().prev().prev().text();
        var newWindow;
        var subjectinfo;
        var result;

        console.log('subjectCode  ' + subjectCode);
        console.log('visitName  ' + visitName);
        console.log('button text   ' + $(this).text());

        //result
        $.post("result.php", {
                subjectCode: subjectCode,
                visitName: visitName,
                subjectSex: subjectSex
            }, function() {})
            .done(function(data) {
                result = data;
            })
            .fail(function(data) {
                alert(data);
            });

        //subject info
        $.post("subjectinfo.php", {
                subjectCode: subjectCode
            }, function() {})
            .done(function(data) {
                subjectinfo = data;
            })
            .fail(function(data) {
                alert(data);
            });
        newWindow = window.open('result.html');
        newWindow.result = result;
        newWindow.subjectinfo = subjectinfo;
    });

    $('#subjectList').on('click', '.button-result-previous', function() {
        $.ajaxSetup({
            async: false
        }); //execute synchronously
        var subjectCode = $(this).prop('id');
        var visitName = $(this).prop('name');
        var subjectSex = $(this).parent().prev().prev().prev().text();
        var newWindow;

        //result
        $.post("result.php", {
                subjectCode: subjectCode,
                visitName: visitName,
                subjectSex: subjectSex
            }, function(data) {
                newWindow = window.open('result.html');
                newWindow.result = data;
                //window.open('result.html', 'popUpWindow','height=400, width=650, left=300, top=100, resizable=yes, scrollbars=yes, toolbar=yes, menubar=no, location=no, directories=no, status=yes')
                //$("#resultTable > tbody > tr").remove();
                //$("#resultTable > tbody").append(data);	
            })
            .fail(function(data) {
                alert(data);
            });

        //subject info
        $.post("subjectinfo.php", {
                subjectCode: subjectCode
            }, function(data) {
                newWindow.subjectinfo = data;
            })
            .fail(function(data) {
                alert(data);
            });

    });

    $('#protocol').append(function() {
        $.ajaxSetup({
            async: false
        }); //execute synchronously
        var protocolSelect;

        if (level == 'Manager') {
            $.post("protocolselect2.php", function(data) {
                    protocolSelect = data;
                })
                .fail(function() {
                    alert("error");
                });
        } else {
            $.post("requester.php", function(data) {
                    protocolSelect = "<option selected='selected'>" + data[0].protocol + "</option>";
                    $('#site').append("<option selected='selected'>" + data[2].site + "</option>");
                }, 'json')
                .fail(function() {
                    console.log(data);
                });

            $.get("subjectInitial.php")
                .done(function(data) {
                    //console.log('subjectInitial  ' + data);
                    $('#subjectInitial > option').remove();
                    $('#subjectInitial').append(data);
                    $("#subjectInitial").selectpicker('refresh');
                })
                .fail(function() {
                    console.log(data);
                });

            $.get("subjectNo.php")
                .done(function(data) {
                    //console.log('subjectNo  ' + data);
                    $('#subjectNo > option').remove();
                    $('#subjectNo').append(data);
                    $("#subjectNo").selectpicker('refresh');
                })
                .fail(function() {
                    console.log(data);
                });


        }
        return protocolSelect;
    });

    $('#protocol').change(function() {
        $.ajaxSetup({
            async: false
        }); //execute synchronously
        var protocol = $("#protocol").val();
        var protocolname = $(this).children(":selected").prop("id");

        $.post("site.php", {
                protocol: protocol,
                protocolname: protocolname
            }, function(data) {
                $('#site > option').remove();
                $('#site').append(data);
                $("#site").selectpicker('refresh');
            })
            .fail(function() {
                alert(data);
            });
    });

    $('#site').change(function() {
        $.ajaxSetup({
            async: false
        }); //execute synchronously
        var site = $("#site").val();
        $.post("siteselect.php", {
                site: site
            }, function(data) {
                console.log(data);
            })
            .fail(function() {
                console.log(data);
            });

        $.get("subjectInitial.php")
            .done(function(data) {
                //console.log('subjectInitial  ' + data);
                $('#subjectInitial > option').remove();
                $('#subjectInitial').append(data);
                $("#subjectInitial").selectpicker('refresh');
            })
            .fail(function() {
                console.log(data);
            });

        $.get("subjectNo.php")
            .done(function(data) {
                //console.log('subjectNo  ' + data);
                $('#subjectNo > option').remove();
                $('#subjectNo').append(data);
                $("#subjectNo").selectpicker('refresh');
            })
            .fail(function() {
                console.log(data);
            });

    });

    $('#subjectInitial').change(function() {
        $.ajaxSetup({
            async: false
        }); //execute synchronously

        subjectCodeResult = $(this).children(":selected").prop("id");       
        console.log('subjectCodeResult  ' + subjectCodeResult);
    });

    $('#subjectNo').change(function() {
        $.ajaxSetup({
            async: false
        }); //execute synchronously
        subjectCodeResult = $(this).children(":selected").prop("id");       
        console.log('subjectCodeResult  ' + subjectCodeResult);
    });


});