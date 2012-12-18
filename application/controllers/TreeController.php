<?php

class TreeController extends CRUDController{
	protected $tableName = 'items';
	protected $fields = array('id', 'parent_id', 'name');
}
