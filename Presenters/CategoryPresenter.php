<?php namespace Modules\Store\Presenters;

class CategoryPresenter extends BaseStorePresenter
{
    protected $zone = 'categoryImages';
    protected $slug = 'uri';
    protected $transKey = 'store::routes.category.slug';
    protected $routeKey = 'store.category.slug';
    protected $descriptionKey = 'description';

    public function titleWithoutSelf($divider = ',')
    {
        return $this->entity->getAncestors()->toHierarchy()->map(function ($category) use ($divider) {
            return $this->_renderTitleTree($category, $divider);
        })->implode($divider);
    }

    public function titleWithSelf($divider = ',')
    {
        return $this->entity->getAncestorsAndSelf()->toHierarchy()->map(function ($category) use ($divider) {
            return $this->_renderTitleTree($category, $divider);
        })->implode($divider);
    }

    private function _renderTitleTree($node, $divider = ', ')
    {
        $html = '';
        if ($node->isLeaf()) {
            $html .= $node->title;
        } else {
            $html .= $node->title;
            foreach ($node->children as $child) {
                $html .= $divider . $this->_renderTitleTree($child, $divider);
            }
        }
        return $html;
    }
}