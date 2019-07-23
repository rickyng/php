<?php 
foreach($stmt as $row){
    extract($row);
 
    // creating box
    echo "<div class='col-md-4 m-b-20px'>";
 
        // product id for javascript access
        echo "<div class='product-id display-none'>{$id}</div>";
 
        echo "<a href='product.php?id={$id}' class='product-link'>";
            // select and show first product image

            $stmt_product_image=$product_image->readBy('product_id', $id)[0];
   
            echo "<div class='m-b-10px'>";
                echo "<img src='images/{$stmt_product_image['name']}' class='w-100-pct' />";
            echo "</div>";
           
 
            // product name
            echo "<div class='product-name m-b-10px'>{$name}</div>";
        echo "</a>";
 
        // product price and category name
            echo "<div class='m-b-10px'>";
                echo "&#36;" . number_format($price, 2, '.', ',');
            echo "</div>";
 
            // add to cart button
            echo "<div class='m-b-10px'>";
                // cart item settings
                $user_id=1; // we default to a user with ID "1" for now
                echo $user_id . " ". $id . "<br>";
                // if product was already added in the cart
                if($cart_item->exists($user_id, $id)){
                    echo "<a href='cart.php' class='btn btn-success w-100-pct'>";
                        echo "Update Cart";
                    echo "</a>";
                }else{
                    echo "<a href='add_to_cart.php?id={$id}&page={$page}' class='btn btn-primary w-100-pct'>Add to Cart</a>";
                }
            echo "</div>";
 
 
 
    echo "</div>";
}
 
include_once "paging.php";
?>