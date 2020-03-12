<?php
include("config.php");
require_once 'vendor/autoload.php';
$items = array(); 
$names = array();
$id_mains=201;
$id_starters=101;
function console_log($output, $with_script_tags = true) {
    $js_code = 'console.log(' . json_encode($output, JSON_HEX_TAG) . 
');';
    if ($with_script_tags) {
        $js_code = '<script>' . $js_code . '</script>';
    }
    echo $js_code;
}
if(isset($_POST["startertype"]))
{
$sql = "Select * from Item where Type LIKE '".$_POST["startertype"]."' and Description LIKE 'Starter'";
$result = mysqli_query($db,$sql);
		if($_POST["startertype"] != "")
		{
		    $type = $_POST["startertype"];
		    echo '<div class="veg_title" style="height=50px;background-color:#c6c6c4;font-size:25px;border-top: 1px solid #e7e7e7; border-bottom: 1px solid #c6c6c4;">'.$type.'</div>'; 
			while($row = mysqli_fetch_array($result,MYSQLI_BOTH))
					{
							$name=$row['Name'];
							$price=$row['Price'];
							// $name1 = str_replace(" ","%2520",$name);
							// console_log('https://nutritionix-api.p.rapidapi.com/v1_1/search/'.$name1.'?fields=nf_calories%252Cnf_total_fat');
							$response = Unirest\Request::get("https://trackapi.nutritionix.com/v2/search/instant?query=$name",
  array(
    "x-app-id" => "256ee360",
	"x-app-key" => "9d66ac0fe28cde809dbaf661cf35fd1c"
  )
);
							array_push($names,$name);
	                        $items[$name] = $price;
							$item_id=$row['Item_Id'];
							console_log($response);
							$cal = $response->body->branded[0]->nf_calories;
							$photo = $response->body->branded[0]->photo->thumb;
							//$fat = $response->body->hits[1]->fields->nf_total_fat;
							 echo "<form method='post' action='cart_action.php?action=add&id='".$item_id."'>";
							echo "<div class='v_s' style='height=50px;background-color:white;font-size:18px;border-top: 1px solid #e7e7e7; border-bottom: 1px solid #e7e7e7'>";
							echo "<div class='col-md-10' style='margin-left:13px'>";
							if($type=="Veg")
							echo "<img src='https://png.icons8.com/color/20/000000/vegetarian-food-symbol.png'>";
							else
							echo "<img src='https://png.icons8.com/color/20/000000/non-vegetarian-food-symbol.png'>";
							echo " ".$name."<br>";
							echo "&#8377;".$price."<br>";
							echo "Calories in one Serving : ".$cal."<br>";
							echo '<img src="'.$photo.'" alt="Photo not available" height="100" width="100">';
							echo "</div>";
							echo "<div class='col-md-12'>";
							echo "<div class='col-md-2'> Enter Quantity:</div><div class='col-md-1'><input type='number' name='quantity' class='form-control' value='1' min='1'/></div>";
							echo "<input type='hidden' name='hidden_id' value=$item_id />";
							echo "<input type='hidden' name='hidden_name' value=$name />";
							echo "<input type='hidden' name='hidden_price' value=$price />";
							echo "<div class='col-md-4' style='margin:10px 0px 10px 0px;'><input type='submit' name='add_to_cart' class='btn btn-success' value='Add to Cart' /></div>";
							echo "</div>";
							echo "</div>";
	                        echo "</form>";
							$id_starters+=1;
					}
		}
		else
		{
		    echo '<div class="non_veg_title" style="height=50px;background-color:#c6c6c4;font-size:25px;border-top: 1px solid #e7e7e7; border-bottom: 1px solid #c6c6c4;">Select An Option!</div>';
		}
}
//Mains

if(isset($_POST["mainstype"]))
{
$sql = "Select * from Item where Type LIKE '".$_POST["mainstype"]."' and Description LIKE 'Main Course'";
$result = mysqli_query($db,$sql);
		if($_POST["mainstype"] != "")
		{
		    $type = $_POST["mainstype"];
		    echo '<div class="veg_title" style="height=50px;background-color:#c6c6c4;font-size:25px;border-top: 1px solid #e7e7e7; border-bottom: 1px solid #c6c6c4;">'.$type.'</div>'; 
			while($row = mysqli_fetch_array($result,MYSQLI_BOTH))
					{
							$name=$row['Name'];
							$price=$row['Price'];
	                        array_push($names,$name);
	                        $items[$name] = $price;
	                        $item_id=$row['Item_Id'];
							echo "<form method='post' action='cart_action.php?action=add&id=$item_id>";
							echo "<div class='v_s' style='height=50px;background-color:white;font-size:18px;border-top: 1px solid #e7e7e7; border-bottom: 1px solid #e7e7e7'>";
							echo "<div class='col-md-10' style=''>";
							if($type=="Veg")
							echo "<img src='https://png.icons8.com/color/20/000000/vegetarian-food-symbol.png'>";
							else
							echo "<img src='https://png.icons8.com/color/20/000000/non-vegetarian-food-symbol.png'>";
							echo " ".$name."<br>";
							echo "&#8377;".$price;
							echo "</div>";
						    echo "<div class='col-md-12'>";
							echo "<div class='col-md-2'> Enter Quantity:</div><div class='col-md-1'><input type='number' name='quantity' class='form-control' value='1' min='1'/></div>";
							echo "<input type='hidden' name='hidden_id' value=$item_id />";
							echo "<input type='hidden' name='hidden_name' value=$name />";
							echo "<input type='hidden' name='hidden_price' value=$price />";
							echo "<div class='col-md-4' style='margin:10px 0px 10px 0px;'><input type='submit' name='add_to_cart' class='btn btn-success' value='Add to Cart'/></div>";
							echo "</div>";
							echo "</div>";
							echo "</form>";
							$id_mains+=1;
					}
		}
		else
		{
		    echo '<div class="non_veg_title" style="height=50px;background-color:#c6c6c4;font-size:25px;border-top: 1px solid #e7e7e7; border-bottom: 1px solid #c6c6c4;">Select An Option!</div>';
		}
		//$result1 = mysqli_query($db,$sql);
}
//Salads
if(isset($_POST["saladtype"]))
{
$sql = "Select * from Item where Type LIKE '".$_POST["saladtype"]."' and Description LIKE 'Salad'";
$result = mysqli_query($db,$sql);
		if($_POST["saladtype"] != "")
		{
		    $type = $_POST["saladtype"];
		    echo '<div class="veg_title" style="height=50px;background-color:#c6c6c4;font-size:25px;border-top: 1px solid #e7e7e7; border-bottom: 1px solid #c6c6c4;">'.$type.'</div>'; 
			while($row = mysqli_fetch_array($result,MYSQLI_BOTH))
					{
							$name=$row['Name'];
							$price=$row['Price'];
	                        $item_id=$row['Item_Id'];
							echo "<form method='post' action='cart_action.php?action=add&id=$item_id>";
							echo "<div class='v_s' style='height=50px;background-color:white;font-size:18px;border-top: 1px solid #e7e7e7; border-bottom: 1px solid #e7e7e7'>";
							echo "<div class='col-md-10' style=''>";
							if($type=="Veg")
							echo "<img src='https://png.icons8.com/color/20/000000/vegetarian-food-symbol.png'>";
							else
							echo "<img src='https://png.icons8.com/color/20/000000/non-vegetarian-food-symbol.png'>";
							echo " ".$name."<br>";
							echo "&#8377;".$price;
							echo "</div>";
							echo "<div class='col-md-12'>";
						echo "<div class='col-md-2'> Enter Quantity:</div><div class='col-md-1'><input type='number' name='quantity' class='form-control' value='1' min='1'/></div>";
							echo "<input type='hidden' name='hidden_id' value=$item_id />";
							echo "<input type='hidden' name='hidden_name' value=$name />";
							echo "<input type='hidden' name='hidden_price' value=$price />";
							echo "<div class='col-md-4' style='margin:10px 0px 10px 0px;'><input type='submit' name='add_to_cart' class='btn btn-success' value='Add to Cart' id='add'/></div>";
							echo "</div>";
							echo "</div>";
							echo "</form>";
					}
		}
		else
		{
		    echo '<div class="non_veg_title" style="height=50px;background-color:#c6c6c4;font-size:25px;border-top: 1px solid #e7e7e7; border-bottom: 1px solid #c6c6c4;">Select An Option!</div>';
		}
}
//Dessert
if(isset($_POST["desserttype"]))
{
$sql = "Select * from Item where Type LIKE '".$_POST["desserttype"]."' and Description LIKE 'Dessert'";
$result = mysqli_query($db,$sql);
		if($_POST["desserttype"] != "")
		{
		    $type = $_POST["desserttype"];
		    echo '<div class="veg_title" style="height=50px;background-color:#c6c6c4;font-size:25px;border-top: 1px solid #e7e7e7; border-bottom: 1px solid #c6c6c4;">'.$type.'</div>'; 
			while($row = mysqli_fetch_array($result,MYSQLI_BOTH))
					{
							$name=$row['Name'];
							$price=$row['Price'];
                            $item_id=$row['Item_Id'];
							echo "<form method='post' action='cart_action.php?action=add&id=$item_id>";
							echo "<div class='v_s' style='height=50px;background-color:white;font-size:18px;border-top: 1px solid #e7e7e7; border-bottom: 1px solid #e7e7e7'>";
							echo "<div class='col-md-10' style=''>";
							if($type=="Veg")
							echo "<img src='https://png.icons8.com/color/20/000000/vegetarian-food-symbol.png'>";
							else
							echo "<img src='https://png.icons8.com/color/20/000000/non-vegetarian-food-symbol.png'>";
							echo " ".$name."<br>";
							echo "&#8377;".$price;
							echo "</div>";
						echo "<div class='col-md-12'>";
							echo "<div class='col-md-2'> Enter Quantity:</div><div class='col-md-1'><input type='number' name='quantity' class='form-control' value='1' min='1'/></div>";
							echo "<input type='hidden' name='hidden_id' value=$item_id />";
							echo "<input type='hidden' name='hidden_name' value=$name />";
							echo "<input type='hidden' name='hidden_price' value=$price />";
							echo "<div class='col-md-4' style='margin:10px 0px 10px 0px;'><input type='submit' name='add_to_cart' class='btn btn-success' value='Add to Cart'/></div>";
							echo "</div>";
							echo "</div>";
							echo "</form>";
					}
		}
		else
		{
		    echo '<div class="non_veg_title" style="height=50px;background-color:#c6c6c4;font-size:25px;border-top: 1px solid #e7e7e7; border-bottom: 1px solid #c6c6c4;">Select An Option!</div>';
		}
}

//Drinks

if(isset($_POST["drinktype"]))
{
$sql = "Select * from Item where Type LIKE '".$_POST["drinktype"]."' and Description LIKE 'Drinks'";
$result = mysqli_query($db,$sql);
		if($_POST["drinktype"] != "")
		{
		    $type = $_POST["drinktype"];
		    echo '<div class="veg_title" style="height=50px;background-color:#c6c6c4;font-size:25px;border-top: 1px solid #e7e7e7; border-bottom: 1px solid #c6c6c4;">'.$type.'</div>'; 
			while($row = mysqli_fetch_array($result,MYSQLI_BOTH))
					{
							$name=$row['Name'];
							$price=$row['Price'];
	                        $item_id=$row['Item_Id'];
							echo "<form method='post' action='cart_action.php?action=add&id=$item_id>";
							echo "<div class='v_s' style='height=50px;background-color:white;font-size:18px;border-top: 1px solid #e7e7e7; border-bottom: 1px solid #e7e7e7'>";
							echo "<div class='col-md-10' style=''>";
							echo "<img src='https://png.icons8.com/color/20/000000/vegetarian-food-symbol.png'>";
							echo " ".$name."<br>";
							echo "&#8377;".$price;
							echo "</div>";
					        echo "<div class='col-md-12'>";
							echo "<div class='col-md-2'> Enter Quantity:</div><div class='col-md-1'><input type='number' name='quantity' class='form-control' value='1' min='1'/></div>";
							echo "<input type='hidden' name='hidden_id' value=$item_id />";
							echo "<input type='hidden' name='hidden_name' value=$name />";
							echo "<input type='hidden' name='hidden_price' value=$price />";
							echo "<div class='col-md-4' style='margin:10px 0px 10px 0px;'><input type='submit' name='add_to_cart' class='btn btn-success' value='Add to Cart'/></div>";
							echo "</div>";
							echo "</div>";
							echo "</form>";
					}
		}
		else
		{
		    echo '<div class="non_veg_title" style="height=50px;background-color:#c6c6c4;font-size:25px;border-top: 1px solid #e7e7e7; border-bottom: 1px solid #c6c6c4;">Select An Option!</div>';
		}
}
?>






      