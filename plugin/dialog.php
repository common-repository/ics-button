<?php
defined('ABSPATH') or die("Access denied.");
?>
<!DOCTYPE html>
<html>
<head>
<title>Add Event</title>
<script type="text/javascript" src="<?php echo site_url(); ?>/wp-includes/js/tinymce/tiny_mce_popup.js"></script>
<script type="text/javascript" src="<?php echo site_url(); ?>/wp-includes/js/jquery/jquery.js"></script>
<script type="text/javascript">
	var $j = jQuery.noConflict();
	//Not working yet :P
	$j('#startDate').change( function(){
		var date = $(this).val();
		$j('#endDate').val(date);
	});
	
	var addIcsLink = {
		e: '',
		init: function(e) {
			addIcsLink.e = e;
			tinyMCEPopup.resizeToInnerSize();
		},
		insert: function add_link_to_mce(e) {
	
			var subject = $j('#subject').val();
			var description = $j('#description').val();
			var location = $j('#location').val();
			var startDate = $j('#startDate').val();
			var startHour = $j('#startHour').val();
			var startMinute = $j('#startMinute').val();
			var startMeridium = $j('#startMeridium').val();
			var endDate = $j('#endDate').val();
			var endHour = $j('#endHour').val();
			var endMinute = $j('#endMinute').val();
			var endMeridium = $j('#endMeridium').val();
			
			if(subject == '' || description == '' || location == '' || startDate == '' || endDate == ''){
				alert("You must fill out all fields.");
				return;
			}
			
			if(startMeridium == "PM"){
				startHour = parseInt(startHour) + 12;
			}
			if(endMeridium == "PM"){
				endHour = parseInt(endHour) + 12;
			}
						
			var output = '[ics_button subject="' + subject + '" description="' + description + '" location="' + location + '" ';
			output += 'start-date="' + startDate + ' ' + startHour + ':' + startMinute + '" ';
			output += 'end-date="' + endDate + ' ' + endHour + ':' + endMinute + '"]';
			output += '<img src="<?php echo site_url(); ?>/wp-content/plugins/ics-button/plugin/img/Calendar-Add.png" alt="Add to Calendar" width="110"/>[/ics_button]';
		
			tinyMCEPopup.execCommand('mceInsertContent', false, output);
		
			tinyMCEPopup.close();
			
			//$j('#test_area').html(output);
		}
	}
	tinyMCEPopup.onInit.add(addIcsLink.init, addIcsLink);
</script>
<link href="<?php echo site_url(); ?>/wp-content/plugins/ics-button/plugin/css/style.css" rel="stylesheet" type="text/css" />
</head>
<body>
<div id="main">
<form onsubmit="addIcsLink.insert(addIcsLink.e);return false;" action="#">
  <h3>Event Details:</h3>
  <p>
    <label for="subject">Name: </label>
    <input name="subject" type="text" id="subject" size="30" />
  </p>
  <p>
    <label for="description">Description: </label>
    <input name="description" type="text" id="description" size="30" />
  </p>
  <p>
    <label for="location">Location:</label>
    <input name="location" type="text" id="location" size="30" />
  </p>
  <p>
    <label for="startDate">Start Date: </label>
    <input name="startDate" type="text" id="startDate" size="15" /> YYYY-MM-DD<br/>
    <label for="startHour">Start Time: </label>
    <select name="startHour" id="startHour">
   	  <option value="1">1</option>
        <option value="2">2</option>
        <option value="3">3</option>
        <option value="4">4</option>
        <option value="5">5</option>
        <option value="6">6</option>
        <option value="7">7</option>
        <option value="8">8</option>
        <option value="9">9</option>
        <option value="10">10</option>
        <option value="11">11</option>
        <option value="12">12</option>
    </select>
    <select name="startMinute" id="startMinute">
   	  <option value="00">00</option>
      <option value="05">05</option>
        <option value="10">10</option>
        <option value="15">15</option>
        <option value="20">20</option>
        <option value="25">25</option>
        <option value="30">30</option>
        <option value="35">35</option>
        <option value="40">40</option>
        <option value="45">45</option>
        <option value="50">50</option>
        <option value="55">55</option>
    </select>
    <select name="startMeridium" id="startMeridium">
   	  <option value="AM">AM</option>
      <option value="PM">PM</option>
    </select>
  </p>
  <p>
    <label for="endDate">End Date: </label>
    <input name="endDate" type="text" id="endDate" size="15" /> YYYY-MM-DD<br/>
    <label for="endHour">End Time: </label>
    <select name="endHour" id="endHour">
   	  <option value="1">1</option>
        <option value="2">2</option>
        <option value="3">3</option>
        <option value="4">4</option>
        <option value="5">5</option>
        <option value="6">6</option>
        <option value="7">7</option>
        <option value="8">8</option>
        <option value="9">9</option>
        <option value="10">10</option>
        <option value="11">11</option>
        <option value="12">12</option>
    </select>
    <select name="endMinute" id="endMinute">
   	  <option value="00">00</option>
      <option value="05">05</option>
        <option value="10">10</option>
        <option value="15">15</option>
        <option value="20">20</option>
        <option value="25">25</option>
        <option value="30">30</option>
        <option value="35">35</option>
        <option value="40">40</option>
        <option value="45">45</option>
        <option value="50">50</option>
        <option value="55">55</option>
    </select>
    <select name="endMeridium" id="endMeridium">
   	  <option value="AM">AM</option>
      <option value="PM">PM</option>
    </select>
  </p>
  
  <div class="mceActionPanel">
    <div>
      <input type="button" id="insert" name="insert" value="Ok" onclick="addIcsLink.insert(addIcsLink.e)" />
    </div>
    <div>
      <input type="button" id="cancel" name="cancel" value="Cancel" onclick="tinyMCEPopup.close()" />
    </div>
  </div>
</form>
</div>
</body>
</html>
<?php
//prevent ajax from showing 0
die();
?>