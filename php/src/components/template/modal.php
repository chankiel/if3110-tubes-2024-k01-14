<?php

function modal($type, $header, $msg, $action, $confirmButton, $TA_name = null, $TA_id = null)
{
    $icon = "";
    if ($type === "delete") {
        $icon = 
        '<div class="material-symbols-outlined modal-icon ' . $type . '-icon">
            delete
        </div>';
    }else if($type === "approve"){
        $icon = 
        '<div class="material-symbols-outlined modal-icon ' . $type . '-icon">
            check
        </div>';
    }else if($type === "reject"){
        $icon = 
        '<div class="material-symbols-outlined modal-icon ' . $type . '-icon">
            close
        </div>';
    }

    $textarea = "";
    if ($TA_name !== null) {
        $textarea = <<<"TA"
            <textarea name="$TA_name" id="$TA_id"></textarea>
        TA;
    }

    $html = <<<"EOT"
        <div id="$type-modal" class="hidden modal">
            <div class="modal-content">
                $icon
                <h2>$header</h2>
                <p>{$msg}</p>
                <div class="modal-btn-container">
                    <button class="cancel-btn modalCancelBtn" data-modal="$type-modal">Cancel</button>
                    <form action="$action" method="POST" class="$type-form">
                        <button type="submit" class="$type-modal-btn confirm-btn">$confirmButton</button>
                        $textarea
                    </form>
                </div>
            </div>
        </div>
    EOT;

    echo $html;
}
