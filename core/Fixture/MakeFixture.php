<?php
namespace Speeder\Fixture;

use Speeder\Kernel\AppKernel;

class MakeFixture
{
    protected $manager;
    public function __construct()
    {
        include AppKernel::GetProjectDir().AppKernel::Ds().'config'.AppKernel::Ds().'bootstrap.php';
        $this->manager=$entityManager;
    }
}
