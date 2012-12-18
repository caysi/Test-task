<?php
interface DbConnector
{
	/**
	* This funcition takes INSERT, UPDATE or DELTE SQL query and returnm number of affteted rows. 
	*/
	function execute($sql);
	/**
	* This funciton takes SELETC sql query and rturns accociated array with result 
	*/ 
	function query($sql);
}
