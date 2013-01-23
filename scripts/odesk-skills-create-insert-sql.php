<?php
include dirname(dirname(__FILE__)).'/config/config.php';
include dirname(dirname(__FILE__)).'/lib/cron.php';

set_time_limit(172800);

Cron::refreshOdeskSkills(true);