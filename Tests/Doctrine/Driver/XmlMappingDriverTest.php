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
		$mappings = $xmlDriver->getMappings();
		
		$mapping = array_pop($mappings);
		$this->assertArrayHasKey('attributes', $mapping);
		
		$this->assertArrayHasKey('boost', $mapping['attributes']);
		$this->assertArrayHasKey('entity', $mapping['attributes']);
		$this->assertArrayHasKey('repository', $mapping['attributes']);
		
		$this->assertArrayHasKey('fields', $mapping);
		$this->assertEquals(2, count($mapping['fields']));
		$field = array_pop($mapping['fields']);
		
		$this->assertArrayHasKey('name', $field);
		$this->assertArrayHasKey('type', $field);
		$this->assertArrayHasKey('property', $field);
	}
}

?>