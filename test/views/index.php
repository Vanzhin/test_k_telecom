<div id="main">
    <div class="container">
        <div class="alert alert-warning" role="alert">
            <?= $message ?? null ?>
        </div>
        <h1>Пожалуйста, введите значение</h1>
        <form method="post" action="/">
            <label for="equipmentType" class="form-label">Тип оборудования</label>
            <select name="equipmentType" id="equipmentType" class="form-select" aria-label="Default select example">
                <?php foreach($types as $type):?>
                    <option value="<?=$type['id']?>"><?=$type['title'] . " Маска: {$type['mask']}"?></option>
                <?php endforeach; ?>
            </select>
            <div class="mb-3">
                <label for="exampleFormControlTextarea1" class="form-label">Серийный номер</label>
                <textarea name="serialNumber" class="form-control" id="exampleFormControlTextarea1" rows="3" required ></textarea>
            </div>
            <button class="btn btn-success" type="submit">Добавить</button>
        </form>
        <div>
            <h3>Маска</h3>
            <ul class="list-group list-group-flush">
                <li class="list-group-item">N – цифра от 0 до 9,</li>
                <li class="list-group-item">A – прописная буква латинского алфавита,</li>
                <li class="list-group-item">a – строчная буква латинского алфавита,</li>
                <li class="list-group-item">X – прописная буква латинского алфавита либо цифра от 0 до 9,</li>
                <li class="list-group-item">Z – символ из списка: “-“, “_”, “@”.</li>
            </ul>
        </div>

    </div>
</div>

