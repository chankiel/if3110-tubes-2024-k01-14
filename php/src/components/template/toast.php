<?php

function toast($class, $msg, $errors = [])
{
    $html = <<<"EOT"
        <div id="toast" class="toast $class">
            <div class="toast-content">
                <p>{$msg}!</p>
    EOT;

    if (!empty($errors)) {
        $html .= "<ul class='error-list'>";
        foreach ($errors as $error) {
            $html .= "<li>$error</li>";
        }
        $html .= "</ul>";
    }

    $html .= <<<"EOT"
            </div>
        </div>
    EOT;

    echo $html;
}
