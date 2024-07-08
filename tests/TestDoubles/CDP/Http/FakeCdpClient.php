<?php

declare(strict_types=1);

namespace App\Tests\TestDoubles\CDP\Http;

use App\CDP\Analytics\Model\ModelInterface;
use App\CDP\Http\CdpClient;

class FakeCdpClient extends CdpClient
{
    private int $identifyCallCount = 0;

    private ModelInterface $identifyModel;

    private int $trackCallCount = 0;

    private ModelInterface $trackModel;

    public function identify(ModelInterface $model): void
    {
        // Increment an identify call count
        $this->identifyCallCount++;

        // Store the model so that the forwarded data can be checked
        $this->identifyModel = $model;
    }

    public function getIdentifyCallCount(): int
    {
        return $this->identifyCallCount;
    }

    public function setIdentifyCallCount(int $identifyCallCount): void
    {
        $this->identifyCallCount = $identifyCallCount;
    }

    public function getIdentifyModel(): ModelInterface
    {
        return $this->identifyModel;
    }

    public function setIdentifyModel(ModelInterface $identifyModel): void
    {
        $this->identifyModel = $identifyModel;
    }

    public function track(ModelInterface $model): void
    {
        $this->trackCallCount++;

        $this->identifyModel = $model;
    }

    public function getTrackCallCount(): int
    {
        return $this->trackCallCount;
    }

    public function getTrackModel(): ModelInterface
    {
        return $this->trackModel;
    }
}
