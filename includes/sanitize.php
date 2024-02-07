<?php
    function sanitize_text($strt){ // Sanitization function for text strings.

        return sanitize_text_field($strt); // Sanitize the input text with WordPress function.
    }
    function sanitize_number($int){ // Sanitization function for integers.

        return absint($int); // Sanitize the input integer with WordPress function.
    }
    function sanitize_boolean($bool){ // Sanitization function for boolean values.
        
        return boolval($bool); // PHP function to convert inputs to a boolean value.
    }
?>