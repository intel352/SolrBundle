<?php
namespace FS\SolrBundle\Doctrine\Mapper\Mapping;

use FS\SolrBundle\Doctrine\Mapper\MetaInformation;

/**
 * 
 * merge the results from two command into one solr-document
 * 
 * @author Florian Semm
 *
 */
class ComposedDocumentCommand extends AbstractDocumentCommand {
	
	/**
	 * 
	 * @var MapAllFieldsCommand
	 */
	private $mapAllFields = null;
	
	/**
	 * 
	 * @var MapRelationsCommand
	 */
	private $mapRelations = null;
	
	public function __construct() {
		$this->mapAllFields = new MapAllFieldsCommand();
		$this->mapRelations = new MapRelationsCommand();
	}
	
	/* (non-PHPdoc)
	 * @see FS\SolrBundle\Doctrine\Mapper\Mapping.AbstractDocumentCommand::createDocument()
	 */
	public function createDocument(MetaInformation $meta) {
		$document = $this->mapAllFields->createDocument($meta);
		
		if ($meta->hasRelations()) {
			$documentWithRelations = $this->mapRelations->createDocument($meta);
			$document->merge($documentWithRelations);
		}
		
		return $document;
	}
}

?>