<?php
namespace FS\SolrBundle\Doctrine\Mapping\Driver;

class XmlMappingDriver extends AbstractMappingDriver {
	public function load() {
		$this->mappings = array('test');
	}
}

?>