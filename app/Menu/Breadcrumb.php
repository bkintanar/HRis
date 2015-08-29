<?php

namespace HRis\Menu;

use Illuminate\Support\Facades\Request;

class Breadcrumb
{
    /**
     * Inner breadcrumb HTML string builder
     * @var callable
     */
    protected $inner_breadcrumb;

    /**
     * Other breadcrumb HTML string builder
     * @var callable
     */
    protected $outer_breadcrumb;

    /**
     * Access current request
     * @var Request
     */
    protected $request;

    /**
     * Breadcrumb constructor
     * @author Harlequin Doyon
     */
    public function __construct()
    {
        $this->request = Request::capture();
    }

    /**
     * Inner HTML breadcrumb callback method
     * @param callable $inner
     * @author Harlequin Doyon
     */
    public function setInnerBreadcrumb(callable $inner)
    {
        $this->inner_breadcrumb = $inner;

        return $this;
    }

    /**
     * Outer HTML breadcrumb callback method
     * @param callable $outer
     * @author Harlequin Doyon
     */
    public function setOuterBreadcrumb(callable $outer)
    {
        $this->outer_breadcrumb = $outer;

        return $this;
    }

    /**
     * Check if href is currently active URL
     * @param  string  $href
     * @return boolean
     * @author Harlequin Doyon
     */
    public function isActive($href)
    {
        if ($this->request->is($href.'*')) {
            return true;
        }

        return false;
    }

    /**
     * Format link to a phrase
     * ex. "hello-world" to "Hello World"
     * 
     * @param  string $link 
     * @return string
     * @author Harlequin Doyon
     */
    private function linkToPhrase($link)
    {
        $name = str_replace('-', ' ', $link);

        return ucwords($name);
    }

    /**
     * Break link slashes to object array
     * @return array
     * @author Harlequin Doyon
     */
    public function links()
    {
        $sublinks = explode('/', $this->request->path());
        $links = [];
        $href = '';

        foreach ($sublinks as $index => $sublink) {
            if(! $index) $href .= '/';
            $href .= $sublink;

            $links[] = (object) [
                'name' => $this->linkToPhrase($sublink),
                'href' => $href,
            ];
        }

        return $links;
    }

    /**
     * Generate breadcrumb HTML
     * @return string
     * @author Harlequin Doyon
     */
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
