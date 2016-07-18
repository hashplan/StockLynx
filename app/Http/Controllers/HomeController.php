<?php

namespace App\Http\Controllers;

use App\Model\ValuationTree;
use Auth;
use App\Http\Requests;
use Illuminate\Http\Request;
use SleepingOwl\Admin\Display\Extension\Tree;
use SleepingOwl\Admin\Http\Controllers\AdminController;
use SleepingOwl\Admin\Navigation\Page;
use App\Model\RosettaTree;

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
        $chart_config_alternative = [];
        $chart_config_alternative['config'] = 'var config =  {'.
            'container: "#collapsable",'.
            'animateOnInit: true,'.
            //'hideRootNode: true,'.
            'rootOrientation: "WEST",'.
            'levelSeparation: 70,'.
            'siblingSeparation: 60,'.
            'node: {'.
                'collapsable: true'.
            '},'.
            'animation: {'.
                'nodeAnimation: "easeOutBounce",'.
                'nodeSpeed: 700,'.
                'connectorsAnimation: "bounce",'.
                'connectorsSpeed: 700'.
            '}'.
        '}';
        $chart_config_alternative['node_0'] = 'node_0 = {'.
            'text:{'.
                'name:{'.
                    'val:"Valuation Root",'.
                    'href:' . '""' .
                '}'.
            '},'.
            'stackChildren:true,'.
            'HTMLid:'.'node_0'.
        '}';

        foreach(RosettaTree::own()->stock()->get() as $node){
            $chart_config_alternative['node_'.$node->id] = $this->byTreeNode($node);

            foreach(ValuationTree::own()->byNode($node->id)->get() as $leaf){
                $chart_config_alternative['leaf_'.$leaf->id] = $this->byTreeLeaf($leaf);
            }
        }

        $result = implode(", ",array_values($chart_config_alternative)).';   chart_config = ['.implode(", ",array_keys($chart_config_alternative)).'];';
        return (Auth::check())?$this->renderContent(view('tree')->with('chart_config', $result)):view('notloggedin');
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

    private function convertableTree($nestedTree)
    {
        $result = [];
        foreach($nestedTree as $node) {
            $tmp['id'] = $node->id;
            $tmp['parent_id'] = $node->parent_id;
            $tmp['depth'] = $node->depth;
            $tmp['stock_id'] = $node->stock_id;
            $tmp['text']['name']['val'] = $node->name;
            $tmp['text']['name']['href'] = $node->name;
            $tmp['text']['title'] = $node->comment;
            $tmp['status'] = $node->status;
            $result[] = $tmp;
        }
        return $result;
    }

    private function byTreeNode($node)
    {
        return 'node_'.intval($node->id).' = {parent:' . 'node_' . intval($node->parent_id) .','.
            'text:{'.
                'name:{'.
                    'val:"' . $node->name .'",'.
                    'href:' . '"/admin/trees/'.$node->id.'/edit"' .
                '}'.
            '},'.
            'stackChildren:true,'.
            'HTMLid:'.'node_'.intval($node->id).
        '}';
    }

    private function byTreeLeaf($leaf)
    {
        return 'leaf_'.intval($leaf->id).' = {parent:' . 'node_' . intval($leaf->tree_id) .','.
                'text:{'.
                    'name:{'.
                        'val:"' . $leaf->scenario_name .'",'.
                        'href:' . '"/admin/valuation/'.$leaf->id.'/edit"' .
                '}'.
            '},'.
            'stackChildren:true,'.
            'HTMLid:'.'leaf_'.intval($leaf->id).
        '}';
    }
}
