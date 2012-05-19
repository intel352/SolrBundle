<?php

namespace FS\SolrBundle\Tests\Doctrine\Mapper\Mapping;

use FS\SolrBundle\Doctrine\Mapper\Mapping\ComposedDocumentCommand;
use FS\SolrBundle\Tests\Util\MetaTestInformationFactory;

/**
 *  @group mappingcommands
 */
class ComposedDocumentCommandTest extends SolrDocumentTest {

	public function testCreateDocument_OneToOneRelation() {
		$command = new ComposedDocumentCommand();
		
		$document = $command->createDocument(MetaTestInformationFactory::getMetaInformationWithRelations());

		$this->assertFieldCount(4, $document, '4 fields mapped');
		$this->assertTrue($document->fieldExists('author_rel_i'));
		$this->assertHasDocumentFields($document, array('title_s', 'text_t', 'created_at_dt', 'author_rel_i'));
	}

}

