<?php

defined('_JEXEC') or die;

function getMore($tag, $id){
  $db = JFactory::getDbo();
  $query = $db->getQuery(true);
  $query->select('*');
  $query->from($db->quoteName('#__content'));
  $query->where($db->quoteName('catid') . ' = 8');
  $query->where($db->quoteName('id') . ' !='.$id);
  $query->where($db->quoteName('language') . ' = '. $db->quote($tag));
  $query->setLimit('3');
  $query->order('created DESC');
  $db->setQuery($query);
  $results = $db->loadObjectList();
  return $results;
}
