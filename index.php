<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Space Invaders</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="main.css" />
    <script src="https://code.jquery.com/jquery-3.4.1.js" integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU=" crossorigin="anonymous"></script>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</head>
<body>
    <div class="container text-center">
        <h1>Space Invaders</h1>
        <section>
            <h3>How to Play</h3>
            <p>
                You will play as a green ship, scrolling left to right on the bottom of the playing area. Your goal is to destroy 
                all of the enemy ships, who will be coming toward you from the top of the screen in multiple rows. If any ship is able to 
                touch your ship, you will lose the game. If an enemy is able to shoot your ship, you will lose a life. If you lose all your
                lives, you will lose the game. Your goal is to score the most points before your game ends.
            </p>
        </section>
        <section>
            <h3>Credits</h3>
            <p>
                Inspiration, reference, and sprite sheets were acquired from 
                <a href="https://codepen.io/adelciotto/pen/BHuGL">adelciotto's codepen.io entry</a>.
            </p>
        </section>
        <section>
            <h3>Controls</h3>
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">Key</th>
                        <th scope="col">Operation</th>
                    </tr>
                </thead>
                <tbody>
                    <tr scope="row">
                        <td style="font-size:2em;">&#8592;</td>
                        <td>Move Left</td>
                    </tr>
                    <tr scope="row">
                        <td style="font-size:2em;">&#8594;</td>
                        <td>Move Right</td>
                    </tr>
                    <tr scope="row">
                        <td><b>SPACEBAR</b></td>
                        <td>Shoot</td>
                    </tr>
                </tbody>
            </table>
        </section>
    </div>

    <div class="container text-center">
        <canvas id="game-canvas" width="640px" height="640px"></canvas>
    </div>

    <div class="container text-center">
        <section>
            <h3>Submit Score</h3>
            <form name="scoreSubmit" action="submit.php">
                <label for="displayName">Display Name</label><br>
                <input type="text" name="displayName"><br><br>
                <input type="hidden" name="score" id="scoreInput">
                <input type="submit" value="Submit Score" class="btn btn-primary">
            </form>
        </section>
        <section>
            <h3>High Scores</h3>
            <?php

            require("score.php");
            $GLOBALS["error"] = "Sorry! We were unable to retrieve scores at this time.";
            $Globals["scores"] = array();

            if (top_scores_obtained()) 
            {
                echo "<table class='table'>";
                    echo "<thead>";
                        echo "<tr>";
                            echo "<th scope='col'>Rank</th>";
                            echo "<th scope='col'>Display Name</th>";
                            echo "<th scope='col'>Score</th>";
                            echo "<th scope='col'>Time Occurred</th>";
                            echo "</tr>";
                        echo "</thead>";
                    echo "<tbody>";
                        show_top_scores();
                    echo "</tbody>";
                echo "</table>";
            }
            else
            {
                $errorMessage = $GLOBALS["error"];
                echo "<p>$errorMessage</p>";
            }

            ?>
        </section>
    </div>

    <?php
    
    function top_scores_obtained()
    {
        $servername = "localhost";
        $sqlusername = "sp2976";
        $password = "sp2976";
        $dbname = "spaceinvaders";

        $conn = new mysqli($servername, $sqlusername, $password, $dbname);
        $sql = "SELECT display_name, score, DATE_FORMAT(time, '%d-%m-%Y') AS display_time FROM scores ORDER BY score LIMIT TOP 5";

        if ($conn->connect_errno) 
        {
            $GLOBALS["error"] = $GLOBALS["error"] . " There was an issue establishing the connection to the database.";
            return false;
        }
        else
        {
            try
            {
                $results = mysqli_query($conn, $sql);
                if (mysqli_num_rows($results)) 
                {
                    while ($row = mysqli_fetch_assoc($results)) 
                    {
                        $score = new Score();
                        
                        $score->set_display_name($row["display_name"]);
                        $score->set_score($row["score"]);
                        $score->set_display_time($row["display_time"]);

                        array_push($GLOBALS["scores"], $score);
                    }
                }
                else 
                {
                    $GLOBALS["error"] = $GLOBALS["error"] . " There was an issue retrieving results once the connection was made.";
                    return false;
                }
            }
            catch (Exception $e)
            {
                $GLOBALS["error"] = $GLOBALS["error"] . " There was an issue moving results to useful data structures.";
                return false;
            }

            return true;
        }
    }

    function show_top_scores()
    {
        foreach($i = 0; $i < count($GLOBALS["scores"]); $i++)
        {
            $score = $GLOBALS["scores"][$i];
            $display_name = $score->get_display_name();
            $score_display = $score->get_score();
            $display_time = $score->get_display_time();

            echo "<tr>";
                echo "<td>$i</td>"
                echo "<td>$display_name</td>"
                echo "<td>$score_display</td>"
                echo "<td>$display_time</td>"
            echo "</tr>";
        }
    }

    ?>

    <script src="main.js"></script>    
</body>
</html>
