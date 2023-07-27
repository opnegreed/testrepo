<?php
    class Person
        {
            private $id;
            private $firstName;
            private $lastName;
            private $dateOfBirth;
            private $gender;
            private $birthCity;

        public function __construct($id, $firstName = '', $lastName = '', $dateOfBirth = '', $gender = '', $birthCity = '')
            {
            $this->id = $id;
            $this->firstName = $firstName;
            $this->lastName = $lastName;
            $this->dateOfBirth = $dateOfBirth;
            $this->gender = $gender;
            $this->birthCity = $birthCity;

            if ($id) {
            $this->validateData();
                } else {
            $this->saveToDB();
                }
            }

        public function saveToDB()
            {
        // Сохранение полей экземпляра класса в БД
            $db = new mysqli('localhost', 'root', '', 'database');

            $firstName = $db->real_escape_string($this->firstName);
            $lastName = $db->real_escape_string($this->lastName);
            $dateOfBirth = $db->real_escape_string($this->dateOfBirth);
            $gender = $db->real_escape_string($this->gender);
            $birthCity = $db->real_escape_string($this->birthCity);

            $query = "INSERT INTO people (first_name, last_name, date_of_birth, gender, birth_city)
            VALUES ('$firstName', '$lastName', '$dateOfBirth', '$gender', '$birthCity')";

            $db->query($query);
            $db->close();
            }

        public function deleteFromDB()
            {
        // Удаление человека из БД в соответствии с id объекта
            $db = new mysqli('localhost', 'root', '', 'database');

            $query = "DELETE FROM people WHERE id = '$this->id' LIMIT 1";

            $db->query($query);
            $db->close();
            }

        public static function calculateAge($dateOfBirth)
            {
            // Преобразование даты рождения в возраст (полных лет)
            $today = new DateTime();
            $birthDate = new DateTime($dateOfBirth);
            $age = $today->diff($birthDate)->y;

            return $age;
            }

        public static function genderText($gender)
            {
            // Преобразование пола из двоичной системы в текстовую (муж, жен)
            if ($gender == 0) {
            return 'муж';
                } elseif ($gender == 1) {
            return 'жен';
                }

            return '';
            }

        public function formatPerson($includeAge = true, $includeGender = true)
            {
        // Форматирование человека с преобразованием возраста и (или) пола
        // Возвращает новый экземпляр stdClass со всеми полями изначального класса

            $person = new stdClass();
            $person->id = $this->id;
            $person->firstName = $this->firstName;
            $person->lastName = $this->lastName;
            $person->dateOfBirth = $this->dateOfBirth;
            $person->gender = $this->gender;
            $person->birthCity = $this->birthCity;

            if ($includeAge)   {
            $person->age = self::calculateAge($this->dateOfBirth);
                }

            if ($includeGender) {
            $person->genderText = self::genderText($this->gender);
                }

        return $person;
            }

        private function validateData()
            {
            // Валидация данных
            // Допустим, что здесь должна быть проверка на правильность данных
            }
        }

// Пример использования класса
$person = new Person(1, 'John', 'Doe', '1990-01-01', 0, 'New York');
$person->saveToDB();

$person2 = new Person(2);
$person2->deleteFromDB();

$person3 = new Person(3, 'Jane', 'Smith', '1985-05-10');
$formattedPerson = $person3->formatPerson();
print_r($formattedPerson);