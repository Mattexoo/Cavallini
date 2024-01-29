<?php

session_start();

if ($_GET['restart']) {
  $_SESSION['cards'] = [];

  foreach (array('c', 'd', 'h', 's') as $suit)
    for ($value = 1; $value < 13; ++$value)
      $_SESSION['cards'][] = 'bg_' . $suit . $value . '.gif';

  die();
}

if (!isset($_SESSION['cards']) || count($_SESSION['cards']) === 0) {
  $_SESSION['cards'] = [];

  foreach (array('c', 'd', 'h', 's') as $suit)
    for ($value = 1; $value < 13; ++$value)
      $_SESSION['cards'][] = 'bg_' . $suit . $value . '.gif';
}


$cards = $_SESSION['cards'];

$key = array_rand($cards);
$randomCard = $cards[$key];
unset($_SESSION['cards'][$key]);

echo $randomCard;
