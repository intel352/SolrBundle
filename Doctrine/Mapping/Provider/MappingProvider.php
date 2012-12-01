<?php
namespace FS\SolrBundle\Doctrine\Mapping\Provider;

use FS\SolrBundle\Doctrine\Mapping\Driver\MappingDriverAggregator;
use FS\SolrBundle\Doctrine\Mapping\Driver\AbstractMappingDriver;

class MappingProvider implements MappingProviderInterface {

	private $mappingAggregator = null;
	
	public function __construct(MappingDriverAggregator $aggregator) {
		$this->mappingAggregator = $aggregator;
	}
	
}

?>