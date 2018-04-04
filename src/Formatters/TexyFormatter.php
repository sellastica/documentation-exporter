<?php
namespace Sellastica\DocumentationExporter\Formatters;

use Sellastica\DocumentationExporter\IFormatter;

class TexyFormatter implements IFormatter
{
	/** @var \Texy\Texy */
	private $texy;


	public function __construct()
	{
		$this->texy = new \Texy\Texy();
		$this->texy->tabWidth = 4;
		$this->texy->headingModule->top = 2;
	}

	/**
	 * @param string $string
	 * @return string
	 */
	function format(string $string): string
	{
		return $this->texy->process($string);
	}
}
