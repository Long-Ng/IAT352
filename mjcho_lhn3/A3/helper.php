<?php
//makes a checkbox input
function makeCheckbox($text, $varname, $opt="") {
    echo "<input type=\"checkbox\" name=\"$varname\" id=\"$varname\" value=\"$opt\" ";
    if (isset($_POST[$varname])) {
        echo "checked";
    }
    echo "/>";
    echo "<label for=\"$varname\">$text</label><br>";

}

//makes a date input
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