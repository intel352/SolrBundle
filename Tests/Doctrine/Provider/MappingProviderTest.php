<?php
namespace FS\SolrBundle\Tests\Doctrine\Provider;

use FS\SolrBundle\Tests\Doctrine\Mapping\Mapper\ValidTestEntity;

use FS\SolrBundle\Doctrine\Mapping\Driver\MappingDriverAggregator;
use FS\SolrBundle\Doctrine\Mapping\Provider\MappingProvider;

class MappingProviderTest extends \PHPUnit_Framework_TestCase {
	
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
	
	public function testGetFields() {
		
		$entity = new ValidTestEntity();
		$entity->setText('test');
		
		$provider = new MappingProvider($this->loadAggreator());
		$fields = $provider->getFields($entity);

		$this->assertEquals(2, count($fields));
		
		$textField = $fields[1];

		$this->assertEquals('test', $textField->getValue());
	}
	
	public function testGetBoost() {
		$provider = new MappingProvider($this->loadAggreator());
		$boost = $provider->getEntityBoost(new ValidTestEntity());

		$this->assertEquals(2, $boost);
	}
	
	public function testGetRepository() {
		$provider = new MappingProvider($this->loadAggreator());
		$repo = $provider->getRepository(new ValidTestEntity());
		
		$this->assertEquals('FS\SolrBundle\Tests\Doctrine\Annotation\Entities\ValidEntityRepository', $repo);		
	}
	
	public function testGetFieldMapping() {
		$provider = new MappingProvider($this->loadAggreator());
		$fieldmapping = $provider->getFieldMapping(new ValidTestEntity());

		$this->assertEquals(2, count($fieldmapping));
		$this->assertArrayHasKey('title_s', $fieldmapping);
		$this->assertArrayHasKey('text_t', $fieldmapping);
	}
}

?>