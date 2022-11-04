let saveAction;

const MAX_VISOR = 50;

if (document.getElementById("accumulator").innerHTML === "") {
  cleanAll();
}

function addElement(element) {
  if (document.getElementById("total").innerHTML.length < MAX_VISOR) {
    document.getElementById("total").innerHTML += element;
  }
}

function wrapExpression(element1, element2) {
  document.getElementById("total").innerHTML =
    element1 + document.getElementById("total").innerHTML + element2;
}

function cleanAll() {
  document.getElementById("total").innerHTML = "";
  document.getElementById("accumulator").innerHTML = "";
}

function result() {
  let expression = document.getElementById("total").innerHTML;
  document.getElementById("input-form").value = expression;
  document.getElementById("submit-form").submit();
}
