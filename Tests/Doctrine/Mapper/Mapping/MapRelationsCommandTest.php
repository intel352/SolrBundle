<?php

namespace FS\SolrBundle\Tests\Doctrine\Mapper\Mapping;

use FS\SolrBundle\Doctrine\Mapper\Mapping\MapRelationsCommand;
use FS\SolrBundle\Tests\Util\MetaTestInformationFactory;

/**
 *  @group mappingcommands
 */
class MapRelationsCommandTest extends SolrDocumentTest {

	public function testCreateDocument_OneToOneRelation() {
		$command = new MapRelationsCommand();
		
		$document = $command->createDocument(MetaTestInformationFactory::getMetaInformationWithRelations());
		
		$this->assertEquals(1, $document->getFieldCount(), 'fieldcount is two');
		$this->assertTrue($document->fieldExists('author_rel_i'), 'relationfield, fields avaiable: '.print_r($document->getFieldNames(), true));
		$this->assertTrue(in_array(10, $document->getField('author_rel_i')->values), 'relation document id');
	}

}

