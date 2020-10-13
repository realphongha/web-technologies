<html>
    <head>
        <title>Process form</title>
    </head>
    <body>
        <?php 
            echo '<h1>Hello!</h1>';
            $name = filter_input(INPUT_POST, 'name');
            $password = filter_input(INPUT_POST, 'password');
            $birthdate = filter_input(INPUT_POST, 'birthdate');
            $email = filter_input(INPUT_POST, 'email');
            $age = filter_input(INPUT_POST, 'age');
            $phone = filter_input(INPUT_POST, 'phone');
            $height = filter_input(INPUT_POST, 'height');
            $gender = filter_input(INPUT_POST, 'gender');
            $hobbies = filter_input(INPUT_POST, 'hobbies', FILTER_DEFAULT, FILTER_FORCE_ARRAY);
            if (!empty($name)){
                echo 'Your name is ' . $name . '.<br>';
            }
            if (!empty($password)){
                echo 'Your password is ' . $password . '.<br>';
            }
            if (!empty($birthdate)){
                echo 'Your birthdate is ' . $birthdate . '.<br>';
            }
            if (!empty($email)){
                echo 'Your email is ' . $email . '.<br>';
            }
            if (!empty($age)){
                echo 'Your age is ' . $age . '.<br>';
            }
            if (!empty($phone)){
                echo 'Your phone number is ' . $phone . '.<br>';
            }
            if (!empty($height)){
                echo 'Your height is ' . $height . ' cm.<br>';
            }
            if (!empty($gender)){
                echo 'Your gender is ' . $gender . '.<br>';
            }
            if (!empty($hobbies)){
                echo 'Your hobbies: ' . implode(', ', $hobbies) . '.<br>';
            }
        ?>
    </body>
</html>

