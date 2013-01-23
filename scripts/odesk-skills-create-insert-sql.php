<?php
require_once dirname(dirname(__FILE__)).'/config/config.php';
require_once dirname(dirname(__FILE__)).'/lib/cron.php';

set_time_limit(172800);

Cron::refreshOdeskSkills(true);