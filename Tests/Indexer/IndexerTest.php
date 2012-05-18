<?php

namespace FS\SolrBundle\Tests\Indexer;

use FS\SolrBundle\Indexer\Indexer;

use FS\SolrBundle\Event\EventManager;

use FS\SolrBundle\Tests\SolrClientFake;

use FS\SolrBundle\Tests\Doctrine\Mapper\ValidTestEntity;

use FS\SolrBundle\Tests\Doctrine\Annotation\Entities\EntityWithRepository;

use FS\SolrBundle\Doctrine\Mapper\MetaInformation;

use FS\SolrBundle\Tests\Util\MetaTestInformationFactory;

use FS\SolrBundle\SolrFacade;
use FS\SolrBundle\Tests\Doctrine\Annotation\Entities\ValidEntityRepository;
use FS\SolrBundle\Tests\Util\CommandFactoryStub;
use FS\SolrBundle\Doctrine\Mapper\Mapping\MapAllFieldsCommand;
use FS\SolrBundle\Doctrine\Annotation\AnnotationReader;
use FS\SolrBundle\Doctrine\Mapper\Mapping\CommandFactory;
use FS\SolrBundle\Query\SolrQuery;
use FS\SolrBundle\SolrQueryFacade;

/**
 *  test case.
 */
class IndexerTest extends \PHPUnit_Framework_TestCase {

	private $solrConnection = null;
	private $commandFactory = null;
	
	public function setUp() {
		$this->solrConnection = $this->getMock('FS\SolrBundle\SolrConnection', array(), array(), '', false);
		$this->commandFactory = CommandFactoryStub::getFactoryWithAllMappingCommand();
	}
	
	private function setupMetaFactoryLoadOneCompleteInformation($metaInformation = null) {
		if (null === $metaInformation) {
			$metaInformation = MetaTestInformationFactory::getMetaInformation();
		}
		
		$this->metaFactory->expects($this->once())
						  ->method('loadInformation')
						  ->will($this->returnValue($metaInformation));		
	}
	
	public function testAddDocument() {
		$solrClientFake = new SolrClientFake();
		
		$this->solrConnection->expects($this->once())
				   	 ->method('getClient')
				   	 ->will($this->returnValue($solrClientFake));

		$metaInformation = MetaTestInformationFactory::getMetaInformation();
		
		$indexer = new Indexer($this->solrConnection, $this->commandFactory);
		$indexer->toIndex($metaInformation);
		
		$this->assertTrue($solrClientFake->isCommited(), 'commit was never called');
	}
	
	public function UpdateDocument() {
		$solrClientFake = new SolrClientFake();
	
		$this->solrConnection->expects($this->once())
					 ->method('getClient')
					 ->will($this->returnValue($solrClientFake));
	
		$this->setupMetaFactoryLoadOneCompleteInformation();
	
		$solr = new SolrFacade($this->solrConnection, $this->commandFactory, $this->eventManager, $this->metaFactory);
		$solr->updateDocument(new ValidTestEntity());
	
		$this->assertTrue($solrClientFake->isCommited(), 'commit was never called');
	}	
	
	public function RemoveDocument() {
		$solrClientFake = new SolrClientFake();
	
		$this->solrConnection->expects($this->once())
					 ->method('getClient')
					 ->will($this->returnValue($solrClientFake));
	
		$this->eventManager->expects($this->once())
						   ->method('handle')
						   ->with(EventManager::DELETE);
	
		$this->setupMetaFactoryLoadOneCompleteInformation();
	
		$solr = new SolrFacade($this->solrConnection, $this->commandFactory, $this->eventManager, $this->metaFactory);
		$solr->removeDocument(new ValidTestEntity());
	
		$this->assertTrue($solrClientFake->isCommited(), 'commit was never called');
	}	
}

