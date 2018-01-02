<?php
session_start();
if(!$_SESSION['auth']) {
	header('location:index.php');
}
?><!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Outsiders</title>
<link rel="stylesheet" type="text/css" href="../codebase/fonts/font_roboto/roboto.css"/>
<link rel="STYLESHEET" type="text/css" href="../codebase/dhtmlx.css">
<script src="../codebase/dhtmlx.js"></script>
</head>
<body>

<script type="text/javascript" charset="utf-8">

var myGrid;
var dp;
var myForm; 
var formData;
var myPieChart;
var dpst;

function doOnLoad(){

	myPieChart = new dhtmlXChart({
		view:"pie3D",
		container:"chartbox",
		value:"#badges#",
		color:"#color#",
		pieInnerText:"#badges#",
		shadow:50,
		radius:120,
		border:0
	});

	myPieChart.load("outs/stat.json", "json"); //myPieChart - the component's object that dataProcessor will be attached to

	
	myGrid = new dhtmlXGridObject('gridbox');
	myGrid.enableSmartRendering(true); // false to disable
	myGrid.setImagePath("../../../codebase/imgs/");
	myGrid.setHeader("Civility, Name, Firstname, Company, Arrival, Departure");
	myGrid.setInitWidths("50,150,150,200,100,100");
	myGrid.attachHeader(",#connector_text_filter,#connector_text_filter,#connector_text_filter");
	myGrid.setColAlign("left,left,left,left,left,left");
	myGrid.setColSorting("str,str,str,str,date,date");
	myGrid.setColTypes("ed,ed,ed,ed,ed,ed");
	myGrid.attachEvent("onRowSelect",doOnRowSelected);
	myGrid.attachEvent("onEditCell",doOnCellEdit);
	myGrid.attachEvent("onEnter",doOnEnter);
	myGrid.attachEvent("onCheckbox",doOnCheck);
	myGrid.attachEvent("onBeforeRowDeleted",doBeforeRowDeleted);
	myGrid.init();
	myGrid.load("connector.php");
	
	dp = new dataProcessor("connector.php");
	dp.init(myGrid);

	var myAcc = new dhtmlXAccordion({
	    parent: "accObj",   // id or object for parent container
	    items: [
	    	{	id:     "a1",       // item id, required
            	text:   "New person",     // string, header's text (html allowed)
            	open:   true,       // boolean, true to open/false to close item on init
            	height: 300 }
        ]        // accordion's cells and other config
	});

	formData = [
		{type: "settings", position: "label-left", labelWidth: 90, inputWidth: 180},
		{type: "fieldset", label: "All fields required", inputWidth: "auto", list:[
			{type: "select", label: "Civ.", name: "Civ", value: "", required: true, options:[
				{text: "M.", value: "M."},
				{text: "MME", value: "MME"}
			]},
			{type: "input", label: "Name", validate: "NotEmpty", name: "Nom", value: "", required: true},
			{type: "input", label: "Firstname", validate: "NotEmpty", name: "Prenom", value: "", required: true},
			{type: "combo", label: "Company", validate: "NotEmpty", name: "Societe", value: "", required: true},
			{type: "input", label: "Start date", validate: "NotEmpty,ValidDate", name:"datedebut", value: "", required: true},
			{type: "input", label: "End date", validate: "NotEmpty,ValidDate", name:"datefin", value: "", required: true},
			{type: "button", value: "Create", name: "send"}
		]}
	];
	myForm = myAcc.cells("a1").attachForm(formData);
	var dhxComboCompany = myForm.getCombo("Societe").load("outs/company.json");

	// pour recharger la page, faire un window.location.reload();	
	myForm.attachEvent("onButtonClick", function(id){
		if (id == "send") { 
			myForm.save();
			window.location.reload();
			}
		});

	dp = new dataProcessor("gestiondata.php");
	dp.init(myForm);
	
}

function protocolIt(str){
	//var p = document.getElementById("protocol");
	//p.innerHTML = "<li style='height:auto;'>"+str+"</li>" + p.innerHTML
}
function doOnRowSelected(id){
	protocolIt("Rows with id: "+id+" was selected by user")
}
function doOnCellEdit(stage,rowId,cellInd){
	if(stage==0){
		protocolIt("User starting cell editing: row id is"+rowId+", cell index is "+cellInd)
	}else if(stage==1){
		protocolIt("Cell editor opened");
	}else if(stage==2){
		protocolIt("Cell editor closed");
	}
	return true;
}
function doOnCheck(rowId,cellInd,state){
	protocolIt("User clicked on checkbox or radiobutton on row "+rowId+" and cell with index "+cellInd+".State changed to "+state);
	return true;
}
function doOnEnter(rowId,cellInd){
	protocolIt("User pressed Enter on row with id "+rowId+" and cell index "+cellInd);
}
function doBeforeRowDeleted(rowId){
	if(confirm("Are you sure you want to delete row")){
		protocolIt("Row deletion confirmed");
		return true;
	}else{
		protocolIt("Row deletion canceled");
		return false;
	}
}

</script>
</head>

 <body onload="doOnLoad()">
 	<img src="heading.png">
      <table border="0" style="width:100%;padding-left:40px" >
      <tbody>
        <tr>
          <td>
            <table border="0" style="width:100%;">
              <tbody>
                <tr>
                  <td style="width:75%;"><br>
          		<div id="gridbox" style="width:770px;height:461px;background-color:white;"></div>
				<br>
				<input type="button" value=" Delete selected row " onclick="myGrid.deleteSelectedItem()" style="font: 20px arial, sans-serif; color:red">
				<br> 
                  </td>
                </tr>
                <tr>
                  <td><br>
                  
                  </td>
                </tr>
              </tbody>
            </table>
            <br>
          </td>
          <td>
            <table border="0"  style="width:100%;" >
              <tbody>
                <tr>
                  <td style="width:25%; vertical-align:top; padding-left:0px"><br>
                            <div id="accObj" style="width: 350px; height: 400px;"></div>
                  
                  </td>
                </tr>
                <tr>
                  <td style="width:25%; vertical-align:top; text-align:center; padding-left:0px"><br>
                  Valid & outdated badges
                  <div id="chartbox" style="width:350px;height:200px;border:0px solid #c0c0c0;"></div>
                  </td>
                </tr>
              </tbody>
            </table>
          </td>
        </tr>
      </tbody>
    </table>
   
  
    <p><br>
    </p>
  </body>

</html>