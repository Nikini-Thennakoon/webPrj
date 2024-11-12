<?php 
include "config.php"; 

// Fetch the post ID from the URL
$post_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$item_details = [];

// Query to get the item details based on the post ID
if ($post_id > 0) {
    $sql = "SELECT * FROM post WHERE post_id = $post_id";
    $result = mysqli_query($config, $sql);
    if ($result && mysqli_num_rows($result) > 0) {
        $item_details = mysqli_fetch_assoc($result);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clothing Order Form</title>
    <link rel="stylesheet" href="order.css">
</head>
<body>
    <div class="container">
        <h1>Order Form</h1>
        <form action="" method="POST">
            <fieldset>
                <legend>Personal Information</legend>
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" required>
                
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
                
                <label for="phone">Phone:</label>
                <input type="tel" id="phone" name="phone" required>
            </fieldset>
            
            <fieldset>
                <legend>Order Details</legend>
                
                <?php if ($item_details): ?>
                    <input type="hidden" name="post_id" value="<?= $item_details['post_id'] ?>">
                    <p>Item: <?= $item_details['post_title'] ?></p>
                    <input type="hidden" name="item_name" value="<?= $item_details['post_title'] ?>">
                <?php else: ?>
                    <p>Item: No item selected</p>
                <?php endif; ?>
                
                <label for="clothing-type">Clothing Type:</label>
                <select id="clothing-type" name="clothing_type" required>
                    <option value="shirt">Shirt</option>
                    <option value="tshirt">T-Shirt</option>
                    <option value="pants">Pants</option>
                    <option value="jacket">Jacket</option>
                </select>
                
                <label for="size">Size:</label>
                <select id="size" name="size" required>
                    <option value="small">Small</option>
                    <option value="medium">Medium</option>
                    <option value="large">Large</option>
                    <option value="xl">XL</option>
                </select>
                
                <label for="quantity">Quantity:</label>
                <input type="number" id="quantity" name="quantity" min="1" required>
            </fieldset>
            
            <fieldset>
                <legend>Shipping Address</legend>
                <label for="address">Address:</label>
                <input type="text" id="address" name="address" required>
                
                <label for="city">City:</label>
                <input type="text" id="city" name="city" required>
                
                <label for="state">Province:</label>
                <input type="text" id="state" name="state" required>
                
                <label for="zip">Zip Code:</label>
                <input type="text" id="zip" name="zip" required>
            </fieldset>
            <button type="submit" name="order" class="btn btn-primary">Submit Order</button>
        </form>
    </div>
</body>
</html>

<?php 
if (isset($_POST['order'])) {
    // Sanitize and validate input data
    $post_id = intval($_POST['post_id']);  // Ensure post_id is an integer and valid
    if ($post_id > 0) {
        // Fetch the item name from the database to avoid tampering
        $sql = "SELECT post_title FROM post WHERE post_id = $post_id";
        $result = mysqli_query($config, $sql);
        if ($result && mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $item_name = $row['post_title'];
        } else {
            $item_name = "Unknown";
        }
    } else {
        $item_name = "Unknown";
    }

    $name = mysqli_real_escape_string($config, $_POST['name']);
    $email = mysqli_real_escape_string($config, $_POST['email']);
    $phone = mysqli_real_escape_string($config, $_POST['phone']);
    $clothing_type = mysqli_real_escape_string($config, $_POST['clothing_type']);
    $size = mysqli_real_escape_string($config, $_POST['size']);
    $quantity = mysqli_real_escape_string($config, $_POST['quantity']);
    $address = mysqli_real_escape_string($config, $_POST['address']);
    $city = mysqli_real_escape_string($config, $_POST['city']);
    $state = mysqli_real_escape_string($config, $_POST['state']);
    $zip = mysqli_real_escape_string($config, $_POST['zip']);

    // Insert data into the orders table
    $sql = "INSERT INTO orders (item_name, name, email, phone, clothing_type, size, quantity, address, city, state, zip) 
            VALUES ('$item_name', '$name', '$email', '$phone', '$clothing_type', '$size', $quantity, '$address', '$city', '$state', '$zip')";
    $query = mysqli_query($config, $sql);
    
    if ($query) {
        $msg = ['Order has been placed successfully', 'alert-success'];
        $_SESSION['msg'] = $msg;
        header("Location: order.php");
    } else {
        $msg = ['Failed, please try again', 'alert-danger'];
        $_SESSION['msg'] = $msg;
        header("Location: order.php");
    }
}
?>
