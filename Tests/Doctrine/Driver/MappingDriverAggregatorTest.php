<?php
namespace FS\SolrBundle\Tests\Doctrine\Driver;

use FS\SolrBundle\Doctrine\Mapping\Driver\MappingDriverAggregator;

use FS\SolrBundle\Doctrine\Annotation\Field;

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
	
	public function testLoad() {
		$aggregator = new MappingDriverAggregator();
		$aggregator->setMappingConfig($this->getMapping());
		
		$aggregator->load();
		$mappings = $aggregator->getMappings();
		
		$this->assertEquals(1, count($mappings), 'loaded mappings');
		$this->assertTrue($aggregator->isLoaded());
	}
}