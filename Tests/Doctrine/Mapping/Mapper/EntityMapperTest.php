<?php

namespace FS\SolrBundle\Tests\Doctrine\Mapping\Mapper;

use FS\SolrBundle\Tests\Util\MetaTestInformationFactory;
use FS\SolrBundle\Doctrine\Mapping\Mapper\Command\MapAllFieldsCommand;
use FS\SolrBundle\Doctrine\Annotation\AnnotationReader;
use FS\SolrBundle\Doctrine\Mapping\Mapper\EntityMapper;

/**
 * 
 * @group mapper
 */
class EntityMapperTest extends \PHPUnit_Framework_TestCase {

	public function testToDocument_EntityMayNotIndexed() {
		$mapper = new EntityMapper();
		
		$actual = $mapper->toDocument(MetaTestInformationFactory::getMetaInformation());
		$this->assertNull($actual);
	}
	
	public function testToDocument_DocumentIsUpdated() {
		$mapper = new EntityMapper();
		$mapper->setMappingCommand(new MapAllFieldsCommand(new AnnotationReader()));
		
		$actual = $mapper->toDocument(MetaTestInformationFactory::getMetaInformation());
		$this->assertTrue($actual instanceof \SolrInputDocument);
		$this->assertTrue($actual->fieldExists('id'));
	}
	
	public function testToEntity() {
		$obj = new SolrDocumentStub(array(
			'id' 	=> 1,
			'title_t'	=> 'foo'		
		));
		
		$targetEntity = new ValidTestEntity();
		
		$mapper = new EntityMapper();
		$entity = $mapper->toEntity($obj, $targetEntity);
		
		$this->assertTrue($entity instanceof $targetEntity);
		
		$this->assertEquals(1, $entity->getId());
		$this->assertEquals('foo', $entity->getTitle());
	}

	public function testToCamelCase() {
		$mapper = new EntityMapper();

		$meta = new \ReflectionClass($mapper);
		$method = $meta->getMethod('toCamelCase');
		$method->setAccessible(true);
		$calmelCased = $method->invoke($mapper, 'test_underline');
		$this->assertEquals('testUnderline', $calmelCased);
	}
}

