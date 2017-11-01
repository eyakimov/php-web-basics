<?php

class MyController extends Controller {

    public function main() {
        include "view/header.php";
        include "view/main.php";
        switch ($this->input) {
            case 'sales':
                $this->viewSales();
                break;
            case 'customers':
                $this->viewCustomers();
                break;
            case 'cars':
                $this->viewCars();
                break;
            case null:
                break;
            default:
                $input_arr = explode(" ", $this->input);
                //Sample: Audi, A4, 2004, Ivan, Ivanov, BGN 7000
                if (count($input_arr) == 7) {
                    $car = [
                        'make' => $input_arr[0],
                        'model' => str_replace(',', '', $input_arr[1]),
                        'year' => str_replace(',', '', $input_arr[2]),
                    ];
                    $person = [
                        'name' => str_replace(',', '', $input_arr[3]),
                        'family' => str_replace(',', '', $input_arr[4])
                    ];

                    $amount = [
                        'amount' => str_replace(',', '', $input_arr[6])
                    ];
                    $result = $this->addSale($car, $person, $amount);
                    include "view/read_sale.php";
                } elseif ($input_arr[0] == 'Update') {
                    if (str_replace(',', '', $input_arr[1]) == 'customer') {
                        $customer = array('id' => str_replace(',', '', $input_arr[2]),
                            'first_name' => str_replace(',', '', $input_arr[3]),
                            'family_name' => str_replace(',', '', $input_arr[4]));
                        $this->updateCustomer($customer);
                    } elseif (str_replace(',', '', $input_arr[1]) == 'car') {
                        $car = array('id' => str_replace(',', '', $input_arr[2]),
                            'make' => str_replace(',', '', $input_arr[3]),
                            'model' => str_replace(',', '', $input_arr[4]),
                            'year' => str_replace(',', '', $input_arr[5]));
                        $this->updateCar($car);
                    }elseif (str_replace(',', '', $input_arr[1]) == 'sale') {
                        $sale = array('id' => str_replace(',', '', $input_arr[2]),
                            'date_time' => str_replace(',', '', $input_arr[3]),
                            'amount' => str_replace(',', '', $input_arr[4]));
                        $this->updateSale($sale);
                    }
                } elseif (str_replace(',', '', $input_arr[0]) == 'Search') {
                    $this->searchCarOwner(str_replace(',', '', $input_arr[1]));
                } else {
                    include 'view/page_not_found.php';
                }
                break;
        }

        include "view/footer.php";
    }

    // Todo - change main() according to problem

    public function viewSales() {
        $s = new SalesModel($this->db);
        $sales = $s->readAll();
        $sales_total = $s->readTotal();
        include "view/read_sales.php";
    }

    // Todo - problem 1
    public function addSale(array $car, array $person, array $amount) {
        $car = new CarsModel($this->db, $car);
        $car_id = $car->create();
        $customer = new CustomersModel($this->db, $person);
        $customer_id = $customer->create();
        $sale = new SalesModel($this->db, $car_id, $customer_id, $amount['amount']);
        $sale_id = $sale->create();
        return $sale->getSale($sale_id);
    }

    // Todo - problem 2
    public function viewCustomers() {
        $c = new CustomersModel($this->db);
        $customers = $c->readAll();
        include "view/read_customers.php";
    }

    // 
    // Todo - problem 3
    // Implement viewCars()
    public function viewCars() {
        $c = new CarsModel($this->db);
        $cars = $c->readAll();
        include "view/read_cars.php";
    }

    // Todo - Problem 6
    // Implement searchCarOwner()
    public function searchCarOwner(string $car) {
        $car_search = new CarsModel($this->db);
        $cars = $car_search->searchCarOwner($car);
        if ($cars) {
            include 'view/read_cars_owners.php';
        } else {
            include 'view/nothing_found.php';
        }
    }

    public function updateCustomer(array $customer) {
        $c_up = new CustomersModel($this->db);
        $result = $c_up->updateCustomer($customer);
        include "view/update_customer.php";
    }
    public function updateCar(array $car) {
        $c_up = new CarsModel($this->db);
        $result = $c_up->updateCar($car);
        include "view/update_car.php";
    }
     public function updateSale(array $sale) {
        $s_up = new SalesModel($this->db);
        $result = $s_up->updateSale($sale);
        include "view/update_sale.php";
    }
}
