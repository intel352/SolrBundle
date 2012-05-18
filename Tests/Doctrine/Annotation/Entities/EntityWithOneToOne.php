<?php
namespace FS\SolrBundle\Tests\Doctrine\Annotation\Entities;

use FS\SolrBundle\Tests\Doctrine\Mapper\ValidTestEntity;
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
	 * @Solr\OneToOne(target="FS\SolrBundle\Tests\Doctrine\Mapper\ValidTestEntity") 
	 */
	private $oneToOne = null;
	
	/**
	 * 
	 * @Solr\Field(type="string")
	 */
	private $title = '';
	
	/**
	 * 
	 * @Solr\Field(type="string")
	 */
	private $text = '';
	
	public function __construct() {
		$this->oneToOne = new ValidTestEntity();
	}
}

?>