<?php

function toast($class, $msg, $errors = [])
{

    $icon = $class == "success" ?
        '<span class="material-symbols-outlined icon-toast">check</span>'
        : '<span class="material-symbols-outlined icon-toast">error</span>';
    $status = ucfirst($class);
    $html = <<<"EOT"
        <div id="toast" class="toast $class">
            $icon
            <div class="toast-content">
                <h1>{$status}</h1>
                <p>{$msg}</p>
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
