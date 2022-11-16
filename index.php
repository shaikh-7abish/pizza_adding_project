<?php
include('config/db_connect.php');

//query for data
$select = 'SELECT title, ingredients, id FROM pizzas ORDER BY created_at';

//getting resulting using running query
$result = mysqli_query($conn, $select);

// fetching the result to get data
$pizzas = mysqli_fetch_all($result, MYSQLI_ASSOC);

// free variable from memory
mysqli_free_result($result);

// closing the connection
mysqli_close($conn);

// printing data
// print_r($pizzas);

?>
<!DOCTYPE html>
<html lang="en">
<?php
include('templates/header.php');
?>

<h3 class="center">Pizzas !</h3>
<div class="row">
    <?php foreach ($pizzas as $pizza) : ?>
        <div class="card">
            <img src="img/pizza.svg" alt="pizza image" class="image">
            <div class="content flex ">
                <h6 class="center">
                    <?php echo htmlspecialchars($pizza['title']); ?>
                </h6>
                <ul class="center">
                    <?php foreach (explode(',', $pizza['ingredients']) as $ing) { ?>
                        <li><?php echo htmlspecialchars($ing); ?></li>
                    <?php }; ?>
                </ul>
            </div>
            <div class="action">
                <a href="details.php?id=<?php echo $pizza['id']; ?>" class="brand center">more info</a>
            </div>
        </div>
    <?php endforeach; ?>
</div>


<?php
include('templates/footer.php');
?>
</body>

</html>