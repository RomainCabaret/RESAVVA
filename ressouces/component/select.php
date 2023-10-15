
<?php

function showSelect($data, $name, $display, $selected = "")
{


    echo '<select name="' . $name . '" class="' . $name . '" id="' . $name .  '">';
    foreach ($data as $row) {
        if ($selected == $row[$name]) {
            echo '<option value="' . htmlspecialchars($row[$name]) . '"selected>' . htmlspecialchars($row[$display]) . '</option>';
        } else {
            echo '<option value="' . htmlspecialchars($row[$name]) . '">' . htmlspecialchars($row[$display]) . '</option>';
        }
    }
    echo '</select>';
}

?>