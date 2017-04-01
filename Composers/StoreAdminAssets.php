<?php namespace Modules\Store\Composers;


use Illuminate\Contracts\View\View;
use Modules\Core\Foundation\Asset\Pipeline\AssetPipeline;

class StoreAdminAssets
{
    /**
     * @var AssetPipeline
     */
    private $assetPipeline;

    public function __construct(AssetPipeline $assetPipeline)
    {

        $this->assetPipeline = $assetPipeline;
    }

    public function compose(View $view)
    {
        $this->assetPipeline->requireJs('x-editable.js');
        $this->assetPipeline->requireCss('x-editable.css');
    }
}