<?php
! defined('BASEPATH')? define('BASEPATH', 1):null;
use PHPUnit\Framework\TestCase;
use applications\controllers\ApiCompute;
use system\core\Controller;


class ApiComputeTest extends TestCase{

	public function testadd(){

		$this->assertEquals(10,ApiCompute::add());
	}
}

?>
