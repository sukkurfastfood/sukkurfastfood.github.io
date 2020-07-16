<?php 

if(!session_id())
session_start();
#cart.php - A simple shopping cart with add to cart, and remove links
 //---------------------------
 //initialize sessions

//Define the products and cost
$products = array("Chicken Burger", "Chicken Mushroom", "Chicken Jelepano", "Beef Burger", "Beef Mushroom", "Beef Jelepano", "ZingO Burger", "ZingO Ring", "ZingO Jelepano", "Sizzling Hot Broast Qtr", "Sizzling Hot Broast half", "Sizzling Hot Broast Full", "Plain Fries Regular", "Plain Fries Medium", "Plain Fries Large", "Soft Drink Can", "Mineral Water (small)", "Mineral Water (Large)", "Deal 1", "Deal 2", "Deal 3");
$amounts = array("199", "299", "229", "229", "249", "239", "219", "249", "235", "229", "459", "919", "49", "99", "149", "50", "35", "60", "300", "290", "360");

//Load up session
 if ( !isset($_SESSION["total"]) ) {
   $_SESSION["total"] = 0;
   for ($i=0; $i< count($products); $i++) {
    $_SESSION["qty"][$i] = 0;
   $_SESSION["amounts"][$i] = 0;
  }
 }

 //---------------------------
 //Reset
 if ( isset($_GET['reset']) )
 {
 if ($_GET["reset"] == 'true')
   {
   unset($_SESSION["qty"]); //The quantity for each product
   unset($_SESSION["amounts"]); //The amount from each product
   unset($_SESSION["total"]); //The total cost
   unset($_SESSION["cart"]); //Which item has been chosen
   }
 }

 //---------------------------
 //Add
 if ( isset($_GET["add"]) )
   {
   $i = $_GET["add"];
   $qty = $_SESSION["qty"][$i] + 1;
   $_SESSION["amounts"][$i] = $amounts[$i] * $qty;
   $_SESSION["cart"][$i] = $i;
   $_SESSION["qty"][$i] = $qty;
 }

  //---------------------------
  //Delete
  if ( isset($_GET["delete"]) )
   {
   $i = $_GET["delete"];
   $qty = $_SESSION["qty"][$i];
   $qty--;
   $_SESSION["qty"][$i] = $qty;
   //remove item if quantity is zero
   if ($qty == 0) {
    $_SESSION["amounts"][$i] = 0;
    unset($_SESSION["cart"][$i]);
  }
 else
  {
   $_SESSION["amounts"][$i] = $amounts[$i] * $qty;
  }
 }
 ?>
 <h1 style="background-color:blue">List of All Items</h1>
 <table>
   <tr>
   <th>Item</th>
   <th width="10px">&nbsp;</th>
   <th>Amount</th>
   <th width="10px">&nbsp;</th>
   <th>Action</th>
   </tr>
 <?php
 for ($i=0; $i< count($products); $i++) {
   ?>
   <tr>
   <td><?php echo($products[$i]); ?></td>
   <td width="10px">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
   <td><?php echo($amounts[$i]); ?></td>
   <td width="10px">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
   <td><a href="?add=<?php echo($i); ?>">Add to cart</a></td>
   </tr>
   <?php
 }
 ?>
 <tr>
 <td colspan="5"></td>
 </tr>
 <tr>
 <td colspan="5"><a href="?reset=true">Reset Cart</a></td>
 </tr>
 </table>
 <?php
 if ( isset($_SESSION["cart"]) ) {
 ?>
 <br/><br/><br/>
 <h2>Cart</h2>
 <table>
 <tr>
 <th>Item</th>
 <th width="10px">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
 <th>Qty</th>
 <th width="10px">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
 <th>Amount</th>
 <th width="10px">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
 <th>Action</th>
 </tr>
 <?php
 $total = 0;
 foreach ( $_SESSION["cart"] as $i ) {
 ?>
 <tr>
 <td><?php echo( $products[$_SESSION["cart"][$i]] ); ?></td>
 <td width="10px">&nbsp;</td>
 <td><?php echo( $_SESSION["qty"][$i] ); ?></td>
 <td width="10px">&nbsp;</td>
 <td><?php echo( $_SESSION["amounts"][$i] ); ?></td>
 <td width="10px">&nbsp;</td>
 <td><a href="?delete=<?php echo($i); ?>">Delete from cart</a></td>
 </tr>
 <?php
 $total = $total + $_SESSION["amounts"][$i];
 }
 $_SESSION["total"] = $total;
 ?>
 <tr>
 <td colspan="7">Total : <?php echo($total); ?></td>
 </tr>
 </table>
 <?php
 }
 ?>