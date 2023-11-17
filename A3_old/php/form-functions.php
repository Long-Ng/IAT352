<?php
//todo: fix 0 time entry bug
//fortify entry integrity
//decorate form
//eliminate blank lines
//tag shouldn't take empty fields
    function initest(){
        echo "I want to die";
    }


    function endForm(){
        
        echo "<h2>GG Form done</h2>";
    }

    

    function makeInputField($label, $placeholder, $varname, $required, $incomplete, $defVal = ''){
        global $$varname;
        if (!empty($label)) {
            echo "<td class=\"no-border\">$label</td>";
        }
	    echo "<td class=\"no-border\"><input type=\"text\" name=\"$varname\" placeholder=\"$placeholder\" ";
        if ($incomplete && $required) {
            (empty($$varname) && $$varname !== "0") ? print("style=\"background-color:Yellow;\"") : print("value=\"" . htmlspecialchars($$varname) . "\"");
        } else {
            echo "value=\"" . htmlspecialchars($$varname) . "\"";
        }
        echo"></td>";
    }

    function makeYYYY_MM_DDField($label, $placeholder, $varname, $required, $incomplete, $defVal = ''){
        global $$varname;
        if (!empty($label)) {
            echo "<td class=\"no-border\">$label</td>";
        }
	    echo "<td class=\"no-border\"><input type=\"text\" name=\"$varname\" placeholder=\"$placeholder\" ";
        if ($incomplete && $required) {
            (empty($$varname) && $$varname !== "0") ? print("style=\"background-color:Yellow;\"") : print("value=\"" . htmlspecialchars($$varname) . "\"");
        } else {
            echo "value=\"" . htmlspecialchars($$varname) . "\"";
        }
        echo"></td>";
    }


    function makeTextareaField($label, $placeholder, $varname, $required, $incomplete,$defVal=''){
        global $$varname;
        if (!empty($label)) {
            echo "<td>$label</td>";
        }
        echo "<td class=\"no-border num-col\" ><textarea type=\"text\"  name=\"$varname\" placeholder=\"$placeholder\" rows=\"7\" cols=\"50\" style=\"width: 45vw\"";
        if($incomplete && $required) {
            if (empty($$varname)) {
                echo " style=\"background-color:Yellow;\"";
            }
            echo ">";
            echo htmlspecialchars($$varname);
        } 
        //retain info for textarea, addd $_GET variables and shit
        else if($incomplete){
            echo ">";
            echo htmlspecialchars($$varname);
        }
        else {
            echo ">";
        }
        echo "</textarea></td>";
    }

    function makeDuplicateRows($count, $qtyArr, $measurementArr, $itemArr, $incomplete) {


        for ($i = 0; $i < $count; $i++) {

            echo "<tr style=\"border-collapse: collapse; border-top: 1px solid black; border-bottom: 1px solid black; height: 60px\">";
            echo "<td class = \"no-border\" >Item " . $i+1 .": </td>";
            //todo: change qty_$i into array-ed variable
            global ${"qty_$i"};
            global ${"measurement_$i"};
            global ${"item_$i"}; 
            ${"qty_$i"} = $qtyArr[$i];
            ${"measurement_$i"} = $measurementArr[$i];
            ${"item_$i"} = $itemArr[$i];
            
            makeInputField("", "Quantity: (number only) ", "qty_$i", false, $incomplete);
            makeDropDown("", "measurement_$i",
            ['','Measurement','pound(s)', 'gram(s)', 'ounce(s)', 'pcs', 'ml', 'tablespoon', 'teaspoon', 'cup'],
            ['','Measurement','pound(s)', 'gram(s)', 'ounce(s)', 'pcs', 'ml', 'tablespoon', 'teaspoon', 'cup'],$measurementArr[$i]);
            makeInputField("", "Ingredient name", "item_$i", false, $incomplete);
            echo "</tr>";
        }

        
    }

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

    function makeDropDown($label, $varname, $options, $text, $defVal=""){
        global $$varname;
        echo "<td class= \"no-border\">$label</td>";
        echo "<td class= \"no-border\"><select name=\"$varname\"";
        //makeDropdownOption($defVal,$varname, $opt);
        $i = 0;
        foreach($options as $opt) 
            makeDropdownOption($text[$i++],$varname, $opt, $defVal);
        echo "</select>\n</td>";


    }

    function makeDropdownOption($text, $varname, $opt, $defVal = "") {
    echo "<option value=\"$opt\" ";
    if (($defVal == $opt) || ($defVal == $opt)) {
        echo "selected";
    }
    echo ">$text</option>\n";
    }

    function makeCheckbox($text, $varname, $opt="true") {
        global $$varname;
        echo "<input type=\"checkbox\" name=\"$varname\" value=\"$opt\" ";
        if (!empty($$varname)) {
            echo "checked";
        }
        echo ">$text<br>\n";
    }
    

    //todo: remove || true and && false
    function validatingFormRequired(){
        if((!empty($_GET['title']) 
        && !empty($_GET['type']) 
        && !empty($_GET['size']) 
        && !empty($_GET['prephrs'] || $_GET['prephrs'] =="0" ) 
        && !empty($_GET['prepmins'] || $_GET['prepmins'] =="0") 
        && !empty($_GET['cookhrs'] || $_GET['cookhrs'] =="0") 
        && !empty($_GET['cookmins'] || $_GET['cookmins'] =="0"))){
            return true;
        }
        return false;
    }
    function validatingQtyEntry($qtyArr,$count){
        $flag = true;
        for ($i=0; $i < $count; $i++) { 
            if ((!is_numeric($qtyArr[$i]) && !($qtyArr[$i] === ""))) {
                array_push($_GET['message'],"Quantity for item ". $i+1 ." MUST be a number.");
                $flag = false;
            }
        }
        return $flag;
    }

    function validatingNumericTime(){
        $flag = true;
        if(!is_numeric($_GET['prephrs']) || !is_numeric($_GET['prepmins']) || !is_numeric($_GET['cookhrs']) || !is_numeric($_GET['cookmins'])) {
            $flag = false;
        }

        (!is_numeric($_GET['prephrs'])) ? array_push($_GET['message'],"Prep hours MUST be a number.") : "";
        (!is_numeric($_GET['prepmins'])) ? array_push($_GET['message'],"Prep minutes MUST be a number.") : "";
        (!is_numeric($_GET['cookhrs'])) ? array_push($_GET['message'],"Cook hours MUST be a number.") : "";
        (!is_numeric($_GET['cookmins'])) ? array_push($_GET['message'],"Cook minutes MUST be a number.") : "";
        return $flag;
    }

    function validatingTags(){
        $flag = true;
        if(strpos($_GET['tags'], "\n") !== false || strpos($_GET['tags'], "\r") !== false) {
            $mess = "Please don't use line break in tag. I'm trying to make the site looks good :(";
            array_push($_GET['message'], $mess );
            $flag = false;
        }
        return $flag;
    }

    function validatingIngredientCompletion($qtyArr, $measurementArr, $itemArr, $count) {
        $flag = true;
        for ($i = 0; $i < $count; $i++) {
            $qtyEmpty = empty($qtyArr[$i]);
            $measurementEmpty = (empty($measurementArr[$i]) || $measurementArr[$i] === "Measurement");
            $itemEmpty = empty($itemArr[$i]);
    
            // Check if all three fields are empty; no error message in this case.
            if ($qtyEmpty && $measurementEmpty && $itemEmpty) {
                continue;
            }
    
            // Check if any of the fields is empty; raise an error message.
            if ($qtyEmpty || $measurementEmpty || $itemEmpty) {
                array_push($_GET['message'], "Ingredient number " . $i+1 . " is incomplete");
                $flag = false;
            }
        }
        return $flag;
    }

    function arraylizeEntries($count, $varname){
        $tempArray = array();
        for($i = 0; $i < $count; $i++){
            $tempArray[] = ${$varname .$i};
        }
        return $tempArray;
    }

    function makeNav(){
        
    }


    function showDetail($ID="0"){
        if(isset($_GET['ID'])){
            $ID = $_GET['ID'];
        }

        global $docroot;
        $docroot = $_SERVER['DOCUMENT_ROOT'];
        if(!file_exists("$docroot/HoangLong_Nguyen_A1/data/recipelist.csv")){
            echo "<p>No recipe recorded, let's make one<p>";
            exit;
        }
        $fp = fopen("$docroot/HoangLong_Nguyen_A1/data/recipelist.csv",'r');
        if(!$fp) {
            echo "<p>f open fail<e>";
			echo "<strong>Unable to open data file.</strong>";
			exit;
        }
        else{
            
            while($line = fgetcsv($fp)){
                if($line[0]!= $ID) continue;
                echo "<div class = \"dropshadow\">";
                echo "<hr><h2>" . $line[1] . "</h2><hr>";

                echo "<table class=\"small-table\">" ;
                echo "<tr><td>Prep time</td><td>Cook time</td><td>". $line[3] ."</td></tr>";
                echo "<td>". $line[5]. ":"  . $line[6] ."</td>";
                echo "<td>". $line[7]. ":"  . $line[8] ."</td>";
                echo "<td>". $line[4] ."</td>";
                echo "</tr></table>";
                echo "<br><br>";
                echo "<h2>" . "About this recipe" . "</h2><hr>";
                echo "<p class=\"small-table\">" . "$line[2]" ."</p>";
                echo "<br><br>";
                echo "<h2>" . "Ingredients" ."</h2><hr>";
                $ingArr = explode("|||",$line[9]);
                foreach ($ingArr as $tuple){
                    $tuple = explode("+++",$tuple);
                    if(!($tuple[0] === "" || $tuple[2] ==="" )){
                        echo "<p class=\"num-col\">" . $tuple[0] ." " . $tuple[1] . " of " . $tuple[2] . "</p>";
                    }
                    
                }
                echo "<br><br>";

                echo "<h2>" . "Directions" ."</h2><hr>";
                echo "<table class=\"no-grid-table small-table\">";
                $stepsArr=explode("<br>",$line[10]);
                $step_i = 1;
                foreach ($stepsArr as $val){
                    if($val =="") continue;
                    echo "<tr>";
                    echo "<td class=\"big-text no-border\" style =\"padding-top:30px; padding-bottom:30px\">" . $step_i++ . "</td>";
                    echo "<td class=\"no-border\">" . $val . "</td>";
                    echo "</tr>";
                    
                }
                echo "</table>";

                echo "<h3>" . "Tags" ."</h3>";
                echo "<p style=\"white-space: pre-wrap;\" class = \"num-col small-table\">";
                $tag_i = 0;
                $tag_size = count(explode(",",$line[11]));
                foreach (explode(",",$line[11]) as $val){
                    echo $val;
                    if($tag_i < ($tag_size -1)) {
                        echo "     •     ";
                    }
                    $tag_i++;  
                }
                echo "</p>";

                 
            }
            echo "</table>";
        }
        echo "</div>";
    }
    
?>