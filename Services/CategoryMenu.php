<?php namespace Modules\Store\Services;


use Modules\Store\Entities\Category;
use Modules\Store\Repositories\CategoryRepository;

class CategoryMenu
{
    /**
     * @var CategoryRepository
     */
    private $category;
    private $html  = '';

    public function __construct(CategoryRepository $category)
    {

        $this->category = $category;
    }

    public function getCategories()
    {
        return $this->category->all()->toHierarchy();
    }

    public function getOpenTagWrapper()
    {
        return '<ul class="product-categories">'.PHP_EOL;
    }

    public function getCloseTagWrapper()
    {
        return '</ul>'.PHP_EOL;
    }

    public function getActiveState($item, $class='')
    {
        $slug = '';
        if(is_array(request()->segments()))
        {
            $slug = last(request()->segments());
        }
        return $item->slug == $slug ? $class : '';
    }

    public function addMenu(Category $item)
    {
        $html = '';
        if($item->isLeaf())
        {
            $html .= '<li class="c-font-14 '.$this->getActiveState($item, 'c-active c-open').'">'.PHP_EOL;
            $html .= '<a href="'.$item->url.'">'.$item->title.PHP_EOL;
            $html .= '</a>'.PHP_EOL;
            $html .= '</li>'.PHP_EOL;

        } else {

            $html .= '<li class="c-dropdown c-open '.$this->getActiveState($item, 'c-active').'">'.PHP_EOL;
            $html .= '<a href="'.$item->url.'">'.$item->title.PHP_EOL;
            $html .= '<span class="c-toggler c-arrow"></span>';
            $html .= '</a>'.PHP_EOL;

            $html .= '<ul class="c-dropdown-menu">'.PHP_EOL;
            foreach ($item->children as $child)
            {
                $html .= $this->addMenu($child);
            }
            $html .= '</ul>'.PHP_EOL;

            $html .= '</li>'.PHP_EOL;
        }
        return $html;
    }

    public function render()
    {
        $categories = $this->getCategories();

        $this->html .= $this->getOpenTagWrapper();
        foreach ($categories as $category)
        {
            $this->html .= $this->addMenu($category);
        }
        $this->html .= $this->getCloseTagWrapper();

        return $this->html;
    }
}