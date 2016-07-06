<?php

namespace App\Http\Controllers;

use Auth;
use App\Http\Requests;
use Illuminate\Http\Request;
use SleepingOwl\Admin\Display\Extension\Tree;
use SleepingOwl\Admin\Http\Controllers\AdminController;
use SleepingOwl\Admin\Navigation\Page;

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
     * Show the application branch.
     *
     * @return \Illuminate\Http\Response
     */
    public function branch()
    {
        return (Auth::check())?$this->renderContent(view('branch')):view('notloggedin');
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
