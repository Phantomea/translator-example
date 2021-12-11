<?php

namespace App;

class Translator
{
	/** @var string[] */
	private array $langs = ['en', 'sk'];

	/** @persistent */
	public string $lang;

	public function __construct()
	{
		$this->lang = $this->lang ?? $this->langs[0];
	}

	public function getLangs(): array
	{
		return $this->langs;
	}

	public function setLang(string $lang): Translator
	{
		$this->lang = $lang;
		return $this;
	}

	public function translate(string $index, string $originText): string
	{
		$jsonFile = @\file_get_contents($this->getJsonFilePath($this->lang));

		// If file for selected language [$this->lang] does not exist
		// create it and write the default text [$originText] on index[$index]
		if (!$jsonFile) {
			$json = fopen($this->getJsonFilePath($this->lang), 'w');
			\fwrite($json, json_encode([$index => $originText]));
			\fclose($json);

			$jsonFile = \file_get_contents($this->getJsonFilePath($this->lang));
		}

		$jsonFileDecoded = \json_decode($jsonFile, true);

		if (!isset($jsonFileDecoded[$index])) {
			$json = fopen($this->getJsonFilePath($this->lang), 'w');
			\fwrite($json, \json_encode($jsonFileDecoded + [$index => $originText]));
			\fclose($json);
			$jsonFile = \file_get_contents($this->getJsonFilePath($this->lang));
			$jsonFileDecoded = \json_decode($jsonFile, true);
		}

		return $jsonFileDecoded[$index];
	}

	private function getJsonFileName(string $lang)
	{
		return "$lang-translations.json";
	}

	private function getJsonFilePath(string $lang)
	{
		return __DIR__ .'./../translations/' . $this->getJsonFileName($lang);
	}
}