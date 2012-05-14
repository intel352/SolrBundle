<?php
namespace FS\SolrBundle\Tests\Doctrine\Annotation\Entities;

use FS\SolrBundle\Doctrine\Annotation as Solr;

/**
 * 
 * @Solr\Document
 *
 */
class EntityWithOneToOne {
	/**
	 * @Solr\Id
	 */
	private $id;
	
	/**
	 * @Solr\Field(type="string")
	 * @Solr\OneToOne(target="FS\SolrBundle\Tests\Doctrine\Mapper\ValidTestEntity") 
	 */
	private $oneToOne = null;
}

?>