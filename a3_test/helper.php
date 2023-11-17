<?php
function add_dropdown_option($optionValue) {
    echo "<option value=\"$optionValue\">$optionValue</option>";
}

function makeCheckbox($label, $text, $varname, $opt="") {
    echo "<input type=\"checkbox\" name=\"$varname\" value=\"$opt\" ";
    if (isset($_POST[$varname])) {
        echo "checked";
    }
    echo "/>";
    echo "<label for ='$label'>$text</label><br>";

}

function makeDateEntry($label, $text, $varname) {
    echo "<label for=\"$label\">$text:</label>";
    echo "<input type=\"date\" id=\"$varname\" name=\"$varname\"";
    
    if (isset($_POST[$varname])) {
        echo "value=$_POST[$varname]";
    }
    else{
        echo "value=\"\"";
    }
    
    echo " />";
}


?>