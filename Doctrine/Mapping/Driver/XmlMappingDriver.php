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
		}
	}
}

?>