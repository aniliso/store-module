<?php

if (!function_exists('categorySeperator')) {
    function categorySeperator($trees, $column, $seperator='') {
        $html = '';
        if($trees->count()>0)
        {
            $i=1;
            foreach ($trees as $tree)
            {
                $html .= $tree->{$column};
                $html .= $trees->count() != $i ? $seperator : '';
                $i++;
            }
            return $html;
        }
        return null;
    }
}

if (! function_exists('renderNode')) {
    function renderNode($node) {

        $html = '<ul>';

        if( $node->isLeaf() ) {
            $html .= '<li>' . $node->title . '</li>';
        } else {
            $html .= '<li>' . $node->title;

            $html .= '<ul>';

            foreach($node->children as $child)
                $html .= renderNode($child);

            $html .= '</ul>';

            $html .= '</li>';
        }

        $html .= '</ul>';

        return $html;
    }
}