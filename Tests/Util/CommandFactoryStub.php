<?php
namespace FS\SolrBundle\Tests\Util;

use FS\SolrBundle\Doctrine\Mapping\Mapper\Command\MapIdentifierCommand;
use FS\SolrBundle\Doctrine\Mapping\Mapper\Command\MapAllFieldsCommand;
use FS\SolrBundle\Doctrine\Annotation\AnnotationReader;
use FS\SolrBundle\Doctrine\Mapping\Mapper\Command\CommandFactory;

class CommandFactoryStub {

	/**
	 * @return CommandFactory
	 */
	public static function getFactoryWithAllMappingCommand() {
		$commandFactory = new CommandFactory();
		$commandFactory->add(new MapAllFieldsCommand(), 'all');
		$commandFactory->add(new MapIdentifierCommand(), 'identifier');
		
		return $commandFactory;		
	}
}

?>