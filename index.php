//À l'aide du design pattern Observer, mettez en place les événements suivants lorsqu'un nouvel employé est créé.
//
//Un message indiquera "Bienvenue à notre nouvel employé %nom%" afin de prévenir l'ensemble des équipes d'un nouvel arrivant
//
//Un second message à destination des services financiers demandera quant à lui de mettre en place le virement nécessaire au paiement du salaire de cet employé

<?php



class Employee
{
    private $name;

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public function getName()
    {
        return $this->name;
    }
}

class EmployeeManager
{
    private $employee;

    public function create(Employee $employee)
    {
        $this->employee = $employee;

        // code métier qui permettrait ajout de l'employé en BDD

    }

    public function getEmployee()
    {
        return $this->employee;
    }
}

$employeeManager = new EmployeeManager();
$employee = new Employee('Caroline');
$employeeManager->create($employee);