<?php
namespace Sellastica\DocumentationExporter;

class DocumentationExporter
{
	/** @var array */
	private $classNames = [];
	/** @var \Sellastica\DocumentationExporter\IPreprocessor */
	private $preprocessors = [];
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
			$reflection = new \Sellastica\Reflection\ReflectionClass($className);
			foreach ($reflection->getMethods(-1, false) as $method) {
				if ($method->hasAnnotation('export-documentation')) {
					$this->saver->save(
						$this->getAnnotation($method),
						$identifier
					);
				}
			}
		}
	}

	/**
	 * @param \Sellastica\DocumentationExporter\IPreprocessor $preprocessor
	 * @return $this
	 */
	public function addPreprocessor(\Sellastica\DocumentationExporter\IPreprocessor $preprocessor)
	{
		$this->preprocessors[get_class($preprocessor)] = $preprocessor;
		return $this;
	}

	/**
	 * @param \Nette\Reflection\Method $method
	 * @return null|string
	 */
	private function getAnnotation(\Nette\Reflection\Method $method): ?string
	{
		$phpdoc = new \Barryvdh\Reflection\DocBlock($method);
		$description = $phpdoc->getText();
		if (empty($description)) {
			return null;
		}

		foreach ($this->preprocessors as $preprocessor) {
			$description = $preprocessor->process($description);
		}

		return $description ?: null;
	}
}
