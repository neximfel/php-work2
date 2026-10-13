<?php
const PASS_SCORE = 60;
const COURSE_NAME = "PHP с нуля";

$students = [
    ["name" => "Иван Петров",   "group" => "A", "scores" => [85, 92, 78, 90],  "age" => "19", "paid" => true],
    ["name" => "Мария Лебедева","group" => "B", "scores" => [55, 48, 62, 51],  "age" => "20", "paid" => true],
    ["name" => "Олег Смирнов",  "group" => "A", "scores" => [70, 65, 80, 72],  "age" => "21", "paid" => false],
    ["name" => "Анна Козлова",  "group" => "B", "scores" => [98, 95, 100, 97], "age" => "19", "paid" => true],
    ["name" => "Пётр Волков",   "group" => "A", "scores" => [40, 35, 58, 45],  "age" => "22", "paid" => false],
    ["name" => "Дарья Морозова","group" => "C", "scores" => [88, 76, 91, 84],  "age" => "20", "paid" => true],
    ["name" => "Сергей Орлов",  "group" => "C", "scores" => [],                "age" => "18", "paid" => true],
];

                                                                                // часть 1

echo "Часть 1. Типы и приведение <br><br>";

var_dump($students[0]["age"]);
echo "<br>";

foreach ($students as &$student){
    $student["age"] = (int)$student["age"];
}
unset($student);

var_dump($students[0]["age"]);
echo "<br>";

var_dump("19" == 19); 
echo "<br>";
// два равно сравнивают только значения, 19 приводится к числу поэтому тру
var_dump("19" === 19);
// три равно сранивавают еще и типы, они разные, поэтому фолз
echo "<br><br>";

                                                                                // часть 2

echo "Часть 2. Средний балл <br><br>";

foreach ($students as &$student){
    $sum = 0;
    foreach ($student["scores"] as $score){
        $sum += $score;
    }
    if (count($student["scores"]) > 0){
        $student["avg"] = round($sum / count($student["scores"]), 1);
        echo $student["name"] . ": " . $student["avg"] . "<br>";
    } else {
        $student["avg"] = 0;
        echo $student["name"] . ": нет оценок <br>";
    }
}
unset($student);

echo "<br>";

                                                                                // часть 3

echo "Часть 3. Оценка и статус <br><br>";

foreach ($students as &$student){
    // лу: 90+ → "A", 75+ → "B", 60+ → "C", ниже → "F".
    $student["grade"] = match(true){
        $student["avg"] >= 90 => "A",
        $student["avg"] >= 75 => "B",
        $student["avg"] >= 60 => "C",
        default => "F",
    };

    $student["status"] = $student["avg"] >= PASS_SCORE ? "сдал" : "не сдал";
// A → "Утренняя", B → "Дневная", C → "Вечерняя", всё остальное → "Неизвестная".
    switch ($student["group"]) {
        case "A":
            $student["groupName"] = "утренняя";
            break;
        case "B":
            $student["groupName"] = "дневная";
            break;
        case "C":
            $student["groupName"] = "вечерняя";
            break;
        default:
            $student["groupName"] = "неизвестная";
    }
}
unset($student);

echo "Имя | Группа | Средний балл | Оценка | Статус <br>";
foreach ($students as $student){
    if (count($student["scores"]) == 0){
        $avgText = "нет оценок";
    } else {
        $avgText = $student["avg"];
    }
    echo $student["name"] . " | " . $student["groupName"] . " | " . $avgText . " | " . $student["grade"] . " | " . $student["status"] . "<br>";
}
echo "<br>";

                                                                                // часть 4

echo "Часть 4. Циклы и управление потоком <br><br>";

for ($i = 0; $i < count($students); $i++){
    echo ($i + 1) . ". " . $students[$i]["name"] . "<br>";
}

echo "<br> оплатили курс:<br>";
foreach ($students as $student){
    if ($student["paid"] !== true){
        continue;
    }
    echo $student["name"] . "<br>";
}

echo "<br>";
$i = 0;
$firstFailed = null;
while ($i < count($students)){
    if ($students[$i]["avg"] < PASS_SCORE){
        $firstFailed = $students[$i];
        break;
    }
    $i++;
}
if ($firstFailed !== null){
    echo "первый не сдавший: " . $firstFailed["name"] . "<br>";
} else {
    echo "все сдали <br>";
}

echo "<br> обратный отсчёт:<br>";
$n = count($students);
do {
    echo $n . "<br>";
    $n--;
} while ($n >= 1);

echo "<br>";

                                                                                // часть 5



                                                                                // часть 6

echo "Часть 6. Группировка и аналитика <br><br>";

$byGroup = [];
foreach ($students as $student){
    $byGroup[$student["groupName"]][] = $student;
}

$bestGroup = "";
$bestGroupAvg = -1;

foreach ($byGroup as $groupName => $groupStudents){
    $sum = 0;
    $count = 0;
    foreach ($groupStudents as $s) {
        if (count($s["scores"]) > 0) {
            $sum += $s["avg"];
            $count++;
        }
    }

    if ($count > 0) {
        $groupAvg = round($sum / $count, 1);
    } else {
        $groupAvg = 0;
    }

    echo $groupName . ": студентов " . count($groupStudents) . ", средний балл " . $groupAvg . "<br>";

    if ($groupAvg > $bestGroupAvg) {
        $bestGroupAvg = $groupAvg;
        $bestGroup = $groupName;
    }
}

echo "лучшая группа: " . $bestGroup . " (" . $bestGroupAvg . ") <br>";

if (isset($byGroup["D"])){
    echo "группа D есть <br>";
} else {
    echo "группы D нет <br>";
}

echo "<br>";

                                                                                // чатсь 7
 
echo "Часть 7. Итоговый отчёт <br><br>";

$total = count($students);
$passedCount = 0;
$failedCount = 0;
$dolzniki = 0;
$bestStudent = $students[0];
$toImprove = [];
 
foreach ($students as $student){
    if ($student["avg"] >= PASS_SCORE){
        $passedCount++;
    } else {
        $failedCount++;
        if ($student["paid"] === true){
            $toImprove[] = $student["name"];
        }
    }
 
    if ($student["paid"] === false){
        $dolzniki++;
    }
 
    if ($student["avg"] > $bestStudent["avg"]){
        $bestStudent = $student;
    }
}
 
$percent = round($passedCount / $total * 100, 1);
 
echo "отчет по курсу «" . COURSE_NAME . "»<br>";
echo "всего студентов: " . $total . "<br>";
echo "сдали: " . $passedCount . "<br>";
echo "не сдали: " . $failedCount . "<br>";
echo "процент сдавших: " . $percent . "%<br>";
echo "лучший студент: " . $bestStudent["name"] . " (" . $bestStudent["avg"] . ")<br>";
echo "должников по оплате: " . $dolzniki . "<br>";
echo "нужно подтянуть оценки: " . implode(", ", $toImprove) . "<br>";
 
$verdict = match(true){
    $percent >= 70 => "курс успешен",
    $percent >= 40 => "курс требует доработки",
    default => "курс провален",
};
echo "Вердикт: " . $verdict . "<br>";