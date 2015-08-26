<?php 

require "../../config.php";

require_login();
if (isguestuser()) {
  print_error('guestsarenotallowed');
}

global $DB, $USER;

//Success when the course has been shipped
if(isset($_GET['id']) & isset($_GET['status']) & isset($_GET['courseid'])) {

  echo "got here";

	$id = $_GET['id'];
	$status = $_GET['status'];
  $courseid = $_GET['courseid'];

  $course = $DB->get_record('block_ps_selfstudy_course', array('id'=>$courseid), $fields='course_name,course_code');

  if (!$DB->update_record('block_ps_selfstudy_request', array('id'=>$id,'request_status'=>$status))) {
   print_error('inserterror', 'block_ps_selfstudy');
 }
 include('sendmessage.php');
 $url = new moodle_url('/blocks/ps_selfstudy/viewrequests.php');
 redirect($url);
} else {
  $url = new moodle_url('/blocks/ps_selfstudy/viewrequests.php');
  redirect($url);
}

//Success when the user has marked as completed a course
if(isset($_GET['cid'])) {

  echo "got here";

  $courseid = $_GET['cid'];
  $today = time();

  $completion = new stdClass();
  $completion->student_id = $USER->id;
  $completion->course_id = $courseid;
  $completion->completion_status = "completed";
  $completion->completion_date = $today;

  if (!$DB->insert_record('block_ps_selfstudy_complete', $completion)) {
    print_error('cannotsavedata', 'error', '');
  }
  $url = new moodle_url('/blocks/ps_selfstudy/myrequests.php?success=yes');
  redirect($url);
} else {
 $url = new moodle_url('/blocks/ps_selfstudy/myrequests.php');
 redirect($url);
}