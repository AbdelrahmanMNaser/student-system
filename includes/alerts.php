<?php
function displayAlert($thing, $action, $status, $status_message, $status_text, $btn_text)
{

    if ($status = "error") {
        $action = "NOT " . $action;
    }

    echo "<script>";
    echo "message = 'Submission $status_message';";
    echo "text = '$thing $action $status_text';";
    echo "icon = '$status';";
    echo "buttonText = '$btn_text';";
    echo "</script>";
}
