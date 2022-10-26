<?php
error_reporting(0);
isset($_GET['source']) && die(highlight_file(__FILE__));

function is_safe($query)
{
  $query = strtolower($query);
  preg_match_all("/([a-z_]+)/", $query, $words);
  $words = $words[0];
  $good = ['abs', 'acos', 'acosh', 'asin', 'asinh', 'atan2', 'atan', 'atanh', 'base_convert', 'bindec', 'ceil', 'cos', 'cosh', 'decbin', 'dechex', 'decoct', 'deg2rad', 'exp', 'floor', 'fmod', 'getrandmax', 'hexdec', 'hypot', 'is_finite', 'is_infinite', 'is_nan', 'lcg_value', 'log10', 'log', 'max', 'min', 'mt_getrandmax', 'mt_rand', 'octdec', 'pi', 'pow', 'rad2deg', 'rand', 'round', 'sin', 'sinh', 'sqrt', 'srand', 'tan', 'tanh', 'ncr', 'npr', 'number_format'];
  $accept_chars = '_abcdefghijklmnopqrstuvwxyz0123456789.!^&|+-*/%()[],';
  $accept_chars = str_split($accept_chars);
  $bad = '';
  for ($i = 0; $i < count($words); $i++) {
    if (strlen($words[$i]) && array_search($words[$i], $good) === false) {
      $bad .= $words[$i] . " ";
    }
  }

  for ($i = 0; $i < strlen($query); $i++) {
    if (array_search($query[$i], $accept_chars) === false) {
      $bad .= $query[$i] . " ";
    }
  }
  return $bad;
}

function safe_eval($code)
{
  if (strlen($code) > 1024) return "Expression too long.";
  $code = strtolower($code);
  $bad = is_safe($code);
  $res = '';
  if (strlen(str_replace(' ', '', $bad)))
    $res = "I don't like this: " . $bad;
  else
    eval('$res=' . $code . ";");
  return $res;
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
  <div class="calculator">
    <div class="visor">
      <div id="accumulator" class="acc"><?= $_GET['expression'] ?? '' ?></div>
      <div id="total" class="total">
        <?php if (isset($_GET['expression'])) : ?>
          <?= @safe_eval($_GET['expression']) ?>
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

  <form hidden id="submit-form">
    <input id="input-form" class="input is-large" type="text" name="expression" value="" />
  </form>

  <div class="footer">
    <p>Hology 5.0 CTF</p>
  </div>
</body>

<script>
  let saveAction

  const MAX_VISOR = 50

  if (document.getElementById('accumulator').innerHTML === '') {
    cleanAll()
  }

  function addElement(element) {

    if (document.getElementById("total").innerHTML.length < MAX_VISOR) {
      document.getElementById("total").innerHTML += element
    }
  }

  function wrapExpression(element1, element2) {
    document.getElementById("total").innerHTML = element1 + document.getElementById("total").innerHTML + element2
  }

  function cleanAll() {
    document.getElementById("total").innerHTML = ""
    document.getElementById("accumulator").innerHTML = ""
  }

  function result() {
    let expression = document.getElementById("total").innerHTML
    console.log(expression)
    document.getElementById("input-form").value = expression
    document.getElementById("submit-form").submit()
  }
</script>

</html>