<?php
namespace FS\SolrBundle\Doctrine\Mapping\Driver;

use FS\SolrBundle\Doctrine\Mapping\Provider\MappingProviderInterface;

abstract class AbstractMappingDriver {
	
	protected $dir = '';
	
	protected $mappings = array();
	
	public function setDir($dir) {
		$this->dir = $dir;
	}
	
	public function getMappings() {
		return $this->mappings;
	}
	
	abstract public function load();
}

?>