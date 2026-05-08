<!DOCTYPE html>
<html>
<head>

</head>
<body>

<?php
    $valCategories = array("praca", "dom", "nauka", "zdrowie", "inne");
    $valPrios = array("niski", "sredni", "wysoki");
    $valStatus = array("robione", "wTrakcie", "zakonczone");
    $correctForm = 1;
    $errors = array();
    $tasks = array(
        array("title"=>"tytul1", "category"=>"ph", "priority"=>"ph", "status"=>"zakonczone", "estimated_minutes"=>0, "tags"=>array("pilne", "zespol")),
        array("title"=>"tytul1", "category"=>"ph", "priority"=>"ph", "status"=>"ph", "estimated_minutes"=>0, "tags"=>array("pilne", "zespol")),
        array("title"=>"tytul1", "category"=>"ph", "priority"=>"ph", "status"=>"ph", "estimated_minutes"=>0, "tags"=>array("pilne", "zespol")),
        array("title"=>"tytul1", "category"=>"ph", "priority"=>"ph", "status"=>"ph", "estimated_minutes"=>10, "tags"=>array("pilne", "zespol")),
    );

    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        //$title = "abc";
        //echo $title;
        $title = $_POST['title'] ?? '';
        $title = trim($title);
        //echo $title;
        $category = $_POST['category'] ?? '';
        //echo $category;
        $priority = $_POST['priority'] ?? '';
        //echo $priority;
        $status = $_POST['status'] ?? '';
        //echo $status;
        $estimated_minutes = $_POST['estimated_minutes'] ?? '';
        $estimated_minutes = trim($estimated_minutes);
        $tags = $_POST['tags'] ?? [];

        if(empty($title)){
            $correctForm = 0;
            array_push($errors, "Title should not be empty");
        }
        if(!is_numeric($estimated_minutes)){
            $correctForm = 0;
            array_push($errors, "Estimated minutes should be a positive number");
        }
        else{
            if((int)$estimated_minutes <= 0){
                $correctForm = 0;
                array_push($errors, "Estimated minutes should be a positive number");
            }
        }
        if(count($tags) < 1){
            $correctForm = 0;
            array_push($errors, "Select at least one tag");
        }
        $ifGoodCat = 0;
        $ifGoodPri = 0;
        $ifGoodSta = 0;
        foreach ($valCategories as $value) {
            if($category == $value){
                $ifGoodCat = 1;
                break;
            }
        }
        foreach ($valPrios as $value) {
            if($priority == $value){
                $ifGoodPri = 1;
                break;
            }
        }
        foreach ($valStatus as $value) {
            if($status == $value){
                $ifGoodSta = 1;
                break;
            }
        }
        if($ifGoodCat == 0){
            array_push($errors, "Category is not valid");
            $correctForm = 0;
        }
        if($ifGoodPri == 0){
            array_push($errors, "Priority is not valid");
            $correctForm = 0;
        }
        if($ifGoodSta == 0){
            array_push($errors, "Status is not valid");
            $correctForm = 0;
        }
        //echo $status;
        //echo "a";
        foreach ($errors as $value) {
            echo "$value<br>";
        }
        if($correctForm == 1){
            array_push($tasks, array());
            $num = count($tasks) - 1;
            $tasks[$num]["title"] = $title;
            $tasks[$num]["category"] = $category;
            $tasks[$num]["priority"] = $priority;
            $tasks[$num]["status"] = $status;
            $tasks[$num]["estimated_minutes"] = $estimated_minutes;
            $tasks[$num]["tags"] = $tags;
            //echo $tasks[$num]["title"] ;
        }
    }
?>

<form action="index.php" method="post">
<fieldset id="fieldset1">
<legend id="zadania">Formularz dodawania zadania</legend>
<ol>
<li><label for="title">Tytuł:</label><br>
<input id="title" type="text" name="title" <?php
    if(!empty($title)){
        echo "value='" . $title . "'";
    }
    ?>></li>

<li><label for="category">Kategoria:</label><br>
<select name="category" id="category">
<option <?php
if($category == "praca"){
    echo "selected";
}?> value="praca">Praca</option>
<option <?php
if($category == "dom"){
    echo "selected";
}?> value="dom">Dom</option>
<option <?php
if($category == "nauka"){
    echo "selected";
}?> value="nauka">Nauka</option>
<option <?php
if($category == "zdrowie"){
    echo "selected";
}?> value="zdrowie">Zdrowie</option>
<option <?php
if($category == "inne"){
    echo "selected";
}?> value="inne">Inne</option>
</select>
</li>

<li><label for="priority">Priorytet:</label></span><br>
<select  name="priority" id="priority">
<option
<?php
if($priority == "niski"){
    echo "selected";
}?> value="niski">Niski</option>
<option <?php
if($priority == "sredni"){
    echo "selected";
}?> value="sredni">Średni</option>
<option <?php
if($priority == "wysoki"){
    echo "selected";
}?> value="wysoki">Wysoki</option>
</select>
</li>

<li><label for="status">Status:</label></span><br>
<select id="status" name="status">
<option <?php
if($status == "robione"){
    echo "selected";
}?> value="robione">do zrobienia</option>
<option <?php
if($status == "wTrakcie"){
    echo "selected";
}?> value="wTrakcie">w trakcie</option>
<option <?php
if($status == "zakonczone"){
    echo "selected";
}?> value="zakonczone">zakończone</option>
</select>
</li>

<li><label for="estimated_minutes">Estimated minutes:</label><br>
<input id="estimated_minutes" type="text" name="estimated_minutes" <?php
if(!empty($estimated_minutes)){
    echo "value='" . $estimated_minutes . "'";
}
?>></li>

<li>
<p>Tagi:</p>
<input type="checkbox" id="tag1" name="tags[]" value="pilne" <?php
foreach($tags as $value){
    if($value == "pilne"){
        echo "checked";
        break;
    }
}
?>>
<label for="tag1">Pilne</label><br>
<input type="checkbox" id="tag2" name="tags[]" value="zespol" <?php
foreach($tags as $value){
    if($value == "zespol"){
        echo "checked";
        break;
    }
}
?>>
<label for="tag2">Zespół</label><br>
<input type="checkbox" id="tag3" name="tags[]" value="backend" <?php
foreach($tags as $value){
    if($value == "backend"){
        echo "checked";
        break;
    }
}
?>>
<label for="tag3">Backend</label><br>
<input type="checkbox" id="tag4" name="tags[]" value="frontend" <?php
foreach($tags as $value){
    if($value == "frontend"){
        echo "checked";
        break;
    }
}
?>>
<label for="tag4">Frontend</label><br>
</li>

<button type="submit" value="Submit">Zapisz zadanie</button>
</ol>
</fieldset>
</form>
<?php
    $bezcelowyArray = array();
    $dzrob = 0;
    $zakon = 0;
    echo count($tasks) . "<br>";
    foreach($tasks as $value){
        if($value["status"] == "robione"){
            $dzrob++;
        }
        else if($value["status"] == "zakonczone"){
            $zakon++;
        }
        array_push($bezcelowyArray, $value["estimated_minutes"]);
    }
    echo $dzrob . "<br>";
    echo $zakon . "<br>";
    echo array_sum($bezcelowyArray) . "<br>";

    //echo array

    echo "<br>";
    foreach($tasks as $value){
        echo htmlspecialchars($value["title"]) . "<br>";
        echo htmlspecialchars($value["category"]) . "<br>";
        echo htmlspecialchars($value["priority"]) . "<br>";
        echo htmlspecialchars($value["status"]) . "<br>";
        echo htmlspecialchars($value["estimated_minutes"]) . "<br>";
        //echo count($value["tags"]);
        for($x = 0; $x < count($value["tags"]); $x++){
            echo htmlspecialchars($value["tags"][$x]);
            if($x + 1 < count($value["tags"])){
                echo ", ";
            }
            else{
                echo "<br>";
            }
        }
        echo "<br>";
    }
?>

</body>
</html>















