<html>
    <head>
        <title>A simple form</title>
        <script>
            function displayHeight(){
                document.getElementById("display-height").innerHTML = 
                        document.getElementById("height").value;
            }
            function resetDefaultHeight(){
                document.getElementById("height").value = 170;
                document.getElementById("display-height").innerHTML = 170;
            }
        </script>
    </head>
    <body>
        <h1>Enter your information</h1>
        <form action="process.php" method="post">
            
            <label for="name">Name:</label><br>
            <input type="text" id="name" name="name"><br>
            
            <label for="password">Password:</label><br>
            <input type="password" id="password" name="password"><br>
            
            <label for="birthdate">Birthdate:</label><br>
            <input type="date" id="birthdate" name="birthdate"><br>
            
            <label for="email">Email:</label><br>
            <input type="email" id="email" name="email"><br>
            
            <label for="age">Age:</label><br>
            <input type="number" id="age" name="age" min="1" max="99"><br>
         
            <label for="phone">Phone number:</label><br>
            <input type="tel" id="phone" name="phone"><br>
            
            <label for="height">Height (in cm):</label><br>
            <input type="range" id="height" name="height" min="100" max="210" 
                   value="170" onchange="displayHeight()">
            <p id="display-height">170</p>
            
            Gender<br>
            <input type="radio" id="male" name="gender" value="male">
            <label for="male">Male</label><br>
            <input type="radio" id="female" name="gender" value="female">
            <label for="male">Female</label><br>
            
            Hobbies<br>
            <input type="checkbox" id="sport" name="hobbies[]" value="sport">
            <label for="sport">Sports</label><br>
            <input type="checkbox" id="book" name="hobbies[]" value="book">
            <label for="book">Books</label><br>
            <input type="checkbox" id="music" name="hobbies[]" value="music">
            <label for="music">Musics</label><br><br>
            
            <input type="submit" value="Submit"/>
            <input type="reset" value="Reset form" onclick="resetDefaultHeight()"><br>
        </form>
    </body>
</html>

