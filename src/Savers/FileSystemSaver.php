<?php
namespace Sellastica\DocumentationExporter\Savers;

use Sellastica\DocumentationExporter\ISaver;

class FileSystemSaver implements ISaver
{
	/** @var string */
	private $path;


	/**
	 * @param string $path
	 */
	public function __construct(string $path)
	{
		$this->path = $path;
	}

	/**
	 * @param string $string
	 * @param string $identifier
	 */
	function save(string $string, string $identifier): void
	{
		if (!is_dir($this->path)) {
			mkdir($this->path, 0755, true);
		}

		file_put_contents($this->path . '/' . $identifier, $string);
	}
}
