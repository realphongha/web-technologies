<html>
    <head>
        <title>Date and time form</title>
    </head>
    <body>
        <?php 
            function is_leap_year($year){
                return ($year%4 == 0 && $year%100 != 0) || ($year%100 == 0 && $year%400 == 0);
            }
            
            function get_num_days($month, $year){
                switch($month){
                    case 1:
                    case 3:
                    case 5:
                    case 7:
                    case 8:
                    case 10:
                    case 12:
                        return "31";
                    case 4:
                    case 6:
                    case 9:
                    case 11:
                        return "30";
                    case 2:
                        return is_leap_year($year) ? "29" : "28";
                    default:
                        break;
                }
            }
            
            function str($i){
                return $i>=10 ? $i : "0" . $i; 
            }
            
            function to_date_str($y, $m, $d, $h, $mm, $s){
                return str($h) . ":" . str($mm) . ":" . str($s) . ", " . 
                       str($d) . "/" . str($m) . "/" . $y;
            }
            
            function to_date_str_12h($y, $m, $d, $h, $mm, $s){
                return str($h%12) . ":" . str($mm) . ":" . str($s) . 
                        ($h/12==0?" AM":" PM") . ", " . 
                        str($d) . "/" . str($m) . "/" . $y;
            }
            
            $name = filter_input(INPUT_POST, "name");
            $year = filter_input(INPUT_POST, "year");
            $month = filter_input(INPUT_POST, "month"); 
            $day = filter_input(INPUT_POST, "day"); 
            $hour = filter_input(INPUT_POST, "hour"); 
            $minute = filter_input(INPUT_POST, "minute"); 
            $second = filter_input(INPUT_POST, "second");
            if ((empty($name) || !isset($year) || !isset($month) || !isset($day) 
                    || !isset($hour) || !isset($minute) || !isset($second))){
                echo "Please fill all the required fields!<br>";
            } else {
                echo "Hi " . $name . "!<br>";
                echo "You have choose to have an appointment on " . 
                        to_date_str($year, $month, $day, $hour, $minute, $second) . "<br>";
                echo "More information:<br>";
                echo "In 12 hours, the time and date is " . 
                        to_date_str_12h($year, $month, $day, $hour, $minute, $second) . "<br>";
                echo "This month has " . get_num_days($month, $year) . " days!<br>";
                
            }
        ?>
        <a href="date-time-form.php">Back</a>
    </body>
</html>

