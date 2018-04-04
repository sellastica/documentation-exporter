<?php
namespace Sellastica\DocumentationExporter;

interface IPageExporter
{
	/**
	 * @param string $className
	 * @return null|string
	 */
	function export(string $className): ?string;
}
