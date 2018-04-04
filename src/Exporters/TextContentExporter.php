<?php
namespace Sellastica\DocumentationExporter\Exporters;

class TextContentExporter extends AbstractPageExporter implements \Sellastica\DocumentationExporter\IPageExporter
{
	/**
	 * @param string $className
	 * @return null|string
	 */
	public function export(string $className): ?string
	{
		$reflection = new \Sellastica\Reflection\ReflectionClass($className);
		$annotations = [];

		foreach ($reflection->getMethods(-1, false) as $method) {
			$annotationReflection = $this->getAnnotationReflection($method);
			if (!$method->hasAnnotation('export-documentation')) {
				continue;
			}

			//heading
			$annotations[] = '<h2>' . $this->getAttributeName($method) . '</h2>' . PHP_EOL;
			$annotations[] = $annotationReflection->getText();
		}

		return sizeof($annotations)
			? $this->format(join(PHP_EOL, $annotations))
			: null;
	}
}
