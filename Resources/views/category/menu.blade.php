@if(isset($categories))
    <ul class="c-sidebar-menu collapse " id="sidebar-menu-1">
        @foreach($categories->get() as $cat)
            <li class="c-dropdown @if($loop->first)c-active c-open @endif">
                <a href="{{ $cat->url }}">{{ $cat->title }}
                    <span class="c-toggler c-arrow"></span>
                </a>
                @if($cat->children()->exists())
                    @foreach($cat->children()->get() as $child)
                        <ul class="c-dropdown-menu">
                            <li><a href="{{ $child->url }}">{{ $child->title }}</a></li>
                        </ul>
                    @endforeach
                @endif
            </li>
        @endforeach
    </ul>
@elseif(isset($category))
    <ul class="c-sidebar-menu collapse " id="sidebar-menu-1">
        <li class="c-dropdown c-active c-open">
            <a href="{{ $cat->url }}" class="c-toggler">{{ $category->title }}
                <span class="c-arrow"></span>
            </a>
            @if($category->children()->exists())
                @foreach($category->children()->get() as $child)
                    <ul class="c-dropdown-menu">
                        <li><a href="{{ $child->url }}">{{ $child->title }}</a></li>
                    </ul>
                @endforeach
            @endif
        </li>
    </ul>
@endif