<?php

class Score
{
    public $display_name;
    public $score;
    public $display_time;

    function set_display_name($name)
    {
        $this->display_name = $name;
    }

    function get_display_name()
    {
        return $this->display_name;
    }

    function set_score($score_in)
    {
        $this->score = $score_in;
    }

    function get_score()
    {
        return $this->score;
    }

    function set_display_time($time)
    {
        $this->display_time = $time;
    }

    function get_display_time()
    {
        return $this->display_time;
    }
}

?>
