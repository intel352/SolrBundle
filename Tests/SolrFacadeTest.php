<?php

namespace FS\SolrBundle\Tests\Solr;

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
 *  @group solr
 */
class SolrFacadeTest extends \PHPUnit_Framework_TestCase {

	private $metaFactory = null;
	private $config = null;
	private $commandFactory = null;
	private $eventManager = null;
	private $indexer = null;
	
	private $solr = null;
	
	private $metaInformation = null;
	
	public function setUp() {
		$this->metaFactory = $metaFactory = $this->getMock('FS\SolrBundle\Doctrine\Mapper\MetaInformationFactory', array(), array(), '', false);
		$this->config = $this->getMock('FS\SolrBundle\SolrConnection', array(), array(), '', false);
		$this->commandFactory = CommandFactoryStub::getFactoryWithAllMappingCommand();
		$this->eventManager = $this->getMock('FS\SolrBundle\Event\EventManager', array(), array(), '', false);
		$this->indexer = $this->getMock('FS\SolrBundle\Indexer\IndexerInterface', array(), array(), '', false);
		
		$this->solr = new SolrFacade($this->config, $this->commandFactory, $this->eventManager, $this->metaFactory, $this->indexer);
	}
	
	private function setupDoctrine($namespace) {
		$doctrineConfiguration = $this->getMock('Doctrine\ORM\Configuration', array(), array(), '', false);
		$doctrineConfiguration->expects($this->any())
							  ->method('getEntityNamespace')
							  ->will($this->returnValue($namespace));

		return $doctrineConfiguration;
	}
	
	private function setupMetaFactoryLoadOneCompleteInformation($metaInformation = null) {
		if (null === $metaInformation) {
			$this->metaInformation = MetaTestInformationFactory::getMetaInformation();
		} else {
			$this->metaInformation = $metaInformation;
		}
		
		$this->metaFactory->expects($this->once())
						  ->method('loadInformation')
						  ->will($this->returnValue($this->metaInformation));		
	}
	
	public function testCreateQuery_ValidEntity() {
		$this->setupMetaFactoryLoadOneCompleteInformation();
		
		$query = $this->solr->createQuery('FSBlogBundle:ValidTestEntity');
		
		$this->assertTrue($query instanceof SolrQuery);
		$this->assertEquals(4, count($query->getMappedFields()));		
		
	}

	public function testGetRepository_UserdefinedRepository() {
		$metaInformation = new MetaInformation();
		$metaInformation->setClassName(get_class(new EntityWithRepository()));
		$metaInformation->setRepository('FS\SolrBundle\Tests\Doctrine\Annotation\Entities\ValidEntityRepository');
		
		$this->setupMetaFactoryLoadOneCompleteInformation($metaInformation);	
		
		$actual = $this->solr->getRepository('Tests:EntityWithRepository');
		
		$this->assertTrue($actual instanceof ValidEntityRepository);
	}
	
	/**
	 * @expectedException RuntimeException
	 */
	public function testGetRepository_UserdefinedInvalidRepository() {
		$metaInformation = new MetaInformation();
		$metaInformation->setClassName(get_class(new EntityWithRepository()));
		$metaInformation->setRepository('FS\SolrBundle\Tests\Doctrine\Annotation\Entities\InvalidEntityRepository');
		
		$this->setupMetaFactoryLoadOneCompleteInformation($metaInformation);	
		
		$this->solr->getRepository('Tests:EntityWithInvalidRepository');
	}
	
	public function testAddDocument() {
		$solrClientFake = new SolrClientFake();
		
		$this->config->expects($this->any())
				   	 ->method('getClient')
				   	 ->will($this->returnValue($solrClientFake));
		
		$this->eventManager->expects($this->once())
					 	   ->method('handle')
					 	   ->with(EventManager::INSERT);					 
		
		$this->setupMetaFactoryLoadOneCompleteInformation();
		
		$this->indexer->expects($this->once())
					  ->method('toIndex')
					  ->with($this->equalTo($this->metaInformation));
				
		$this->solr = new SolrFacade($this->config, $this->commandFactory, $this->eventManager, $this->metaFactory, $this->indexer);
		$this->solr->addDocument(new ValidTestEntity());
	}
	
	public function testUpdateDocument() {
		$solrClientFake = new SolrClientFake();
	
		$this->config->expects($this->any())
					 ->method('getClient')
					 ->will($this->returnValue($solrClientFake));
	
		$this->eventManager->expects($this->once())
			 			   ->method('handle')
						   ->with(EventManager::UPDATE);
	
		$this->setupMetaFactoryLoadOneCompleteInformation();

		$this->indexer->expects($this->once())
					  ->method('toIndex')
					  ->with($this->equalTo($this->metaInformation));		
		
		$this->solr = new SolrFacade($this->config, $this->commandFactory, $this->eventManager, $this->metaFactory, $this->indexer);
		$this->solr->updateDocument(new ValidTestEntity());
	}	
	
	public function testRemoveDocument() {
		$solrClientFake = new SolrClientFake();
	
		$this->config->expects($this->once())
					 ->method('getClient')
					 ->will($this->returnValue($solrClientFake));
	
		$this->eventManager->expects($this->once())
						   ->method('handle')
						   ->with(EventManager::DELETE);
	
		$this->setupMetaFactoryLoadOneCompleteInformation();
	
		$this->solr = new SolrFacade($this->config, $this->commandFactory, $this->eventManager, $this->metaFactory, $this->indexer);
		$this->solr->removeDocument(new ValidTestEntity());
	
		$this->assertTrue($solrClientFake->isCommited(), 'commit was never called');
	}	
}

