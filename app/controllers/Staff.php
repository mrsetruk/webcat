<?php
/**
 * Created by PhpStorm.
 * User: Galbanie
 * Date: 2018-03-18
 * Time: 12:23
 */

namespace App\Controllers;


use Core\Controller;
use Core\View;

class Staff extends Controller
{
    private $sections = [
        'index' => [
            'view' => 'staff/index.html',
            'href' => 'staff/index',
            'name' => 'Overview'
        ],
        'clients' => [
            'view' => 'staff/client.html',
            'href' => 'staff/clients',
            'name' => 'Clients'
        ],
        'catalog' => [
            'view' => 'staff/catalog.html',
            'href' => 'staff/catalogs',
            'name' => 'Catalog'
        ],
        'plannings' => [
            'view' => 'staff/planning.html',
            'href' => 'staff/planning',
            'name' => 'Planning (Maintenance)'
        ],
        'scripts' => [
            'view' => 'staff/script.html',
            'href' => 'staff/script',
            'name' => 'Script (Maintenance)'
        ],
        'reports' => [
            'view' => 'staff/report.html',
            'href' => 'staff/report',
            'name' => 'Reports'
        ],
        'notifications' => [
            'view' => 'staff/notification.html',
            'href' => 'staff/notifications',
            'name' => 'Notifications (Communication)'
        ],
        'messages' => [
            'view' => 'staff/message.html',
            'href' => 'staff/messages',
            'name' => 'Messages (Communication)'
        ],
        'archives' => [
            'view' => 'staff/archive.html',
            'href' => 'staff/archive',
            'name' => 'Archives'
        ],
        'links' => [
            'view' => 'staff/link.html',
            'href' => 'staff/links',
            'name' => 'Links'
        ]
    ];

    private function getStaffLogged(){
        $staff = false;
        if($this->session->get('staff_id')){
            $staff = \App\Models\Staff::findOne([
                'id' => $this->session->get('staff_id')
            ]);
            if($staff) return $staff;
            else return false;
        }
        return false;
    }

    function dashboard($section = 'index'){
        $staff = $this->getStaffLogged();
        if(!$staff){
            header('location: /staff/login');
            exit();
        }

        if(!array_key_exists($section,$this->sections)){
            header('HTTP/1.1 404 Not Found');
            View::renderTemplate("404.html");
            exit();
        }

        $this->scope->css = [
            'class' => [
                'body' => 'fixed-nav sticky-footer bg-dark'
            ],
            'id' => [
                'body' => 'page-top'
            ]
        ];

        $this->scope->staff = $staff;

        $this->scope->section = $this->sections[$section];

        $this->scope->page = [
            'title' => 'Dashboard (' . $staff->username . ')'
        ];

        View::renderTemplate($this->sections[$section]['view'],array(
            'scope' => $this->scope
        ));
    }

    function login(){
        if($this->getStaffLogged()){
            header('location: /staff');
            exit();
        }
        if(isset($this->request->getBodyParameters()['email']) and isset($this->request->getBodyParameters()['password'])){
            $staff = \App\Models\Staff::findOne([
                'email' => $this->request->getBodyParameter('email')
            ]);

            if($staff and ($staff->password === $this->request->getBodyParameter('password'))){
                $this->session->set('staff_id',$staff->id);
                header('location: /staff');
                exit();
            }
        }

        $this->scope->css = [
            'class' => [
                'body' => 'bg-dark'
            ]
        ];

        $this->scope->page = [
            'title' => 'Staff Login'
        ];

        View::renderTemplate('staff/login.html', array(
            'scope' => $this->scope
        ));

    }

}