
<?php

function showSelect($data, $name, $display){

    
    echo '<select name="'. $name. '" class="' . $name .'">';
    foreach ($data as $row) {

        echo '<option value="' . $row[$name] . '">' . $row[$display] . '</option>';
    }
    echo '</select>';
}

?>