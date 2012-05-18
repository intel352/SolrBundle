<?php
namespace FS\SolrBundle\Indexer;

use FS\SolrBundle\Doctrine\Mapper\MetaInformation;

interface IndexerInterface {
	
	public function toIndex(MetaInformation $metaInformation);
}

?>