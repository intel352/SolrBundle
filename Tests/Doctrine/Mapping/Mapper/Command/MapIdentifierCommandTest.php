<?php

namespace FS\SolrBundle\Tests\Doctrine\Mapping\Mapper\Command;

use FS\SolrBundle\Doctrine\Mapping\Mapper\Command\MapIdentifierCommand;
use FS\SolrBundle\Tests\Util\MetaTestInformationFactory;

/**
 *  @group mappingcommands
 */
class MapIdentifierCommandTest extends SolrDocumentTest {

	public function testCreateDocument_DocumentHasOnlyIdAndNameField() {
		$command = new MapIdentifierCommand();
		
		$document = $command->createDocument(MetaTestInformationFactory::getMetaInformation());
		
		$this->assertEquals(2, $document->getFieldCount(), 'fieldcount is two');
		$this->assertEquals(2, $document->getField('id')->values[0], 'id is 2');
		
	}

}

