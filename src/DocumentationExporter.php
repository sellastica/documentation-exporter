<?php
namespace Sellastica\DocumentationExporter;

class DocumentationExporter
{
	/** @var array */
	private $classNames = [];
	/** @var \Sellastica\DocumentationExporter\IPageExporter[] */
	private $pageExporters = [];
	/** @var \Sellastica\DocumentationExporter\ISaver */
	private $saver;


	/**
	 * @param string $className
	 * @param string $identifier
	 * @return $this
	 */
	public function addClass(string $className, string $identifier): DocumentationExporter
	{
		$this->classNames[$className] = $identifier;
		return $this;
	}

	/**
	 * @param \Sellastica\DocumentationExporter\IPageExporter $pageExporter
	 * @return DocumentationExporter
	 */
	public function addPageExporter(\Sellastica\DocumentationExporter\IPageExporter $pageExporter): DocumentationExporter
	{
		$this->pageExporters[] = $pageExporter;
		return $this;
	}

	/**
	 * @param \Sellastica\DocumentationExporter\ISaver $saver
	 * @return DocumentationExporter
	 */
	public function setSaver(\Sellastica\DocumentationExporter\ISaver $saver): DocumentationExporter
	{
		$this->saver = $saver;
		return $this;
	}

	public function export(): void
	{
		if (!$this->saver) {
			throw new \Exception('No saver defined');
		}

		foreach ($this->classNames as $className => $identifier) {
			$page = '';
			foreach ($this->pageExporters as $exporter) {
				$page .= PHP_EOL . $exporter->export($className);
			}

			$this->saver->save($page, $identifier);
		}
	}
}
