<?php
namespace FS\SolrBundle\Doctrine\Mapping\Mapper\Command;

use FS\SolrBundle\Doctrine\Annotation\Field;
use FS\SolrBundle\Doctrine\Mapping\Mapper\MetaInformation;
use Doctrine\Common\Annotations\AnnotationReader;

class MapAllFieldsCommand extends AbstractDocumentCommand {
	
	/**
	 * (non-PHPdoc)
	 * @see FS\SolrBundle\Doctrine\Mapping\Mapper\Command.AbstractDocumentCommand::createDocument()
	 */
	public function createDocument(MetaInformation $meta) {
		$fields = $meta->getFields();
		if (count($fields) == 0) {
			return null;
		}
		
		$document = parent::createDocument($meta);
		
		foreach ($fields as $field) {
			if (!$field instanceof Field) {
				continue;
			}
			
			$document->addField($field->getNameWithAlias(), $field->getValue(), $field->getBoost());
		}
		
		return $document;
	}
}

?>