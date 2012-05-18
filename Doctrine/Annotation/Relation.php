<?php
namespace FS\SolrBundle\Doctrine\Annotation;

use Doctrine\Common\Annotations\Annotation;

abstract class Relation extends Annotation {
	public $target = '';
	public $name = '';
	
	abstract public function getFieldName();
}

?>