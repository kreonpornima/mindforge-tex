<?php

interface IRow {
    public function __construct($name, $gender, $age, $address, $city, $country);
}

class Row implements IRow {
    public $name;
    public $gender;
    public $age;
    public $address;
    public $city;
    public $country;

    public function __construct($name, $gender, $age, $address, $city, $country) {
        $this->name = $name;
        $this->gender = $gender;
        $this->age = $age;
        $this->address = $address;
        $this->city = $city;
        $this->country = $country;
    }
}

function getData() {
    return [
        new Row('Bob Harrison', 'Male', null, '1197 Thunder Wagon Common, Cataract, RI, 02987-1016, US, (401) 747-0763', 'Dublin', 'Ireland'),
        new Row('Mary Wilson', 'Female', 11, '3685 Rocky Glade, Showtucket, NU, X1E-9I0, CA, (867) 371-4215', 'New York', 'USA'),
        new Row('Zahid Khan', 'Male', 12, '3235 High Forest, Glen Campbell, MS, 39035-6845, US, (601) 638-8186', 'Dublin', 'Ireland'),
        new Row('Jerry Mane', 'Male', 12, '2234 Sleepy Pony Mall , Drain, DC, 20078-4243, US, (202) 948-3634', 'Dublin', 'Ireland'),
        new Row('Bob Harrison', 'Male', null, '1197 Thunder Wagon Common, Cataract, RI, 02987-1016, US, (401) 747-0763', 'Dublin', 'Ireland'),
        new Row('Mary Wilson', 'Female', 11, '3685 Rocky Glade, Showtucket, NU, X1E-9I0, CA, (867) 371-4215', 'Dublin', 'Ireland'),
        new Row('Zahid Khan', 'Male', 12, '3235 High Forest, Glen Campbell, MS, 39035-6845, US, (601) 638-8186', 'Dublin', 'Ireland'),
        new Row('Jerry Mane', 'Male', 12, '2234 Sleepy Pony Mall , Drain, DC, 20078-4243, US, (202) 948-3634', 'Dublin', 'Ireland'),
    ];
}

// Set the content type for the response to be JSON
header('Content-Type: application/json');

// Convert the data to an associative array and return it as JSON
$data = getData();
$response = [];

// Convert objects to arrays for JSON encoding
foreach ($data as $row) {
    $response[] = [
        'name' => $row->name,
        'gender' => $row->gender,
        'age' => $row->age ?? 'N/A',
        'address' => $row->address,
        'city' => $row->city,
        'country' => $row->country
    ];
}

// Output the data as JSON
echo json_encode($response);
?>
