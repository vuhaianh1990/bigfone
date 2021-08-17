<?php

use Illuminate\Contracts\View\Factory as ViewFactory;


// Core Module Name
$GLOBALS['av_core'] = 'av_core::';

if (! function_exists('admin_route')) {
  /**
   * Generate the URL to a named admin_route.
   *
   * @param  array|string  $name
   * @param  mixed  $parameters
   * @param  bool  $absolute
   * @return string
   */
  function admin_route($name, $parameters = [], $absolute = true)
  {
      $admin_name = 'admin.' . $name;
      return app('url')->route($admin_name, $parameters, $absolute);
  }
}

if (! function_exists('superadmin_route')) {
  /**
   * Generate the URL to a named admin_route.
   *
   * @param  array|string  $name
   * @param  mixed  $parameters
   * @param  bool  $absolute
   * @return string
   */
  function superadmin_route($name, $parameters = [], $absolute = true)
  {
      $admin_name = 'superadmin.' . $name;
      return app('url')->route($admin_name, $parameters, $absolute);
  }
}

if (! function_exists('admin_view')) {
  /**
   * Get the evaluated view contents for the given view.
   *
   * @param  string  $view
   * @param  array   $data
   * @param  array   $mergeData
   * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
   */
  function admin_view($view = null, $data = [], $mergeData = [])
  {
      $factory = app(ViewFactory::class);

      if (func_num_args() === 0) {
          return $factory;
      }

      $admin_view = $GLOBALS['av_core'] . 'admin.' . env('ADMIN_THEME') . '.pages.' . $view;

      return $factory->make($admin_view, $data, $mergeData);
  }
}

if (! function_exists('admin_asset')) {
  /**
   * Generate an asset path for the application.
   *
   * @param  string  $path
   * @param  bool    $secure
   * @return string
   */
  function admin_asset($path, $secure = null)
  {
      $admin_asset = 'themes/' . env('ADMIN_THEME') . '/' . $path;
      return app('url')->asset($admin_asset, $secure);
  }
}

if (! function_exists('admin_theme')) {
  function admin_theme() {
    return $GLOBALS['av_core'] . 'admin.' . env('ADMIN_THEME') . '.';
  }
}

if (! function_exists('superadmin_view')) {
  /**
   * Get the evaluated view contents for the given view.
   *
   * @param  string  $view
   * @param  array   $data
   * @param  array   $mergeData
   * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
   */
  function superadmin_view($view = null, $data = [], $mergeData = [])
  {
      $factory = app(ViewFactory::class);

      if (func_num_args() === 0) {
          return $factory;
      }

      $superadmin_view = $GLOBALS['av_core'] . 'admin.' . env('ADMIN_THEME') . '.pages.superadmin.' . $view;

      return $factory->make($superadmin_view, $data, $mergeData);
  }
}