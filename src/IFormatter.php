<?php
namespace Sellastica\DocumentationExporter;

interface IFormatter
{
	/**
	 * @param string $string
	 * @return string
	 */
	function format(string $string): string;
}
