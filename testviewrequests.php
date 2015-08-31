<?php
/**
 * Simple file test_custom.php to drop into root of Moodle installation.
 * This is an example of using a sql_table class to format data.
 */
require "../../config.php";
require "$CFG->libdir/tablelib.php";
require_once('managelinks_form.php');
require "testviewrequests_table.php";
global $OUTPUT, $PAGE;

require_login();
if (isguestuser()) {
    print_error('guestsarenotallowed');
}

$context = context_system::instance();
$PAGE->set_context($context);
$PAGE->set_url('/blocks/ps_selfstudy/testviewrequests.php');
$PAGE->set_pagelayout('standard');
$link_form = new managelinks_form();
$table = new testviewrequests_table('uniqueid');

// Define headers
$PAGE->set_title('View Requests');
$PAGE->set_heading('View Requests');

//sql to get all requests
$fields = 'r.id,c.course_code,c.course_name,u.firstname,u.lastname,u.email,u.address,u.department,u.country,u.phone1,r.student_id,r.course_id,r.request_date,r.request_status';
$from = "{block_ps_selfstudy_request} as r JOIN {block_ps_selfstudy_course} c ON (c.id=r.course_id) JOIN {user} u ON(u.id=r.student_id)";

$site = get_site();
echo $OUTPUT->header(); //output header
if (has_capability('block/ps_selfstudy:viewrequests', $context, $USER->id)) {
	//if show was set, show all requests
	if(isset($_GET['show'])) {
		if($_GET['show'] == 'all') {
			$sqlconditions = 'r.request_status != 2';
			$table->define_baseurl("$CFG->wwwroot/blocks/ps_selfstudy/testviewrequests.php?show=all");
			$link = '<br><a href="testviewrequests.php">'.get_string('clickpendinglist','block_ps_selfstudy').'</a>';
		}
	} else {
		$sqlconditions = 'r.request_status = 0';
		$table->define_baseurl("$CFG->wwwroot/blocks/ps_selfstudy/testviewrequests.php");
		$link = '<br><a href="testviewrequests.php?show=all">'.get_string('clickfulllist','block_ps_selfstudy').'</a>';
	}
	$table->set_sql($fields, $from, $sqlconditions);
	$table->out(10, true); //print table
	echo $link;
	//echo '<br><a href="testallrequests.php">'.get_string('clickfulllist','block_ps_selfstudy').'</a>';
} else {
	print_error('nopermissiontoviewpage', 'error', '');
}
echo $OUTPUT->footer();