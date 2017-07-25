<?php

echo '<div class="w3-row question">';
echo '    <span class="w3-col m3 s4"></span>';
echo '    <span class="w3-col m3 s4">Avaliações</span>';
echo '</div>';
echo '<hr />';

for ($x = 0; $x < count($retornoclass); $x++) {
    $starx = 'star' . $x;
    echo '<div class="w3-row question">';
    echo '    <span class="w3-col m3 s4"></span>';
    echo '    <div class="rating rating-wrapper w3-col m5 s10">';

    echo '    <input type="radio" id="' . $starx . '5" disabled name="rating' . $x . '" value="5"   />';
    echo '    <label class="full" for="' . $starx . '5" title="Muito satisfeito"></label>';

    echo '    <input type="radio" id="' . $starx . '4" disabled name="rating' . $x . '" value="4" />';
    echo '    <label class="full" for="' . $starx . '4" title="Satisfeito"></label>';

    echo '    <input type="radio" id="' . $starx . '3" disabled name="rating' . $x . '" value="3" />';
    echo '    <label class="full" for="' . $starx . '3" title="Parcialmente"></label>';

    echo '    <input type="radio" id="' . $starx . '2" disabled name="rating' . $x . '" value="2" />';
    echo '    <label class="full" for="' . $starx . '2" title="Insatisfeito"></label>';

    echo '    <input type="radio" id="' . $starx . '1" disabled name="rating' . $x . '" value="1" />';
    echo '    <label class="full" for="' . $starx . '1" title="Muito insatisfeito"></label>';

    echo '    </div>';
    echo '</div>';
    echo '<br>';
    echo '<div class="w3-row question">';
    echo '    <span class="w3-col m3 s4">';
        echo $retornoclass[$x]["nome"];
    echo '    </span>';

    echo '    <span class="w3-col w3-left-align m8 s7">';
    echo $retornoclass[$x]["comentario"];
    echo '    </span>';
    echo '</div>';
    echo '<hr />';

    $class = $retornoclass[$x]["classificacao"];
    if ($class > 0.5 && $class <= 1.5) {
        $star = $starx . '1';
    }
    if ($class > 1.5 && $class <= 2.5) {
        $star = $starx . '2';
    }
    if ($class > 2.5 && $class <= 3.5) {
        $star = $starx . '3';
    }
    if ($class > 3.5 && $class <= 4.5) {
        $star = $starx . '4';
    }
    if ($class > 4.5 && $class <= 5) {
        $star = $starx . '5';
    }
    echo '<script>';
    echo 'myFunction2("' . $star . '");';
    echo '</script>';
}
?>
