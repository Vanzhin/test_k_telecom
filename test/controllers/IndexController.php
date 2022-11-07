<?php

namespace app\controllers;

use app\models\entities\Equipment;
use app\models\repositories\EquipmentRepository;
use app\models\repositories\TypeRepository;
use app\service\RegexpService;

class indexController extends Controller
{
    public function actionIndex(): void
    {
        $equipmentType = $_POST['equipmentType'] ?? null;
        $serialNumber = $_POST['serialNumber'] ?? null;
        $typeRepository = new TypeRepository();
        $equipmentRepository = new EquipmentRepository();
        $types = $typeRepository->getAll();

        if ($equipmentType && $serialNumber) {
            $id = array_search($equipmentType, array_column($types, 'id'));
            $mask = $types[$id]['mask'];
            $exp = ((new RegexpService())->match($serialNumber, $mask));
            if ($exp && !$equipmentRepository->getOneWhere('serial', $serialNumber)) {
                $equipment = new Equipment(intval($equipmentType), $serialNumber);

                $equipmentRepository->save($equipment);

                $message = "Запись добавлена.";
            } else {
                $message = 'Не верный формат записи серийного номера или запись с таким серийным номером уже существует. Пожалуйста, проверьте данные.';
            }

        } else {
            $message = 'Необходимо заполнить все поля';
        }

        echo $this->render("index", ['types' => $types, 'message' => $message]);

    }

}