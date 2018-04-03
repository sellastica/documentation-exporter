<?php
namespace Sellastica\DocumentationExporter\Preprocessors;

use Sellastica\DocumentationExporter\IPreprocessor;

class TexyPreprocessor implements IPreprocessor
{
	/** @var \Texy\Texy */
	private $texy;


	public function __construct()
	{
		$this->texy = new \Texy\Texy();
		$this->texy->tabWidth = 4;
	}

	/**
	 * @param string $string
	 * @return string
	 */
	function process(string $string): string
	{
		return $this->texy->process($string);
	}
}
