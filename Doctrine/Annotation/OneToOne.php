<?php
namespace FS\SolrBundle\Doctrine\Annotation;

class OneToOne extends Relation {
	public function getFieldName() {
		return $this->name. '_rel_i';
	}
}

?>