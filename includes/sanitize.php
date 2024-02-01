<?php
    function sanitize_text($strt){

        return sanitize_text_field($strt);
    }

    function sanitize_number($int){

        return absint($int);
    }
?>