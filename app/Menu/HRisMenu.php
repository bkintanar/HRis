<?php

namespace HRis\Menu;

use HRis\Eloquent\Navlink;

class HRisMenu extends Menu
{

	protected $model;

	public function __construct()
	{
		$model = new Navlink();
		parent::__construct($model);
	}

	public function make()
	{
		$this->inner(function($menu, $body, $is_active, $is_nested) {
				$output = '<li ' . ($is_active ? 'class="active"' : '') . '>';
				$output .= '<a href="/' . $menu->href . '">';
				$output .= '<i class="fa ' . $menu->icon . '"></i>';
				$output .= '<span class="nav-label">' . $menu->name . '</span>';
				$output .= $is_nested ? '<span class="fa arrow"></span>' : '';
				$output .= '</a>';
				$output .= $body;
				$output .= '</li>';

				return $output;
			})
			->outer(function($menuBody) {
				return $menuBody;
			})
			->addLevel()
			->outer(function($menuBody) {
				$output = '<ul class="nav nav-second-level">';
				$output .= $menuBody;
				$output .= '</ul>';

				return $output;
			})
			->addLevel()
			->outer(function($menuBody) {
				$output = '<ul class="nav nav-third-level">';
				$output .= $menuBody;
				$output .= '</ul>';

				return $output;
			});

		return parent::make();
	}

	public function breadcrumb()
	{
		$this->setInnerBreadcrumb(function($breadcrumb) {
				$output = '<li>';
				$output .= '<a href="/' . $breadcrumb->href . '">';
				$output .= $breadcrumb->name;
				$output .= '</a>';
				$output .= '</li>';

				return $output;
			})
			->setOuterBreadcrumb(function($body) {
				$output = $body;

				return $output;
			});

		return parent::breadcrumb();
	}
}