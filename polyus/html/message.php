<?php
defined('_JEXEC') or die;

function renderMessage($msgList)
{
	$buffer  = null;
	$buffer .= "<script>";

	if (is_array($msgList) && count($msgList) > 0)
	{

		foreach ($msgList as $type => $msgs)
		{
			if (count($msgs))
			{

				foreach ($msgs as $msg)
				{
          $style = '"max-width:800px;"';
					$buffer .= "jQuery.fancybox.open('<div style=".$style."><h4>".$msg."</h4></div>');";
				}

			}

		}
	}
    $buffer .= "</script>";
	return $buffer;
}
