<?php
namespace Sellastica\DocumentationExporter\Exporters;

class SummaryTableExporter extends AbstractPageExporter implements \Sellastica\DocumentationExporter\IPageExporter
{
	/**
	 * @param string $className
	 * @return null|string
	 */
	public function export(string $className): ?string
	{
		$reflection = new \Sellastica\Reflection\ReflectionClass($className);
		$annotations = [];

		$table = <<<HEAD
|-----------------------------
| Attribute | Return type | Description
|-----------------------------
HEAD;

		foreach ($reflection->getMethods(-1, false) as $method) {
			if ($method->hasAnnotation('export-documentation')) {
				$returnType = $method->getAnnotation('return-type') ?: $method->getReturnType();
				if (!in_array($returnType, ['string', 'float', 'int', 'bool', 'array'])) {
					throw new \Exception(sprintf(
						'Unknown return "%s" type in %s::%s', $returnType, $reflection->getName(), $method->getName()
					));
				}

				if ($returnType instanceof \ReflectionNamedType && $returnType->allowsNull()) {
					$returnType .= ' or null';
				}

				$table .= PHP_EOL
					. '| '
					. $this->getAttributeName($method)
					. ' | '
					. $returnType
					. ' | '
					. $this->getAnnotationReflection($method)->getShortDescription();
			}
		}

		return strlen($table)
			? $this->format($table)
			: null;
	}
}
