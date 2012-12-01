<?php
namespace FS\SolrBundle\Tests\Doctrine\Driver;

use FS\SolrBundle\Doctrine\Mapping\Driver\XmlMappingDriver;

/**
 *
 * @group xmldriver
 */
class XmlMappingDriverTest extends \PHPUnit_Framework_TestCase {
	
	private function getDir() {
		return __DIR__.'/../../Resources/config/solr';
	}
	
	public function testLoad() {
		$xmlDriver = new XmlMappingDriver();
		$xmlDriver->setDir($this->getDir());
		$xmlDriver->load();
		
		
		$this->assertEquals(1, count($xmlDriver->getMappings()));
	}
}

?>