<?php

$offset = JFactory::getApplication()->input->get('offset');
$array = array($offset, 'y');
echo json_encode($array);
//echo $this->$results;