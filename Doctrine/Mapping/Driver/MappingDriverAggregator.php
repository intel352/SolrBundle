<?php
namespace FS\SolrBundle\Doctrine\Mapping\Driver;

class MappingDriverAggregator {
	
	private $isLoaded = false;
	
	private $mappingConfig = array();
	
	private $mappings = array();
	
	public function setMappingConfig(array $config) {
		$this->mappingConfig = $config;
	}
	
	public function getMapping($object) {
		if (!$this->isLoaded) {
			$this->load();
		}
	}
	
	public function load() {
		
		foreach ($this->mappingConfig as $config) {
			$driver = $this->getDriver($config['type']);
			$driver->setDir($config['dir']);
			$driver->load();
			
			$mappings = $driver->getMappings();
			
			$this->mappings = array_merge($this->mappings, $mappings);
		}
		
		$this->isLoaded = true;
	} 
	
	private function getDriver($type) {
		switch($type) {
			case 'xml':
				return new XmlMappingDriver();
				break;
		}
		
		return null;
	}
	
	public function getMappings() {
		return $this->mappings;
	}
	
	public function isLoaded() {
		return $this->isLoaded;
	}
}

?>