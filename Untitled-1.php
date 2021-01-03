<?php 
function some()
{
  # code...
}

  function sayHi()
  {
    echo "hi";
  }

  
  if (1>2) {
    print('hi');
  };

  define('NAME', 'Marioooo');

  $name = 'Mario';
  $age = 30;
  
  
  // $stringOne = 'This is a string ';
  // $stringTwo = 'This is also a string';

  echo $stringOne . $stringTwo;

  // echo 'Hey, my name is ' . $name;

  // echo "Hey my name is $name"
  // double quotes lets you use variable interpelation 

  echo "the ninja screamed \"whaaa\"";
  // or
  echo 'the ninja screamed "whaaa"';

  // echo $name[0];

  echo strlen($name);

  // order of operation  B I D M A S
  // bracket indiscese(powerof) division multi addition sub

  $ages = [1,2,3,4,5];

  print($ages);

  // associative array is like a library 

  $ninjas = ['me','you','food'];
  echo '<br />';

  for($i = 0; $i < count($ninjas); $i++){
    echo $ninjas[$i] . '<br />';
  }
  ?>