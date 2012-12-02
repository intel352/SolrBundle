<?php
namespace FS\SolrBundle\Tests\Doctrine\Driver;

use FS\SolrBundle\Tests\Doctrine\Mapping\Mapper\ValidTestEntity;
use FS\SolrBundle\Doctrine\Mapping\Driver\MappingDriverAggregator;

/**
 *
 * @group driver
 */
class MappingDriverAggregatorTest extends \PHPUnit_Framework_TestCase {
	
	private function getMapping() {
		return array(
			'FSBlogBundle' => array(
				'dir' => __DIR__.'/../../Resources/config/solr',
				'type'=> 'xml'			
			)
		);
	}

	/**
	 * @return MappingDriverAggregator
	 */
	private function loadAggreator() {
		$aggregator = new MappingDriverAggregator();
		$aggregator->setMappingConfig($this->getMapping());
		$aggregator->load();

		return $aggregator;
	}
	
	public function testLoad() {
		$aggregator = new MappingDriverAggregator();
		$aggregator->setMappingConfig($this->getMapping());
		
		$aggregator->load();
		$mappings = $aggregator->getMappings();

		$this->assertEquals(1, count($mappings), 'loaded mappings');
		$this->assertArrayHasKey('FS\SolrBundle\Tests\Doctrine\Mapping\Mapper\ValidTestEntity', $mappings, 'mapping for entity');
		$this->assertTrue($aggregator->isLoaded(), 'aggreator is loaded');
	}
	
	public function testGetMapping() {
		$aggregator = $this->loadAggreator();
		
		$mapping = $aggregator->getMapping(new ValidTestEntity());
		
		$this->assertTrue(is_array($mapping));
		$this->assertEquals(2, count($mapping['fields']));
	}
}