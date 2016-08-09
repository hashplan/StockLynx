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
     * create array() with the application tree.
     *
     * @return array()
     */
    static function generateNodeStructure($tree) {

        $res = [];

        foreach($tree as $node) {

            $c = [];
            $childrens = [];

            if(!empty($node['children'])) {
                $childrens = self::generateNodeStructure($node['children']);
            }

            foreach(ValuationTree::own()->byNode($node['id'])->get()->toArray() as $valuation) {
                //$comment_valuation = explode(PHP_EOL, $valuation['scenario_comment']);
                $comment_valuation = explode(' ', trim($valuation['scenario_comment']));
                $c[] = [
//                    'text'=> [
//                        'name'=> $valuation['scenario_name']
//                    ],
                    'innerHTML' => '<nobr>'.$valuation['scenario_name'].'</nobr><br/>'.
                        '<span class="badge">$ '.$valuation['value_per_share_raw'].'</span><br/>'.
                        '<span class="badge">100%</span><br/><nobr>'.trim(str_replace("\r", '', $comment_valuation[0])).'...</nobr>',
                    'node' => [
                        'HTMLclass' => 'big-bubble-child'
                    ],
                ];
            }

            $childrens = array_merge($c, $childrens);

            $comment_node = explode(PHP_EOL, $node['comment']);

            $res[] = [
//                'text'=> [
//                    'name'=> $node['name']
//                ],
                'innerHTML' => '<nobr>'.$node['name'].'</nobr><br/>'.trim(str_replace("\r", '', $comment_node[0])).'...',
                'connectors' => [
                    'style' => [
                        'stroke' => '#000',
                        'arrow-end' => 'block-wide-long',
                        'arrow-start' => 'oval-wide-long',
                    ],
                ],
                'node' => [
                    'HTMLclass' => 'big-bubble'
                ],
                'children' => $childrens
            ];

        }

        return $res;
    }

    /**
     * Show the application charts.
     *
     * @return \Illuminate\Http\Response
     */
    public function charts()
    {
        $result = [];

        foreach(ValuationTree::own()->byNode(\Request::get('stock_id'))->get()->toArray() as $valuation) {
            $result[] = $valuation;
        }

        return (Auth::check())?$this->renderContent(view('charts')->with('chart_config', json_encode($result))):view('notloggedin');
    }

    /**
     * Show the application tree.
     *
     * @return \Illuminate\Http\Response
     */
    public function tree()
    {
        $res = (\Request::get('node_id'))?[RosettaTree::own()->stock()->get()->toHierarchy()->toArray()[\Request::get('node_id')]]:RosettaTree::own()->stock()->get()->toHierarchy()->toArray();

        $R = [
                'chart' => [
                    'container' => '#collapsable',
                    'rootOrientation' => 'WEST',
                    'animateOnInit' => true,
                    'hideRootNode' => true,
//                    'connectors' => [
//                        'type'=>'step',
//                        'style'=> [
//                            'stroke-width'=>2
//                        ]
//                    ],
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
                    'children' => self::generateNodeStructure($res)
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

    /**
     * Show the application charts.
     *
     * @return \Illuminate\Http\Response
     */
    public function scenario()
    {
        return (Auth::check())?$this->renderContent(view('branch')):view('notloggedin');
    }

}
