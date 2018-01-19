<?php

/***
 * Show some stats from the inContact (phone system) API.
 */

require('config.php');
require('incontact.php');

$inContact = new InContact(CONFIG['incontact']);

$agents = $inContact->get('/agents/states');

foreach ($agents['agentStates'] as $agent) {
    if ($agent['agentStateName'] == 'Available') {
        echo $agent['teamName'] . ': ' . $agent['firstName'] . $agent['lastName'] . '<br>';
    }
}
