<?php

include('config/db_connect.php');

$email = $title = $ingredients = ''; // creating variables because we will need it to display 
$errors = array('email' => '', 'title' => '', 'ingredients' => ''); // this will contain errors

if (isset($_POST['submit'])) { // checking / validating data after user clicked the submit button

    //checking email
    if (empty($_POST['email'])) { //checking whether email is empty or not
        $errors['email'] = '*An Email is required* <br/>';
    } else { // if not empty then validation
        $email = $_POST['email']; // making a variable for email this contains the user input email
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) { //checking whether the email add. is validated or not.
            $errors['email'] = '*Enter a valid Email address*' . '<br/>';
        }
    };

    // checking title
    if (empty($_POST['title'])) {
        $errors['title'] = '*The Title is required* <br/>';
    } else {
        $title = $_POST['title'];
        if (!preg_match('/^[a-zA-Z\s]+$/', $title)) { //checking whether the title is suitable or not.
            $errors['title'] = '*Title must be letters and space only*' . '<br/>';
        }
    };

    // checking ingredients
    if (empty($_POST['ingredients'])) {
        $errors['ingredients'] = '*At least one ingredients is required* <br/>';
    } else {
        $ingredients = $_POST['ingredients'];
        if (!preg_match('/^([a-zA-Z\s]+)(,\s*[a-zA-Z\s]*)*$/', $ingredients)) { //checking whether the ingredients is comma separated or not.
            $errors['ingredients'] = '*Ingredients must be comma separated list*' . '<br/>';
        }
    };

    if (array_filter($errors)) { // checking whether $errors are empty or not -- if not empty then continuing to show errors
    } else { // if errors are empty then going to index page
        $email = mysqli_real_escape_string($conn, $_POST['email']); // escaping sql injections
        $title = mysqli_real_escape_string($conn, $_POST['title']);
        $ingredients = mysqli_real_escape_string($conn, $_POST['ingredients']);

        // inserting values query
        $sql_insert = "INSERT INTO pizzas (title, email, ingredients) VALUES ('$title','$email','$ingredients')";

        // save to db and check
        if (mysqli_query($conn, $sql_insert)) {
            //success
            header('Location: index.php'); // putting location to header to return to home / redirecting to homepage
        } else {
            //errors
            echo 'query error' . mysqli_error($conn);
        };
    };
};

?>
<!DOCTYPE html>
<html lang="en">
<?php
include('templates/header.php');
// importing header of the page
?>

<section class="container">
    <h4 class="center title">Add a Pizza</h4>

    <form action="<?php echo $PHP_SELF; ?>" method="POST" class="form flex">
        <!--action will return the user input to add.php file, method post is secure -->

        <label for="">Your Email:</label>
        <input type="email" name="email" value="<?php echo htmlspecialchars($email); ?>"> <!-- value will be the wrong input given by the user -->
        <div class="red"><?php echo $errors['email']; ?></div> <!-- showing warning to user-->

        <label for="">Pizza Title:</label>
        <input type="text" name="title" value="<?php echo htmlspecialchars($title); ?>">
        <div class="red"><?php echo $errors['title']; ?></div>

        <label for="">Ingredients:</label>
        <input type="text" name="ingredients" value="<?php echo htmlspecialchars($ingredients); ?>">
        <div class="red"><?php echo $errors['ingredients']; ?></div>

        <div class="center transparent">
            <input type="submit" name="submit" value="submit" class="btn brand">
            <!--user will submit the form using this btn-->
        </div>

    </form>

</section>

<?php
include('templates/footer.php');
// importing footer of the page
?>
</body>

</html>