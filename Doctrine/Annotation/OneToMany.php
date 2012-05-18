<?php
namespace FS\SolrBundle\Doctrine\Annotation;

/**
 * @Annotation
 */
class OneToMany extends Relation {
	public function getFieldName() {
		return '';
	}
}

?>