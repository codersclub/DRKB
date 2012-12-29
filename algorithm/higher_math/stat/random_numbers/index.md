---
Title: Поговорим о случайных числах в Delphi
Date: 01.01.2007
---


Поговорим о случайных числах в Delphi
=====================================

::: {.date}
01.01.2007
:::

Поговорим о случайных числах в Delphi

В этой статье я постараюсь рассказать Вам, что такое генератор случайных
чисел, как им пользоваться и как всегда рассмотрим примеры использования
случайных чисел в Delphi.

Процедура Randomize

Эта процедура инициализирует (проще говоря запускает) генератор
случайных чисел. Надо также заметить, что генератор случайных чисел
может быть инициализирован не только с помощью обращения к Randomize, но
и с помощью присвоения переменной RandSeed (об этом поговорим ниже).

Без инициирования генератора случайных чисел обращения к соответствующим
функциям выбора случайного числа всегда будут давать один и тот же
результат.

Получение случайного числа

Для того, чтобы получить случайное число нужно воспользоваться функцией
Random. Вот ее заголовок:

function Random \[ ( Range: Integer) \];

Если обращаться к функции без параметров, то она вернет значение типа
Real в диапазоне:

0 \<= X \< 1

А если в качестве параметра указано целое число k, то функция вернет
целочисленное значение в диапазоне:

0 \<= X \< k,

или, для наглядности, можно записать так:

0 \<= X \<= k-1

Важно что реализация функции Random может меняться в зависимости от
версии компилятора, поэтому не рекомендуется использовать эту функцию,
например, в шифровании.

Пример использования функции Random.

Вы легко можете собрать небольшой тир, используя таймер и картинку
Image, ну и конечно же генератор случайных чисел.

Поставим на форму таймер Timer1 и картинку Image1 (не забудьте загрузить
в нее изображение) и напишем обработчик события OnTimer

    procedure TForm1.Timer1Timer(Sender: TObject);
    begin
    Randomize; //запускаем генератор случайных чисел
    Image1.left:=Random(Form1.width);
    Image1.top:=Random(Form1.height);
    end; 

Мы просто каждый раз меняем случайным образом координаты изображения,
которое начинает двигаться по форме беспорядочно. Хотя здесь было бы
логичнее Randomize вызвать один раз при загрузке формы.

Теперь сделаем реакцию на попадание в картинку. Естественно это событие
OnClick для картинки:

    procedure TForm1.Image1Click(Sender: TObject); 
    begin 
    Timer1.Enabled:=false; //остановим таймер 
    Showmessage('Попадание в цель!'); 
    Timer1.Enabled:=true; //запустим его обратно 
    end; 

Здесь можно было бы вести учет очков, уменьшение линии жизни картинки и
еще какие-нибудь игровые финты. Увеличить скорость игры можно просто
уменьшив свойство Interval таймера

Вот и готова простая игра.

Заполним массив с помощью Random

    Randomize;
    //заполним массив
    for i:= 1 to 10 do a[i]:=Random(10);
     
    //Выведем массив на канву формы
    for i:= 1 to 10 do Canvas.TextOut(10+10*i,10,IntToStr(a[i])); 

Массив в любом случае будет содержать неотрицательные элементы, чтобы
заполнить массив еще и неотрицательными элементами надо написать так:

    for i:= 1 to 10 do a[i]:=Random(20)-10; 

Таким образом диапазон значений массива будет (-10 .. 9)

Получение случайного числа с помощью RandSeed

Запустить генератор случайных можно получить и без вызова процедуры
Randomize. Это делается с помощью переменной RandSeed. Вот пример,
демонстрирующий это:

    procedure TForm1.Button1Click(Sender: TObject);
    var RandSeed: LongInt;
    begin
    RandSeed:=random(10);
    ShowMessage(IntToStr(RandSeed));
    end; 

Вот мы и поговорили о случайных числах в Delphi. Надеюсь, что каждый
почерпнет хоть маленько нового для себя в этой статье.

Источник: <https://delphid.dax.ru>

 