<?php
namespace Vanderbilt\EmailTriggerExternalModule;

use ExternalModules\AbstractExternalModule;
use ExternalModules\ExternalModules;

$pid = $_GET['pid'];
$index =  $_REQUEST['index_modal_delete'];


#get data from the DB
$form_name = empty($module->getProjectSetting('form-name'))?array():$module->getProjectSetting('form-name');
$form_name_event = empty($module->getProjectSetting('form-name-event'))?array():$module->getProjectSetting('form-name-event');
$email_from = empty($module->getProjectSetting('email-from'))?array():$module->getProjectSetting('email-from');
$email_to = empty($module->getProjectSetting('email-to'))?array():$module->getProjectSetting('email-to');
$email_cc =  empty($module->getProjectSetting('email-cc'))?array():$module->getProjectSetting('email-cc');
$email_bcc =  empty($module->getProjectSetting('email-bcc'))?array():$module->getProjectSetting('email-bcc');
$email_subject =  empty($module->getProjectSetting('email-subject'))?array():$module->getProjectSetting('email-subject');
$email_text =  empty($module->getProjectSetting('email-text'))?array():$module->getProjectSetting('email-text');
$email_attachment_variable =  empty($module->getProjectSetting('email-attachment-variable'))?array():$module->getProjectSetting('email-attachment-variable');
$email_attachment1 =  empty($module->getProjectSetting('email-attachment1'))?array():$module->getProjectSetting('email-attachment1');
$email_attachment2 =  empty($module->getProjectSetting('email-attachment2'))?array():$module->getProjectSetting('email-attachment2');
$email_attachment3 =  empty($module->getProjectSetting('email-attachment3'))?array():$module->getProjectSetting('email-attachment3');
$email_attachment4 =  empty($module->getProjectSetting('email-attachment4'))?array():$module->getProjectSetting('email-attachment4');
$email_attachment5 =  empty($module->getProjectSetting('email-attachment5'))?array():$module->getProjectSetting('email-attachment5');
$email_repetitive =  empty($module->getProjectSetting('email-repetitive'))?array():$module->getProjectSetting('email-repetitive');
$email_condition =  empty($module->getProjectSetting('email-condition'))?array():$module->getProjectSetting('email-condition');
$email_sent =  empty($module->getProjectSetting('email-sent'))?array():$module->getProjectSetting('email-sent');
$email_timestamp_sent =  empty($module->getProjectSetting('email-timestamp-sent'))?array():$module->getProjectSetting('email-timestamp-sent');
$email_deactivate =  empty($module->getProjectSetting('email-deactivate'))?array():$module->getProjectSetting('email-deactivate');
$email_incomplete =  empty($module->getProjectSetting('email-incomplete'))?array():$module->getProjectSetting('email-incomplete');

//Add some logs
$action_description = "Deleted Alert #".$index;
$changes_made = "[Subject]: ".$email_subject[$index].", [Message]: ".$email_text[$index];
\REDCap::logEvent($action_description,$changes_made,NULL,NULL,NULL,NULL);

$action_description = "Deleted Alert #".$index." To";
\REDCap::logEvent($action_description,$email_to[$index].$email_cc[$index].$email_bcc[$index],NULL,NULL,NULL,NULL,NULL);


#Delete email repetitive sent from JSON before deleting all data
$email_repetitive_sent =  empty($module->getProjectSetting('email-repetitive-sent'))?array():$module->getProjectSetting('email-repetitive-sent');
$email_repetitive_sent = json_decode($email_repetitive_sent);

if(!empty($email_repetitive_sent)) {
    $one_less = 0;
    foreach ($email_repetitive_sent as $form => $form_value) {
        foreach ($email_repetitive_sent->$form as $alert => $value) {
            //we don't add the deleted alert and rename the old ones.
            if ($alert == $index) {
                $one_less = 1;
            }else if($alert >= 0){
                //if the alert is -1 do not add it. When copying a project sometimes it has a weird config.
                $jsonArray[$form][$alert - $one_less] = $value;
            }
        }
    }
    $module->setProjectSetting('email-repetitive-sent', json_encode($jsonArray));
}

#Delete one element in array
unset($form_name[$index]);
unset($form_name_event[$index]);
unset($email_from[$index]);
unset($email_to[$index]);
unset($email_cc[$index]);
unset($email_bcc[$index]);
unset($email_subject[$index]);
unset($email_text[$index]);
unset($email_attachment_variable[$index]);
unset($email_attachment1[$index]);
unset($email_attachment2[$index]);
unset($email_attachment3[$index]);
unset($email_attachment4[$index]);
unset($email_attachment5[$index]);
unset($email_repetitive[$index]);
unset($email_condition[$index]);
unset($email_sent[$index]);
unset($email_timestamp_sent[$index]);
unset($email_deactivate[$index]);
unset($email_incomplete[$index]);

#Rearrange the indexes
$form_name = array_values($form_name);
$form_name_event = array_values($form_name_event);
$email_from = array_values($email_from);
$email_to = array_values($email_to);
$email_cc = array_values($email_cc);
$email_bcc = array_values($email_bcc);
$email_subject = array_values($email_subject);
$email_text = array_values($email_text);
$email_attachment_variable = array_values($email_attachment_variable);
$email_attachment1 = array_values($email_attachment1);
$email_attachment2 = array_values($email_attachment2);
$email_attachment3 = array_values($email_attachment3);
$email_attachment4 = array_values($email_attachment4);
$email_attachment5 = array_values($email_attachment5);
$email_repetitive = array_values($email_repetitive);
$email_condition = array_values($email_condition);
$email_sent = array_values($email_sent);
$email_timestamp_sent = array_values($email_timestamp_sent);
$email_deactivate = array_values($email_deactivate);
$email_incomplete = array_values($email_incomplete);

#Save data
$module->setProjectSetting('form-name', $form_name);
$module->setProjectSetting('form-name-event', $form_name_event);
$module->setProjectSetting('email-from', $email_from);
$module->setProjectSetting('email-to', $email_to);
$module->setProjectSetting('email-cc', $email_cc);
$module->setProjectSetting('email-bcc', $email_bcc);
$module->setProjectSetting('email-subject', $email_subject);
$module->setProjectSetting('email-text', $email_text);
$module->setProjectSetting('email-attachment-variable', $email_attachment_variable);
$module->setProjectSetting('email-attachment1', $email_attachment1);
$module->setProjectSetting('email-attachment2', $email_attachment2);
$module->setProjectSetting('email-attachment3', $email_attachment3);
$module->setProjectSetting('email-attachment4', $email_attachment4);
$module->setProjectSetting('email-attachment5', $email_attachment5);
$module->setProjectSetting('email-repetitive', $email_repetitive);
$module->setProjectSetting('email-condition', $email_condition);
$module->setProjectSetting('email-sent', $email_sent);
$module->setProjectSetting('email-timestamp-sent', $email_timestamp_sent);
$module->setProjectSetting('email-deactivate', $email_deactivate);
$module->setProjectSetting('email-incomplete', $email_incomplete);

echo json_encode(array(
    'status' => 'success',
    'message' => ''
));

?>