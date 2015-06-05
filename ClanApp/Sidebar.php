<?php
/**
 * Created by PhpStorm.
 * User: Kriptonic
 * Date: 05/06/2015
 * Time: 23:22
 */

namespace ClanApp;


class Sidebar {

	private $sidebarItems = [

	];

	public function __construct() {

	}

	public function addList($listName, $listItems) {

	}

	public function newList($listName) {
		$sidebarItems[$listName] = [];
	}

	/**
	 * Add a link item to a sub-list for display on the sidebar.
	 *
	 * @param $href string The location for the link.
	 * @param $text string The display text for the link.
	 * @param $listName string The category or sub-heading to add the link to. If null then the item will not be displayed in a list.
	 */
	public function addItem($href, $text, $listName = null) {

		if ($listName) {
			$this->sidebarItems[$listName][] = compact('href', 'text');
		} else {
			$this->sidebarItems[] = compact('href', 'text');
		}

	}

	public function getStructure() {
		return $this->sidebarItems;
	}

}
