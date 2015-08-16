<?php

namespace HRis\Menu;

use Illuminate\Support\Facades\Request;

class Breadcrumb
{
	protected $inner_breadcrumb;
    protected $outer_breadcrumb;
    protected $request;

    public function __construct()
    {
        $this->request = Request::capture();
    }

    public function setInnerBreadcrumb(callable $inner)
    {
        $this->inner_breadcrumb = $inner;

        return $this;
    }

    public function setOuterBreadcrumb(callable $outer)
    {
        $this->outer_breadcrumb = $outer;

        return $this;
    }

    public function isActive($href)
    {
        if ($this->request->is($href.'*')) {
            return true;
        }

        return false;
    }

    private function linkName($link) 
    {
        $name = str_replace('-', ' ', $link);
        return ucwords($name);
    }

    public function links()
    {
        $sublinks = explode('/', $this->request->path());
        $links = [];
        $first = true;
        $href = '';

        foreach ($sublinks as $sublink) {
            if ($first) {
                $href .= $sublink;
                $first = false;
            } else {
                $href .= '/'.$sublink;
            }

            $links[] = (object) [
                'name' => $this->linkName($sublink),
                'href' => $href,
            ];
        }

        return $links;
    }

    public function breadcrumb()
    {
        $output = '';
        $inner = '';

        foreach ($this->links() as $link) {
            $inner .= call_user_func($this->inner_breadcrumb, $link);    
        }

        $output .= call_user_func($this->outer_breadcrumb, $inner);

        return $output;
    }
}