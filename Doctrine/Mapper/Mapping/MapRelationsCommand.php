<?php
namespace FS\SolrBundle\Doctrine\Mapper\Mapping;

use FS\SolrBundle\Doctrine\Mapper\RelationMetaInformation;
use FS\SolrBundle\Doctrine\Mapper\MetaInformation;

class MapRelationsCommand extends AbstractDocumentCommand {
	/* (non-PHPdoc)
	 * @see FS\SolrBundle\Doctrine\Mapper\Mapping.AbstractDocumentCommand::createDocument()
	*/
	public function createDocument(MetaInformation $meta) {
		$document = new \SolrInputDocument();
		
		if (!$meta->hasRelations()) {
			return $document;	
		}
		
		foreach ($meta->getOneToOne() as $relationInformations) {
			if ($relationInformations instanceof RelationMetaInformation) {
				$document->addField($relationInformations->getFieldname(), $relationInformations->getEntityId());
			}
		}
		
		return $document;
	}
}

?>