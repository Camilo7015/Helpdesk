<?php
$session_id_to_destroy = 'nill2if998vhplq9f3pj08vjb1';
// 1. commit session if it's started.
if (session_id()) {
    session_commit();
}

// 2. store current session id
session_start();
$current_session_id = session_id();
session_commit();

// 3. hijack then destroy session specified.
session_id($session_id_to_destroy);
session_start();
session_destroy();
session_commit();

// 4. restore current session id. If don't restore it, your current session will refer to the session you just destroyed!
session_id($current_session_id);
session_start();
session_commit();

?>