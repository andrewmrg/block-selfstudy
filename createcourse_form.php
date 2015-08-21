<?php

require_once("{$CFG->libdir}/formslib.php");

class createcourse_form extends moodleform {

    function definition() {

        $mform = & $this->_form;
        
        // add group for text areas
        //$mform->addElement('header', 'displayinfo', get_string('text_coursename', 'block_ps_selfstudy'));

		// add course name
		$mform->addElement('text', 'course_code', get_string('field_coursecode', 'block_ps_selfstudy'));
        $mform->setType('course_code', PARAM_NOTAGS);
        $mform->addRule('course_code', null, 'required', null, 'client');
        $mform->addElement('text', 'course_name', get_string('field_coursename', 'block_ps_selfstudy'));
        $mform->setType('course_name', PARAM_NOTAGS);
        $mform->addRule('course_name', null, 'required', null, 'client');

        //textarea
        $mform->addElement('textarea', 'course_description', get_string("field_description", "block_ps_selfstudy"), 'wrap="virtual" rows="15" cols="50"');
        $mform->setType('course_description', PARAM_NOTAGS);
        $mform->addRule('course_description', null, 'required', null, 'client');

        //checkbox for link courses, if it is not checked, it is like if it didn't exist
        $mform->addElement('advcheckbox', 'course_type', get_string('field_checkbox', 'block_ps_selfstudy'), 'Select to create a self-study course with link.', array('group' => 1), array(0, 1));

        //checkbox for link courses, if it is not checked, it is like if it didn't exist
        $mform->addElement('advcheckbox', 'course_status', get_string('field_checkbox_hide', 'block_ps_selfstudy'), 'Select to hide the course by default.', array('group' => 2), array(0, 1));

        //add time
        $mform->addElement('hidden', 'date_created');
        $mform->setType('date_created', PARAM_NOTAGS);

        $this->add_action_buttons();
    }

}
