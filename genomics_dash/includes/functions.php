<?php
// functions.php
function isTransition($mutation) {
    $ts = ["A>G", "G>A", "C>T", "T>C"];
    return in_array($mutation, $ts);
}

function classifyIndel($ref, $alt) {
    if (strlen($ref) > strlen($alt)) return "Deletion";
    if (strlen($alt) > strlen($ref)) return "Insertion";
    return "SNP";
}
?>
