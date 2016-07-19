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
    static function generateNodeStructure($tree) {
        $res = [];$c = [];
        foreach($tree as $node) {
            $childrens = [];
            if(!empty($node['children'])) {
                $childrens = self::generateNodeStructure($node['children']);
            }
            foreach(ValuationTree::own()->byNode($node['id'])->get()->toArray() as $valuation) {
                $c[] = [
                    'text'=> [
                        'name'=> $valuation['scenario_name']
                    ]
                ];
            }

            $childrens = array_merge($c, $childrens);

            $res[] = [
                'text'=> [
                    'name'=> $node['name']
                ],
                'children' => $childrens
            ];

        }
        return $res;
    }
    public function tree()
    {
        $R = [
                'chart' => [
                    'container' => '#collapsable',
                    'rootOrientation' => 'WEST',
                    'animateOnInit' => true,
                    'hideRootNode' => true,
                    'connectors' => [
                        'type'=>'step',
                        'step'=> [
                            'stroke-width'=>2
                        ]
                    ],
                    'node' => [
                        'collapsable' => true
                    ],
                    'animation' => [
                        'nodeAnimation' => "easeOutBounce",
                        'nodeSpeed' => 700,
                        'connectorsAnimation' => "bounce",
                        'connectorsSpeed' => 700
                    ],
                ],

                'nodeStructure' => [
                    'children' => self::generateNodeStructure(RosettaTree::own()->stock()->get()->toHierarchy()->toArray())
                ]
        ];
        $result = 'var chart_config = '.json_encode($R).';';
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

}
