<?php
namespace FS\SolrBundle\Doctrine\Mapper;

class RelationMetaInformation extends MetaInformation {
	private $fieldname = '';
	
	public function __construct(MetaInformation $metainformation = null) {
		if ($metainformation) {
			$this->setClassName($metainformation->getClassName());
			$this->setDocumentName($metainformation->getDocumentName());
			$this->setEntity($metainformation->getEntity());
			$this->setFieldMapping($metainformation->getFieldMapping());
			$this->setFields($metainformation->getFields());
			$this->setIdentifier($metainformation->getIdentifier());
			$this->setOneToOne($metainformation->getOneToOne());
			$this->setRepository($metainformation->getRepository());
		}
	}
	
	
	/**
	 * @return string
	 */
	public function getFieldname() {
		return $this->fieldname;
	}

	/**
	 * @param string $fieldname
	 */
	public function setFieldname($fieldname) {
		$this->fieldname = $fieldname;
	}
}
