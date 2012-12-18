<?php

class TreeModel extends TableGateway {
	
	function findAllOrderById($fields) {
		$tree = parent::findAllOrderById($fields);
		$tree = $this->buildTree($tree);
		$tree = $this->renderTree($tree);
		return $tree;
	}

	private function buildTree($tree) {

		foreach ($tree as $node) {
			$temp[$node['id']] = array('parent_id' => $node['parent_id'], 'name' => $node['name']);
		}
		$tree = $temp;
		unset($temp);

		$newTree = array(
					'id' => 0,
					'name' => 'root',
					'children' => array(),
		);

		foreach ($tree as $id=>&$node) {
			if($node['parent_id']) {
				$tree[$node['parent_id']]['children'][$id] = &$node;
			}
			else {
				$newTree['children'][$id] = &$node;
			}
		}
		return $newTree;
	}

	private function renderTree($tree) {
		if (isset($tree['children'])) {
			$htm = '<ul>';
			foreach ($tree['children'] as $node) {
				$htm .= '<li>'.$node['name'];
				$htm .= $this->renderTree($node);
				$htm .= '</li>';
			}
			$htm .= '</ul>';
			return $htm;
		}
		else return null;
	}
}
