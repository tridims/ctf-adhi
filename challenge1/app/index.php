<?php
error_reporting(0);

define('ALLOWED_CHARS', ' _abcdefghijklmnopqrstuvwxyz0123456789.!^&|+-*/%()[],');
define('ALLOWED_FUNCTIONS', ['abs', 'acos', 'acosh', 'asin', 'asinh', 'atan2', 'atan', 'atanh', 'base_convert', 'bindec', 'ceil', 'cos', 'cosh', 'decbin', 'dechex', 'decoct', 'deg2rad', 'exp', 'floor', 'fmod', 'getrandmax', 'hexdec', 'hypot', 'is_finite', 'is_infinite', 'is_nan', 'lcg_value', 'log10', 'log', 'max', 'min', 'mt_getrandmax', 'mt_rand', 'octdec', 'pi', 'pow', 'rad2deg', 'rand', 'round', 'sin', 'sinh', 'sqrt', 'srand', 'tan', 'tanh', 'ncr', 'npr', 'number_format']);
define('REGEX_PATTERN', "/([a-z_]+)/");

$expression_query = $_POST["expression"] ? $_POST["expression"] : null;

function filter_query($query)
{
  $query = strtolower($query);
  preg_match_all(REGEX_PATTERN, $query, $words);
  $words = $words[0];
  $allowed_characters = str_split(ALLOWED_CHARS);

  foreach ($words as $word) {
    if (!(strlen($word) && array_search($word, ALLOWED_FUNCTIONS)))
      return false;
  }

  for ($i = strlen($query) - 1; $i >= 0; $i--) {
    if (array_search($query[$i], $allowed_characters) === false) {
      return false;
    }
  }

  return true;
}

function evaluate($code)
{
  if (strlen($code) > 1024) return "Expression too long.";
  $save = filter_query($code);
  if (!$save)
    return "This looks suspicious : " . $code;
  else {
    $res = '';
    eval('$res=' . $code . ";");
    return $res;
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" type="text/css" href="./styles.css">
  <title>The Calculator</title>
</head>

<body>
  <!-- Kalkulator yang bisa melakukan berbagai fungsi 'abs', 'acosh', 'asin', 'asinh', 'atan2', 'bindec', 'base_convert', 'ceil', 'cos', 'cosh', 'pow', 'rad2deg', 'rand', 'round', 'sin', 'sinh', 'sqrt', 'srand', 'tan', 'tanh', 'ncr', 'npr', 'number_format'-->
  <div class="calculator">
    <div class="visor">
      <div id="accumulator" class="acc"><?= $expression_query ?? '' ?></div>
      <div id="total" class="total">
        <?php if (isset($expression_query)) : ?>
          <?= @evaluate($expression_query) ?>
        <?php endif ?>
      </div>
    </div>
    <div class="numeric action" onclick="cleanAll()">C</div>
    <div class="numeric action" onclick="wrapExpression('pow(', ', 2)')">X²</div>
    <div class=" numeric action" onclick="addElement('/100')">%</div>
    <div class="numeric action" onclick="addElement('/')">/</div>
    <div class="numeric" onclick="addElement(7)">7</div>
    <div class="numeric" onclick="addElement(8)">8</div>
    <div class="numeric" onclick="addElement(9)">9</div>
    <div class="numeric action" onclick="addElement('*')">x</div>
    <div class="numeric" onclick="addElement(4)">4</div>
    <div class="numeric" onclick="addElement(5)">5</div>
    <div class="numeric" onclick="addElement(6)">6</div>
    <div class="numeric action" onclick="addElement('-')">-</div>
    <div class="numeric" onclick="addElement(1)">1</div>
    <div class="numeric" onclick="addElement(2)">2</div>
    <div class="numeric" onclick="addElement(3)">3</div>
    <div class="numeric action" onclick="addElement('+')">+</div>
    <div class="numeric zero" onclick="addElement(0)">0</div>
    <div class="numeric" onclick="addElement('.')">,</div>
    <div class="numeric action result" onclick="result()">=</div>
  </div>

  <form hidden id="submit-form" method="POST">
    <input id="input-form" class="input is-large" type="text" name="expression" value="" />
  </form>

  <div class="footer">
    <p>Hology 5.0 CTF</p>
  </div>
</body>

<script type="text/javascript" src="./calculator.js"></script>

</html>
