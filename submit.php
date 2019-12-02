<?php

require("score.php");
$score = new Score();

$score->set_display_name(test_input($_POST["displayName"]));
$score->set_score(test_input($_POST["score"]));
$score->set_display_time(date("Y-m-d"));

if (validate_data($score))
{
    store_score($score);
}
else
{
    show_result(false, "Display name is required to submit a score.");
}

function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);

    return $data;
}

function validate_data($score)
{
    if ($score->get_display_name() == "")
    {
        show_result(false, "Display Name cannot be Empty.");
    }
}

function store_score($score)
{
    $servername = "localhost";
    $sqlusername = "sp2976";
    $password = "sp2976";
    $dbname = "spaceinvaders";

    try
    {
        $conn = new mysqli($servername, $sqlusername, $password, $dbname);
        $sql = mysqli_prepare($conn, "INSERT INTO scores (display_name, score, time) VALUES (?, ?, ?)");
        mysqli_stmt_bind_param($sql, 'sss', $name, $score_out, $time);
        $name = $score->get_display_name(); 
        $score_out = $score->get_score(); 
        $time = $score->get_display_time();

        mysqli_stmt_execute($sql);
        mysqli_stmt_close($sql);

        mysqli_close($conn);

        show_result(true, "success");
    }
    catch (Exception $e)
    {
        show_result(false, "There was an issue storing data to the database.");
    }
}

function show_result($success, $message)
{
    echo <<<END
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
            <h3>Score Submission</h3>
END;

    if ($success)
    {
        echo "<h4>Success!</h4>";
        echo "<p>Your score has been successfully submitted. If it is in the top 5, you will see it when you return to the game screen!</p>";
    }
    else
    {
        echo "<h4>Oh no!</h4>";
        echo "<p>Your score was not able to be submitted at this time. Any additional information available is below:</p>";
        echo "<p>$message</p>";
    }

    echo <<<END
            <a href="index.php"><button class="btn btn-primary">Return</button></a>
        </div>
    </body>
    </html>
END;
}

?>
