<?php

declare(strict_types=1);

namespace PharIo\Mediator;

final class Configuration
{
	private $pluginName;

	private $pharName;

	private $pharDownloadLocation;

	private $pharSignatureDownloadLocation;

	public function __construct(
		string $pluginName,
		string $pharName,
		string $pharDownloadLocation,
		string $pharSignatureDownloadLocation
	) {
		$this->pharName                      = $pharName;
		$this->pluginName                    = $pluginName;
		$this->pharDownloadLocation          = $pharDownloadLocation;
		$this->pharSignatureDownloadLocation = $pharSignatureDownloadLocation;
	}

	public function pluginName(): string
	{
		return $this->pluginName;


	}

	public function pharName(): string
	{
		return $this->pharName;
	}

	public function pharDownloadLocation(): string
	{
		return $this->pharDownloadLocation;
	}

	public function pharSignatureDownloadLocation(): string
	{
		return $this->pharSignatureDownloadLocation;
	}
}
