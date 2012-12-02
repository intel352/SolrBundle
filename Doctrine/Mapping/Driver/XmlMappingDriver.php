<?php
namespace FS\SolrBundle\Doctrine\Mapping\Driver;



use FS\SolrBundle\Doctrine\Annotation\Field;

class XmlMappingDriver extends AbstractMappingDriver {
	
	protected $filePattern = '*.xml';
	
	public function load() {
		$files = $this->getFiles();
		
		foreach ($files as $file) {
			$path = $this->dir.'/'.$file->getFilename();
			$xml = simplexml_load_file($path);
			
			$children = $xml->children();
			$documentNode = $children[0];
			
			$attributes = $documentNode->attributes();

			$mapping = array();
			$mapping['attributes']['repository'] = $this->elementToString($attributes['repository']);
			$mapping['attributes']['boost'] = $this->elementToString($attributes['boost']);
			
			$entity = $this->elementToString($attributes['entity']);
			$mapping['attributes']['entity'] = $entity;
			
			$mapping = $this->loadFields($documentNode, $mapping);
			
			$this->mappings[$entity] = $mapping;
		}
	}
	
	private function loadFields(\SimpleXMLElement $documentNode, array $mapping) {
		foreach ($documentNode->field as $fieldNode) {
			$fieldAttributes = $fieldNode->attributes();
		
			$field = new Field(array(
				'name' => $this->elementToString($fieldAttributes['name']),
				'type' => $this->elementToString($fieldAttributes['type'])	
			));

			$mapping['fields'][] = $field;
		}	

		return $mapping;
	}
	
	private function elementToString(\SimpleXMLElement $element = null) {
		if (is_null($element)) {
			return '';
		}
		
		return $element->__toString();
	}
}

?>