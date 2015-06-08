<?php

namespace ClanApp\core;

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

		$structureFlattened = [];

		foreach ($this->sidebarItems as $key => $value) {
			if (is_string($key)) {
				// This is an array of links, flatten them.
				$structureFlattened[] = ['type' => 'heading', 'text' => $key];
				foreach ($value as $linkDetails) {
					$structureFlattened[] = [
						'type' => 'link',
						'href' => $linkDetails['href'],
						'text' => $linkDetails['text']
					];
				}
			} else {
				// This is a normal link, flattening not required.
				$structureFlattened[] = [
					'type' => 'link',
					'href' => $value['href'],
					'text' => $value['text']
				];
			}
		}

		return $structureFlattened;
	}

}
