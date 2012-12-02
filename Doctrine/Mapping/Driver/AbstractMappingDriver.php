<?php
namespace FS\SolrBundle\Doctrine\Mapping\Driver;

use FS\SolrBundle\Doctrine\Mapping\Provider\MappingProviderInterface;
use Symfony\Component\Finder\Finder;

abstract class AbstractMappingDriver {
	
	protected $dir = '';
	
	protected $mappings = array();
	
	protected $filePattern = '';
	
	public function setDir($dir) {
		$this->dir = $dir;
	}
	
	public function getMappings() {
		return $this->mappings;
	}
	
	public function getFiles() {
		if ($this->dir == '') {
			throw new \RuntimeException('no mapping configuration dir set for mapping driver %s', get_class($this));
		}
		
		$finder = new Finder();
		
		if ($this->filePattern == '') {
			return $finder->files()->in($this->dir);
		}
		
		return $finder->files()->in($this->dir)->name($this->filePattern);		
	}
	
	abstract public function load();
}

?>