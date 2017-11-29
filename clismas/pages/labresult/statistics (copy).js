// Bind to the submit event of our form
$(function() {
   var level = $("#level").text();
   var periodFrom = 0;
   var periodTo = 999999;
   var periodCondition = null;
   var subjectInitial = null;
   var subjectNo = null;
   var buttonTestResult = false;

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
} else {
   $.post( "requester.php", function(data) {
      protocolSelect = "<option selected='selected'>"+data[0].protocol+"</option>";
      $('#site').append("<option selected='selected'>"+data[2].site+"</option>");
   },'json')
   .fail(function() {
      console.log( data );
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

   // var countProtocol, countSite, maxSite;
   var count = []; //array order: countProtocol, countSite, maxSite
   $('#site').change(function() {
      $.ajaxSetup({async:false});//execute synchronously
      var site = $("#site").val();
      $.post( "siteselect.php", {site: site}, function(data) {
         console.log(data);
      })
      .fail(function() {
         console.log(data);
      }); 

      $.get("countProtocol.php")
      .done(function(data) {
         console.log('countProtocol  '+data);
         count.push(data);
      })
      .fail(function() {
         console.log(data);
      });   

      $.get("countSite.php")
      .done(function(data) {
         console.log('countSite  '+data);
         count.push(data);
      })
      .fail(function() {
         console.log(data);
      });   

      $.get("maxSite.php")
      .done(function(data) {
         console.log('maxSite  '+data);
         count.push(data);
      })
      .fail(function() {
         console.log(data);
      });   
   });


//-------------
//- d3 bar CHART -
//--------------
var svg = d3.select(".bar-chart"),
margin = {top: 20, right: 70, bottom: 30, left: 80},
width = +svg.attr("width") - margin.left - margin.right,
height = +svg.attr("height") - margin.top - margin.bottom,
g = svg.append("g").attr("transform", "translate(" + margin.left + "," + margin.top + ")");


var value;

var y = d3.scaleBand()
.range([0, height])
.paddingInner([.2])
.paddingOuter([.1]);

var x = d3.scaleLinear()
.range([0, width]);


function initBar() {

   d3.tsv("data.tsv", type, function(error, data) {
      if (error) throw error;

      value = data;

      y.domain(data.map(function(d) { return d.name; }));
      x.domain([0, d3.max(data, function(d) { return d.value; })]);

      g.append("g")
      .attr("class", "x axis")
      .attr("transform", "translate(0," + height + ")")
      .call(d3.axisBottom(x));

      g.append("g")
      .attr("class", "y axis")
      .call(d3.axisLeft(y));

      g.selectAll(".bar")
      .data(data)
      .enter().append("rect")
      .attr("class", "bar")
      .attr("y", function(d) { return y(d.name); })
      .attr("x", function(d) { return 0; })
      .attr("width", function(d) { return x(d.value); })
      .attr("height", y.bandwidth());

   });

}

function type(d) {
d.value = +d.value; // coerce to number
return d;
}

//-------------
//- d3 line CHART -
//--------------
var svgLine = d3.select(".line-chart");
var marginLine = {top: 20, right: 70, bottom: 30, left: 50};
var lineWidth = +svgLine.attr("width") - marginLine.left - marginLine.right;
var maxWidth = lineWidth;
var ratioWidth;
var lineHeight = +svgLine.attr("height") - marginLine.top - marginLine.bottom;
var gLine = svgLine.append("g").attr("transform", "translate(" + marginLine.left + "," + marginLine.top + ")");
var parseTime = d3.timeParse("%d-%b-%y");
var path;
var lineValue
var xScale = d3.scaleTime()
.rangeRound([0, lineWidth]);

var yScale = d3.scaleLinear()
.rangeRound([lineHeight, 0]);

var line = d3.line()
.x(function(d) { return xScale(d.date); })
.y(function(d) { return yScale(d.close); });

function initLine() {

   d3.tsv("data2.tsv", function(d) {
      d.date = parseTime(d.date);
      d.close = +d.close;
      return d;
   }, function(error, data) {
      if (error) throw error;

      lineValue = data;

      xScale.domain(d3.extent(data, function(d) { return d.date; }));
      yScale.domain(d3.extent(data, function(d) { return d.close; }));

      gLine.append("g")
      .attr("class", "axis axis--x")
      .attr("transform", "translate(0," + lineHeight + ")")
      .call(d3.axisBottom(xScale));

      gLine.append("g")
      .attr("class", "axis axis--y")
      .call(d3.axisLeft(yScale))
      .append("text")
      .attr("fill", "#000")
      .attr("transform", "rotate(-90)")
      .attr("y", 6)
      .attr("dy", "0.71em")
      .style("text-anchor", "end")
      .text("Price ($)");

      path = gLine.append("path").datum(data);

      path.attr("class", "line")
      .attr("d", line);

   });

}

function initEvents() {
// Set up event handler for resizes
W.addListener(update);
}

/*----
UPDATE
----*/
function update() {
   updateScales();
   updateAxes();
   updateBar();
   updateLine();
}

function updateScales() {
//bar
width = d3.min([W.getViewportWidth(), +svg.attr("width")]) - margin.right - margin.left;

x = d3.scaleLinear()
.domain([0, d3.max(value, function(d) { return d.value; })])
.range([0, width]);

//line
lineWidth = d3.min([W.getViewportWidth(), +svgLine.attr("width")]) - marginLine.right - marginLine.left;
if (maxWidth  > lineWidth) {
   ratioWidth = lineWidth / maxWidth;
} else { ratioWidth = 1}
xScale = d3.scaleTime()
.domain(d3.extent(lineValue, function(d) { return d.date; }))
.rangeRound([0, lineWidth]);

}

function updateAxes() {
//bar
g.select("g.x")
.call(d3.axisBottom(x));

//line
gLine.select(".axis--x")
.call(d3.axisBottom(xScale));
}

function updateBar() {
   d3.selectAll('rect')
   .attr("width", function(d) { return x(d.value); })
}

function updateLine() {
// gLine.select("path.line").remove();
// path.attr("transform", null);
path.attr("transform", "scale("+ratioWidth+",1)");
}

initBar();

initLine();

initEvents();

});