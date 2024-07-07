<?php

declare(strict_types=1);

namespace TestDoubles\CDP\Http;

use App\CDP\Analytics\Model\ModelInterface;
use App\CDP\Http\CdpClient;

class FakeCdpClient extends CdpClient
{
    private int $identifyCallCount = 0;

    private ModelInterface $identifyModel;

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
}
