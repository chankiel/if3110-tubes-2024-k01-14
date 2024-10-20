<?php

function modal($class,$msg,$errors=[])
{
    $html = <<<"EOT"
        <div id="modal" class="$class">
            <div class="modal-content">
                <h2>Application Submitted</h2>
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
                <button id="modalOkBtn">OK</button>
            </div>
        </div>
    EOT;

    echo $html;
}
