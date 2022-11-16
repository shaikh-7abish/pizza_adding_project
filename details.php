<?php

// including db connection
include('config/db_connect.php');

// if delete button is clicked or not
if (isset($_POST['delete'])) {
    // saving the id into local variable
    $id_to_delete = mysqli_real_escape_string($conn, $_POST['id_to_delete']);

    // sql query
    $delete_query = "DELETE FROM pizzas WHERE id = $id_to_delete";

    if (mysqli_query($conn, $delete_query)) {
        //success then homepage
        header('location: index.php');
    } else {
        //failure error message
        echo 'query error: ' . mysqli_error($conn);
    }
}

//check GET request id parameter
if (isset($_GET['id'])) {
    $id = mysqli_real_escape_string($conn, $_GET['id']); // escaping injections and getting data
    $sql_data = "SELECT * FROM pizzas WHERE id = $id"; // query to get data
    $result = mysqli_query($conn, $sql_data); // running query and getting data
    $pizza = mysqli_fetch_assoc($result); // fetch result in array format
    mysqli_free_result($result); // emptying the result variable
    mysqli_close($conn); // closing the connection
};
?>
<!DOCTYPE html>
<html>
<?php include('templates/header.php'); ?>

<div class="details">
    <div class="detail">
        <?php if ($pizza) : ?>
            <!-- checking if pizza is present or not -->
            <!-- printing data -->
            <h4><?php echo htmlspecialchars($pizza['title']); ?></h4>
            <p>Created by: <?php echo htmlspecialchars($pizza['email']); ?></p>
            <p><?php echo date($pizza['created_at']); ?></p>
            <h5>Ingredients</h5>
            <p><?php echo htmlspecialchars($pizza['ingredients']); ?></p>

            <!-- Delete form -->
            <form action="?<?php echo $PHP_SELF; ?>" method="POST">
                <input type="hidden" name="id_to_delete" value="<?php echo $pizza['id']; ?>">
                <input type="submit" name="delete" value="Delete" class="btn">
            </form>

        <?php else : ?>
            <!-- if no such pizza available then -->
            <h5>No such pizza exists !</h5>
        <?php endif ?>
    </div>
</div>



<?php include('templates/footer.php'); ?>

</html>