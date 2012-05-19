<?php
namespace FS\SolrBundle\Tests;
class SolrClientFake {
	private $commit = false;
	private $commits = 0;
	
	public function addDocument($doc) {}
	
	public function deleteByQuery($query) {}
	
	public function commit() {
		$this->commits++;
		$this->commit = true;
	}
	
	public function getCommits() {
		return $this->commits;
	}
	
	public function isCommited() {
		return $this->commit;
	}
}
