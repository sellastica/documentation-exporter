<?php
namespace Sellastica\DocumentationExporter;

interface ISaver
{
	/**
	 * @param string $string
	 * @param string $identifier
	 */
	function save(string $string, string $identifier): void;
}
