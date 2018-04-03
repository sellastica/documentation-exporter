<?php
namespace Sellastica\DocumentationExporter;

interface IPreprocessor
{
	/**
	 * @param string $string
	 * @return string
	 */
	function process(string $string): string; 
}
