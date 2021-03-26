<?php
/**
 * @package     J4xdemos.Plugin
 * @subpackage  Content.j4xdemosbscompos
 *
 * @copyright   Copyright (C) 2019 Clifford E Ford. All rights reserved.
 * @license     GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 */

defined('_JEXEC') or die;

use Joomla\CMS\Plugin\CMSPlugin;
use Joomla\CMS\Language\Text;

// See https://docs.joomla.org/J4.x:Creating_a_Plugin_for_Joomla

/**
 * Create and or render an article table of contents.
 *
 * @since  4.0
 */
class PlgContentJ4xdemosbscompos extends CMSPlugin
{
	/**
	 * Look for {bscompos bscomponentname bscomponentname} a space separated list
	 * that need Javascript loaded.
	 *
	 * @return  void
	 *
	 * @since   4.0
	 */
	public function onContentPrepare($context, &$article, &$params, $page = 0)
	{
		// the context could be something other than com_content
		// such as a module - in which case do nothing and return
		if ($context !== 'com_content.article')
		{
			return;
		}

		// return if there is no {ToC} in the article content
		if (stripos($article->text,'{bscompos') === false)
		{
			return;
		}

		$pattern = '/(.*?)\{bscompos (.*?)\}(.*?)/si';
		preg_match($pattern, $article->text, $matches);

		$classes = explode(' ', $matches[2]);
		foreach ($classes as $class)
		{
			switch ($class)
			{
				case 'alert':
					\Joomla\CMS\HTML\HTMLHelper::_('bootstrap.alert', '.alert');
					break;
				case 'button':
					\Joomla\CMS\HTML\HTMLHelper::_('bootstrap.button', '.btn');
					break;
				case 'carousel':
					\Joomla\CMS\HTML\HTMLHelper::_('bootstrap.carousel', '.selector', []);
					break;
				case 'collapse':
					\Joomla\CMS\HTML\HTMLHelper::_('bootstrap.collapse', '.selector', []);
					break;
				case 'dropdown':
					\Joomla\CMS\HTML\HTMLHelper::_('bootstrap.dropdown', '.selector', []);
					break;
				case 'modal':
					\Joomla\CMS\HTML\HTMLHelper::_('bootstrap.modal', '.selector', []);
					break;
				case 'offcanvas':
					// Not Found
					//\Joomla\CMS\HTML\HTMLHelper::_('bootstrap.offcanvas', '.btn', []);
					break;
				case 'popover':
					\Joomla\CMS\HTML\HTMLHelper::_('bootstrap.popover', '.btn', []);
					\Joomla\CMS\HTML\HTMLHelper::_('bootstrap.popover', 'a', []);
					break;
				case 'scrollspy':
					\Joomla\CMS\HTML\HTMLHelper::_('bootstrap.scrollspy', '.selector', []);
					break;
				case 'tab':
					\Joomla\CMS\HTML\HTMLHelper::_('bootstrap.tab', '.selector', []);
					break;
				case 'tooltip':
					\Joomla\CMS\HTML\HTMLHelper::_('bootstrap.tooltip', '.btn', []);
					\Joomla\CMS\HTML\HTMLHelper::_('bootstrap.tooltip', 'a', []);
					break;
				case 'toast':
					\Joomla\CMS\HTML\HTMLHelper::_('bootstrap.toast', '.selector', []);
					break;
				default:
					// do nothing
			}
		}

		$article->text = str_ireplace('{bscompos '. implode(' ', $classes) . '}', '', $article->text);
		$article->text = str_replace('<p></p>','', $article->text);
		return;
	}
}