<?php

//À l'aide du design pattern Observer, mettez en place les événements suivants lorsqu'un nouvel employé est créé.
//
//Un message indiquera "Bienvenue à notre nouvel employé %nom%" afin de prévenir l'ensemble des équipes d'un nouvel arrivant
//
//Un second message à destination des services financiers demandera quant à lui de mettre en place le virement nécessaire au paiement du salaire de cet employé

class Employee
{
    private string $name;

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public function getName(): string
    {
        return $this->name;
    }
}

class EmployeeManager implements SplSubject
{
    private SplObjectStorage $observers;

    private $employee;

    public function __construct()
    {
        $this->observers = new SplObjectStorage();
    }

    #[ReturnTypeWillChange] public function attach(SplObserver $observer)
    {
        $this->observers->attach($observer);
    }

    #[ReturnTypeWillChange] public function detach(SplObserver $observer)
    {
        $this->observers->detach($observer);
    }

    #[ReturnTypeWillChange] public function notify()
    {
        foreach ($this->observers as $observer) {
            $observer->update($this);
        }
    }

    public function create(Employee $employee)
    {
        $this->employee = $employee;

        // code métier qui permettrait l'ajout de l'employé en BDD

        // on notifie les listeners
        $this->notify();
    }

    public function getEmployee()
    {
        return $this->employee;
    }
}

class SayWelcome implements SplObserver
{
    #[ReturnTypeWillChange] public function update(SplSubject $employeeManager)
    {
        echo 'Bienvenue à notre nouvel employé ' . $employeeManager->getEmployee()->getName() . ' <br/>';
    }
}

class AlertFinancialServices implements SplObserver
{
    #[ReturnTypeWillChange] public function update(SplSubject $employeeManager)
    {
        echo 'Un nouvel employé est arrivé dans l\'entreprise, merci de mettre en place le virement pour ' . $employeeManager->getEmployee()->getName() . ' <br/>';
    }
}

$sayWelcome = new SayWelcome();
$alertFinancielServices = new AlertFinancialServices();
$employeeManager = new EmployeeManager();
$employeeManager->attach($sayWelcome);
$employeeManager->attach($alertFinancielServices);

$employee = new Employee('Caroline');
$employeeManager->create($employee);