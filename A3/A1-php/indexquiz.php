<?php

function makeRadioButtonGroup($label, $varname, $options, $texts, $required, $incomplete){
    global $$varname;
    echo"<td class=\"no-border\">$label</td><td class=\"no-border\" ";
    if ($incomplete && empty($$varname)) print("style=\"background-color:Yellow;\"");
    echo ">";
    
    $i = 0;
    foreach($options as $opt) 
        makeRadioButton($texts[$i++],$varname, $opt);
        
    echo"</td>";
}

function makeRadioButton($text,$varname, $opt) {
    global $$varname;
    echo "<input  type=\"radio\" name=\"$varname\" value=\"$opt\" ";
    if (!empty($$varname) && $$varname==$opt ) echo "checked"; 
    echo ">$text<br>\n";
}





    function radio_format($radioGroupName, $valueArr){
        echo"<td >$radioGroupName</td>";

        foreach ($valueArr as $key => $value){
            echo "<input type=\"radio\" name=\"$key\" value = \"$value\" "; 
        }
    }

    function makeRadioButton($text,$varname, $opt) {
        global $$varname;
        echo "<input  type=\"radio\" name=\"$varname\" value=\"$opt\" ";
        if (!empty($$varname) && $$varname==$opt ) echo "checked"; 
        echo ">$text<br>\n";
    }
?>