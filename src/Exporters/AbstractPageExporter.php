<?php
namespace Sellastica\DocumentationExporter\Exporters;

abstract class AbstractPageExporter
{
	/** @var \Sellastica\DocumentationExporter\IFormatter[] */
	protected $formatters = [];


	/**
	 * @param \Sellastica\DocumentationExporter\IFormatter $formatter
	 * @return $this
	 */
	public function addFormatter(\Sellastica\DocumentationExporter\IFormatter $formatter)
	{
		$this->formatters[get_class($formatter)] = $formatter;
		return $this;
	}

	/**
	 * @param string $string
	 * @return null|string
	 */
	protected function format(string $string): ?string
	{
		if (empty($string)) {
			return null;
		}

		foreach ($this->formatters as $formatter) {
			$string = $formatter->format($string);
		}

		return $string ?: null;
	}

	/**
	 * @param \Nette\Reflection\Method $method
	 * @return \Barryvdh\Reflection\DocBlock
	 */
	protected function getAnnotationReflection(\Nette\Reflection\Method $method): \Barryvdh\Reflection\DocBlock
	{
		return new \Barryvdh\Reflection\DocBlock($method);
	}

	/**
	 * Returns attribute name from method name
	 *
	 * @param \Nette\Reflection\Method $method
	 * @return string
	 */
	protected function getAttributeName(\Nette\Reflection\Method $method): string
	{
		return preg_match('~^get.*$~', $method->getName())
			? \Nette\Utils\Strings::lower(\Nette\Utils\Strings::after($method->getName(), 'get'))
			: $method->getName();

	}
}
