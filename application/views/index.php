<?php
// this file is called when user/attacker tries to look into "/application/views/" and simply gives back a 403 error.
exit(header('HTTP/1.0 403 Forbidden'));
