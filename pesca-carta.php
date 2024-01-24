<?php

session_start();

if (!isset($_SESSION['cards'])) {
  $_SESSION['cards'] = [];

  foreach (array('c', 'd', 'h', 's') as $suit)
    for ($value = 1; $value <= 13; ++$value)
      $_SESSION['cards'][] = 'bg_' . $suit . $value . '.gif';
}


$cards = $_SESSION['cards'];

if (count($cards) == 1) {
  session_destroy();
}

$key = array_rand($cards);
echo $cards[$key];
unset($cards['cards'][$key]);
