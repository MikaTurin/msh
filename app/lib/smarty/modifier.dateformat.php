<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */


/**
 * Smarty date_format modifier plugin
 *
 * Type:     modifier<br>
 * Name:     date_format<br>
 * Purpose:  format datestamps via strftime<br>
 * Input:<br>
 *         - string: input date string
 *         - format: strftime format for output
 *         - default_date: default date if $string is empty
 * @link http://smarty.php.net/manual/en/language.modifier.date.format.php
 *          date_format (Smarty online manual)
 * @author   Monte Ohrt <monte at ohrt dot com>
 * @param string
 * @param string
 * @param string
 * @return string|void
 * @uses smarty_make_timestamp()
 */
function smarty_modifier_dateformat($string, $format = '%b %e, %Y', $default_date = '') {

  global $index;
  $currentTime = time();
  
  if ($string != '') {
    $timestamp = strtotime($string);
  } elseif ($default_date != '') {
    $timestamp = strtotime($default_date);
  } else {
    return;
  }


  $_win_from = array();
  $_win_to = array();

  if (strpos($format, '%b %d [%H:%M]') !== false) {
    
    //$format = 'qqq %b %d [%H:%M]';
    $minutesDiff = round(($currentTime - $timestamp) / 60);
    $hoursDiff = round(($currentTime - $timestamp) / (60 * 60));
    if (($minutesDiff >= 0) && ($minutesDiff < 60)) {
      $minutesDiff = abs($minutesDiff);
      $end = correctEndLetter($minutesDiff);
      $_win_from[] = '%b %d [%H:%M]';
      $_win_to[] =  $minutesDiff . ' ' . $index['forumminutesago'.$end];
    } elseif (($hoursDiff >= 0) && ($hoursDiff <= 12)) {
      $hoursDiff = abs($hoursDiff);
      $end = correctEndLetter($hoursDiff);
      $_win_from[] = '%b %d [%H:%M]';
      $_win_to[] = $hoursDiff . ' ' . $index['forumhoursago'.$end];
    } else {
      $fullDaysThere = intval($timestamp / (60 * 60 * 24));
      $fullDaysNow = intval($currentTime / (60 * 60 * 24));
      if ($fullDaysThere == $fullDaysNow && date('d', $timestamp) == date('d', $currentTime)) {
        $_win_from[] = '%b %d';
        $_win_to[] = $index['forumtoday'];
      } elseif ($fullDaysThere + 1 == $fullDaysNow) {
        $_win_from[] = '%b %d';
        $_win_to[] = $index['forumyesterday'];
      } elseif (abs($fullDaysNow - $fullDaysThere) > 300) {
        $format = '%b %d, %Y [%H:%M]';
      }
    }
    $format = str_replace($_win_from, $_win_to, $format);
  }


  return strftime($format, $timestamp);
}

function correctEndLetter($n) {

  static $lang = null;
  if (empty($lang)) $lang = Front::getInstance()->getLang();

  if ($lang == 'ru') {
    if ($n % 10 == 1 && $n % 100 != 11) return 1;
    elseif ($n % 10 >= 2 && $n % 10 <= 4 && ($n % 100 < 10 || $n % 100 >= 20)) return 2;
    return 3;
  } else {
    if ($n % 10 == 1) return 1;
    return 2;
  }
}
?>
