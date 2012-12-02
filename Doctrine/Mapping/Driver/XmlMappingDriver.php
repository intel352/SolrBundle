<?php
namespace FS\SolrBundle\Doctrine\Mapping\Driver;

use Symfony\Component\Finder\Finder;

class XmlMappingDriver extends AbstractMappingDriver {
	public function load() {
		$finder = new Finder();
		$files = $finder->files()->in($this->dir)->name('*.xml');
		
		foreach ($files as $file) {
			$path = $this->dir.'/'.$file->getFilename();
			$xml = simplexml_load_file($path);
			
			$children = $xml->children();
			$documentNode = $children[0];
			
			$attributes = $documentNode->attributes();

			$mapping = array();
			$mapping['attributes']['repository'] = $this->elementToString($attributes['repository']);
			$mapping['attributes']['boost'] = $this->elementToString($attributes['boost']);
			$mapping['attributes']['entity'] = $this->elementToString($attributes['entity']);
			
			$mapping = $this->loadFields($documentNode, $mapping);
			
			$this->mappings[] = $mapping;
		}
	}
	
	private function loadFields(\SimpleXMLElement $documentNode, array $mapping) {
		foreach ($documentNode->field as $fieldNode) {
			$fieldAttributes = $fieldNode->attributes();
		
			$field = array();
			$field['name'] = $this->elementToString($fieldAttributes['name']);
			$field['type'] = $this->elementToString($fieldAttributes['type']);
			$field['property'] = $this->elementToString($fieldAttributes['property']);

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