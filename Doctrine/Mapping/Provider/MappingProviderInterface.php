<?php
namespace FS\SolrBundle\Doctrine\Mapping\Provider;

interface MappingProviderInterface {
	
	public function getFields($entity);
	
	public function getEntityBoost($entity);
	
	public function getIdentifier($entity);
	
	public function getRepository($entity);
	
	public function getFieldMapping($entity);
}

?>