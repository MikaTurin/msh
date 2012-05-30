<?
function smarty_modifier_bbcode($message) {

  $preg = array(
    // [quote]
    '/(?<!\\\\)\[quote(?::\w+)?\](.*?)\[\/quote(?::\w+)?\]/si'         => "<fieldset class=\"bb-quote\"><legend>Цитата:</legend><div>\\1</div></fieldset>",
    '/(?<!\\\\)\[quote(?::\w+)?=(?:&quot;|"|\')?([^><]*?)["\']?(?:&quot;|"|\')?\](.*?)\[\/quote\]/si'   => "<fieldset class=\"bb-quote\"><legend>Цитата <i>\\1</i>:</legend><div>\\2</div></fieldset>",

    '/(?<!\\\\)\[color(?::\w+)?=([^"><\']+?)\](.*?)\[\/color(?::\w+)?\]/si'   => "<span style=\"color:\\1\">\\2</span>",
//        '/(?<!\\\\)\[size(?::\w+)?=(.*?)\](.*?)\[\/size(?::\w+)?\]/si'     => "<span style=\"font-size:\\1\">\\2</span>",
//        '/(?<!\\\\)\[font(?::\w+)?=(.*?)\](.*?)\[\/font(?::\w+)?\]/si'     => "<span style=\"font-family:\\1\">\\2</span>",
//        '/(?<!\\\\)\[align(?::\w+)?=(.*?)\](.*?)\[\/align(?::\w+)?\]/si'   => "<div style=\"text-align:\\1\">\\2</div>",
//        '/(?<!\\\\)\[b(?::\w+)?\](.*?)\[\/b(?::\w+)?\]/si'                 => "<span style=\"font-weight:bold\">\\1</span>",
    '/(?<!\\\\)\[b(?::\w+)?\](.*?)\[\/b(?::\w+)?\]/si'                 => "<b>\\1</b>",
//          '/(?<!\\\\)\[i(?::\w+)?\](.*?)\[\/i(?::\w+)?\]/si'                 => "<span style=\"font-style:italic\">\\1</span>",
    '/(?<!\\\\)\[i(?::\w+)?\](.*?)\[\/i(?::\w+)?\]/si'                 => "<i>\\1</i>",
    '/(?<!\\\\)\[u(?::\w+)?\](.*?)\[\/u(?::\w+)?\]/si'                 => "<span style=\"text-decoration:underline\">\\1</span>",
    '/(?<!\\\\)\[center(?::\w+)?\](.*?)\[\/center(?::\w+)?\]/si'       => "<div style=\"text-align:center\">\\1</div>",
    // [code] & [php]
    //'/(?<!\\\\)\[code(?::\w+)?\](.*?)\[\/code(?::\w+)?\]/si'           => "<div class=\"bb-code\">\\1</div>",
    //'/(?<!\\\\)\[php(?::\w+)?\](.*?)\[\/php(?::\w+)?\]/si'             => "<div class=\"bb-php\">\\1</div>",
    // [email]
//        '/(?<!\\\\)\[email(?::\w+)?\](.*?)\[\/email(?::\w+)?\]/si'         => "<a href=\"mailto:\\1\" class=\"bb-email\">\\1</a>",
//        '/(?<!\\\\)\[email(?::\w+)?=(.*?)\](.*?)\[\/email(?::\w+)?\]/si'   => "<a href=\"mailto:\\1\" class=\"bb-email\">\\2</a>",
    // [url]
    '/(?<!\\\\)\[url(?::\w+)?\]www\.([^"><\']+?)\[\/url(?::\w+)?\]/si'      => "<a href=\"http://www.\\1\" target=\"_blank\" class=\"bb-url\">\\1</a>",
    '/(?<!\\\\)\[url(?::\w+)?\]([^"><\']+?)\[\/url(?::\w+)?\]/si'             => "<a href=\"\\1\" target=\"_blank\" class=\"bb-url\">\\1</a>",
    '/(?<!\\\\)\[url(?::\w+)?=([^"><\']+?)?\](.*?)\[\/url(?::\w+)?\]/si'      => "<a href=\"\\1\" target=\"_blank\" class=\"bb-url\">\\2</a>",
    // [img]
    '/(?<!\\\\)\[img(?::\w+)?\]([^"><\']+?)\[\/img(?::\w+)?\]/si'             => "<img src=\"\\1\" alt=\"\\1\" class=\"bb-image\" />",
    '/(?<!\\\\)\[img(?::\w+)?=([0-9]+?)x([0-9]+?)\]([^"><\']+?)\[\/img(?::\w+)?\]/si' => "<img width=\"\\1\" height=\"\\2\" src=\"\\3\" alt=\"\\3\" class=\"bb-image\" />",
    // [list]
    '/(?<!\\\\)(?:\s*<br\s*\/?>\s*)?\[\*(?::\w+)?\](.*?)(?=(?:\s*<br\s*\/?>\s*)?\[\*|(?:\s*<br\s*\/?>\s*)?\[\/?list)/si' => "<li class=\"bb-listitem\">\\1</li>",
    '/(?<!\\\\)(?:\s*<br\s*\/?>\s*)?\[\/list(:(?!u|o)\w+)?\](?:<br\s*\/?>)?/si'    => "</ul>",
    '/(?<!\\\\)(?:\s*<br\s*\/?>\s*)?\[\/list:u(:\w+)?\](?:<br\s*\/?>)?/si'         => "</ul>",
    '/(?<!\\\\)(?:\s*<br\s*\/?>\s*)?\[\/list:o(:\w+)?\](?:<br\s*\/?>)?/si'         => "</ol>",
    '/(?<!\\\\)(?:\s*<br\s*\/?>\s*)?\[list(:(?!u|o)\w+)?\]\s*(?:<br\s*\/?>)?/si'   => "<ul class=\"bb-list-unordered\">",
    '/(?<!\\\\)(?:\s*<br\s*\/?>\s*)?\[list:u(:\w+)?\]\s*(?:<br\s*\/?>)?/si'        => "<ul class=\"bb-list-unordered\">",
    '/(?<!\\\\)(?:\s*<br\s*\/?>\s*)?\[list:o(:\w+)?\]\s*(?:<br\s*\/?>)?/si'        => "<ol class=\"bb-list-ordered\">",
    '/(?<!\\\\)(?:\s*<br\s*\/?>\s*)?\[list(?::o)?(:\w+)?=1\]\s*(?:<br\s*\/?>)?/si' => "<ol class=\"bb-list-ordered,bb-list-ordered-d\">",
    '/(?<!\\\\)(?:\s*<br\s*\/?>\s*)?\[list(?::o)?(:\w+)?=i\]\s*(?:<br\s*\/?>)?/s'  => "<ol class=\"bb-list-ordered,bb-list-ordered-lr\">",
    '/(?<!\\\\)(?:\s*<br\s*\/?>\s*)?\[list(?::o)?(:\w+)?=I\]\s*(?:<br\s*\/?>)?/s'  => "<ol class=\"bb-list-ordered,bb-list-ordered-ur\">",
    '/(?<!\\\\)(?:\s*<br\s*\/?>\s*)?\[list(?::o)?(:\w+)?=a\]\s*(?:<br\s*\/?>)?/s'  => "<ol class=\"bb-list-ordered,bb-list-ordered-la\">",
    '/(?<!\\\\)(?:\s*<br\s*\/?>\s*)?\[list(?::o)?(:\w+)?=A\]\s*(?:<br\s*\/?>)?/s'  => "<ol class=\"bb-list-ordered,bb-list-ordered-ua\">",
    // escaped tags like \[b], \[color], \[url], ...
   '/\\\\(\[\/?\w+(?::\w+)*\])/'                                      => "\\1"
  );

	$message = str_replace("\\\"", "\"", $message);
  $message = str_replace(array('>', '<'), array('&gt;', '&lt;'), $message);
	$message = preg_replace(array("/\s:\)/","/\s;\)/","/\s:D/"), array("(:s1:)","(:s10:)","(:s8:)"), $message);
	$message = preg_replace(array_keys($preg), array_values($preg), trim($message));


  $smiles_array = Registry::get('forum_emotions');
  $smiles_keys = array_keys($smiles_array);
  $smiles = str_replace(array('(', ')'), array('\(', '\)'), array_map(function ($smile) { return "/$smile/"; }, $smiles_keys));
  $smile_icons = array_map(function ($img, $alt) { return '<img src="/img/smiles/'.$img.'" border="0" alt="'.$alt.'">'; }, array_values($smiles_array), $smiles_keys);
  $message = preg_replace($smiles, $smile_icons, $message);


	$message = str_replace("\n", "<br>", $message);
	return $message;
}
?>
