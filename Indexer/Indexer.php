<?php
namespace FS\SolrBundle\Indexer;

use FS\SolrBundle\Doctrine\Mapper\RelationMetaInformation;

use FS\SolrBundle\Doctrine\Mapper\Mapping\CommandFactory;
use FS\SolrBundle\SolrConnection;
use FS\SolrBundle\Doctrine\Mapper\EntityMapper;
use FS\SolrBundle\Doctrine\Mapper\MetaInformation;

class Indexer implements IndexerInterface {
	
	/**
	 * 
	 * @var EntityMapper
	 */
	private $mapper = null;
	
	/**
	 *
	 * @var CommandFactory
	 */
	private $commandFactory = null;

	/**
	 *
	 * @var \SolrClient
	 */
	private $solrClient = null;

	/**
	 * 
	 * @param SolrConnection $connection
	 * @param CommandFactory $commandFactory
	 */
	public function __construct(SolrConnection $connection, CommandFactory $commandFactory) {
		$this->solrClient = $connection->getClient();
		$this->commandFactory = $commandFactory;
		$this->mapper = new EntityMapper();
	}
	
	/* (non-PHPdoc)
	 * @see FS\SolrBundle\Indexer.IndexerInterface::toIndex()
	 */
	public function toIndex(MetaInformation $metaInformation) {
		$command = $this->commandFactory->getMapAllFieldsCommand();
		$this->mapper->setMappingCommand($command);

		if ($metaInformation->hasRelations()) {
			$this->indexOneToOne($metaInformation->getOneToOne());	
		}
		
		$document = $this->mapper->toDocument($metaInformation);
		
		$this->addDocumentToIndex($document);
	}

	private function indexOneToOne(array $oneToOne) {
		foreach ($oneToOne as $relationInformations) {
			if ($relationInformations instanceof RelationMetaInformation) {
				$document = $this->mapper->toDocument($relationInformations);
				$this->addDocumentToIndex($document);
			}
		}		
	}
	
	private function addDocumentToIndex($doc) {
		try {
			$updateResponse = $this->solrClient->addDocument($doc);
				
			$this->solrClient->commit();
		} catch (\Exception $e) {
			throw new IndexerException('could not index entity'. $e->getMessage());
		}
	}	
	
}
