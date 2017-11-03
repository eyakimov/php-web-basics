<?php

class EmployeeController extends Controller {

    public function main() {
        header("Location:?controller=EmployeeController&action=view");
    }

    public function view() {
        $m = new EmployeesModel($this->db);
        $result = $m->readAll();
        $this->loadView("header.php");
        $this->loadView("employee/view_all.php", $result);
        $this->loadView("footer.php");
    }

    public function addProjects() {
        $get= $this->inputGet($_GET);
        $post= $this->inputPost($_POST);
        
        $action = "?controller=EmployeeController&action=addProjects";
        $action .= (!empty($get['employee_id'])) ? '&employee_id=' . $get['employee_id'] : '';
        if (isset($get['emplyee_id']) and isset($post['save'])) {
            $m = new ProjectsModel($this->db);
            $res = $m->create($post);
            $this->loadView("header.php");
            $this->loadView("employee/save_project.php", ['res' => $res]);
            $this->loadView("footer.php");
        }
        if (isset($post['cancel'])) {
            header("Location:?controller=EmployeeController&action=view");
        }
        $this->loadView("header.php");
        $this->loadView("employee/add_project.php", ['action' => $action]);
        $this->loadView("footer.php");
    }

    public function viewProjects() {
        $get= $this->inputGet($_GET);
        $action = "?controller=EmployeeController&action=viewProjects";
        $action .= (!empty($get['employee_id'])) ? '&emplyee_id=' . $get['employee_id'] : '';
        if (isset($get['employee_id'])) {
            $m = new ProjectsModel($this->db);
            $res = $m->read($get['employee_id']);
            $this->loadView("header.php");
            $this->loadView("employee/view_projects.php", $res);
            $this->loadView("footer.php");
        }
    }
    public function viewAddresses() {
        $get= $this->inputGet($_GET);
        $action = "?controller=EmployeeController&action=viewAddresses";
        $action .= (!empty($get['employee_id'])) ? '&emplyee_id=' . $get['employee_id'] : '';
        if (isset($get['employee_id'])) {
            $m = new AddressesModel($this->db);
            $res = $m->read($get['employee_id']);
            $this->loadView("header.php");
            $this->loadView("employee/view_addresses.php", $res);
            $this->loadView("footer.php");
        }
    }

}
