<?php

namespace App\Http\Controllers;

use Auth;
use App\Http\Requests;
use Illuminate\Http\Request;
use SleepingOwl\Admin\Http\Controllers\AdminController;

class HomeController extends AdminController
{
    /**
     * Show the application home.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        return (Auth::check())?view('home'):view('notloggedin');
    }

    /**
     * Show the application tree.
     *
     * @return \Illuminate\Http\Response
     */
    public function tree()
    {
        return (Auth::check())?$this->renderContent(view('tree')):view('notloggedin');
    }

    /**
     * Show the application brunch.
     *
     * @return \Illuminate\Http\Response
     */
    public function brunch()
    {
        return (Auth::check())?$this->renderContent(view('brunch')):view('notloggedin');
    }
    /**
     * Show the application scenario.
     *
     * @return \Illuminate\Http\Response
     */
    public function scenario()
    {
        return (Auth::check())?$this->renderContent(view('scenario')):view('notloggedin');
    }
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function dashboard()
    {
        return (Auth::check())?((Auth::user()->isManager()||Auth::user()->isSuperAdmin())?$this->renderContent(view('dashboard')):$this->renderContent(view('workspace'))):view('notloggedin');
    }
}
