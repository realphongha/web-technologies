<html>
    <head>
        <title>Date and time form</title>
    </head>
    <body>
        <h1>Enter your name and select date and time for the appointment.</h1>
        <form action="process.php" method="post">
            
            <label for="name">Your name:</label><br>
            <input type="text" id="name" name="name"><br>
            
            Date:<br>
            <select name="day">
                <?php
                for ($i = 1; $i <= 31; $i++){
                    echo "<option value='" . $i . "'>" . $i . "</option>";
                } 
                ?>
            </select>
            <select name="month">
                <?php
                for ($i = 1; $i <= 12; $i++){
                    echo "<option value='" . $i . "'>" . $i . "</option>";
                } 
                ?>
            </select>
            <select name="year">
                <?php
                for ($i = 2000; $i <= 2100; $i++){
                    echo "<option value='" . $i . "'>" . $i . "</option>";
                } 
                ?>
            </select>
            <br>
            Time:<br>
            <select name="hour">
                <?php
                for ($i = 0; $i <= 23; $i++){
                    echo "<option value='" . $i . "'>" . $i . "</option>";
                } 
                ?>
            </select>
            <select name="minute">
                <?php
                for ($i = 0; $i <= 60; $i++){
                    echo "<option value='" . $i . "'>" . $i . "</option>";
                } 
                ?>
            </select>
            <select name="second">
                <?php
                for ($i = 0; $i <= 60; $i++){
                    echo "<option value='" . $i . "'>" . $i . "</option>";
                } 
                ?>
            </select>
            <br><br>
            <input type="submit" value="Submit"/>
            <input type="reset" value="Reset form"><br>
        </form>
    </body>
</html>

