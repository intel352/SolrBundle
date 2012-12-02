<?php
namespace FS\SolrBundle\Doctrine\Mapping\Provider;

use FS\SolrBundle\Doctrine\Mapping\Driver\MappingDriverAggregator;
use FS\SolrBundle\Doctrine\Mapping\Driver\AbstractMappingDriver;

class MappingProvider implements MappingProviderInterface {

	/**
	 * @var MappingDriverAggregator
	 */
	private $mappingAggregator = null;

	private $mappings = array();
	
	public function __construct(MappingDriverAggregator $aggregator) {
		$this->mappingAggregator = $aggregator;
	}

	public function getFields($entity) {
		$mapping = $this->mappingAggregator->getMapping($entity);

		if (array_key_exists('fields', $mapping)) {
			return $this->addFieldValue($entity, $mapping['fields']);
		}
		
		return array();
	}
	
	private function addFieldValue($entity, array $fieldMappings) {
		$reflectionClass = new \ReflectionClass($entity);
		$properties = $reflectionClass->getProperties();

		$values = array();
		foreach ($properties as $property) {
			$property->setAccessible(true);
			$values[$property->getName()] = $property->getValue($entity);
		}
		
		foreach ($fieldMappings as $field) {
			if (array_key_exists($field->name, $values)) {
				$field->value = $values[$field->name];
			}
		}
		
		return $fieldMappings;
	}
	
	public function getEntityBoost($entity) {
		$mapping = $this->mappingAggregator->getMapping($entity);

		if (array_key_exists('boost', $mapping['attributes'])) {
			return $mapping['attributes']['boost'];
		}
		
		return '0';
	}
	
	public function getIdentifier($entity) {

	}
	
	public function getRepository($entity) {
		$mapping = $this->mappingAggregator->getMapping($entity);

		if (array_key_exists('repository', $mapping['attributes'])) {
			return $mapping['attributes']['repository'];
		}
		
		return '';
	}
	
	public function getFieldMapping($entity) {
		$mapping = $this->mappingAggregator->getMapping($entity);
		
		if (!array_key_exists('fields', $mapping)) {
			return array();
		}
		
		$fieldMapping = array();
		foreach ($mapping['fields'] as $field) {
			$fieldMapping[$field->getNameWithAlias()] = $field->name;
		}
		
		return $fieldMapping;
	}

}

?>