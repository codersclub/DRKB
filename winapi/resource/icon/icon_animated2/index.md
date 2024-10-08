---
Title: Анимированная иконка приложения
Date: 01.01.2007
---

Анимированная иконка приложения
===============================

Увидев анимацию на форме, мы не удивимся, но сейчас нам предстоит
освоить более сложную технологию: мы попытаемся анимировать иконку
приложения, ту самую, которая находится на панели задач на кнопке нашего
exe-файла!

Сначала нужно будет создать каждый кадр потенциального анимационного
клипа. Для этого запустим утилиту "Image Editor", которая в ходит в
стандартный пакет Delphi. Запустить её можно одноимённой командой из
меню Tools [инструменты]. Там создаём несколько bmp-файлов размером
16х16.

После чего возвращаемся в Delphi и выносим на форму компонент класса
TImageList, дважды щёлкаем на нём и с помощью кнопки Add последовательно
добавляем созданные кадры. В каком порядке изображения будут
добавляться, в таком же порядке они затем будут выводится.

Далее выносим таймер [Timer], его свойство Interval устанавливаем в
нужное значение [например - 5], и именно через заданное здесь
количество миллисекунд будут меняться кадры. По событию OnTimer пишем
такой код:

    ImageList1.GetIcon(iconindex, Application.Icon);
    iconindex := iconindex + 1;
    if iconindex > 5 then
      iconindex := 0;

В строке [if iconindex\>5 then iconindex:=0;] число 5 замените на
индекс последней иконки в вашем ImageList\'e [это количество иконок -1]

Не забудьте объявить глобальную переменную iconindex, которая должна
быть целочисленного типа [integer]

А по созданию окна инициализируйте иконку приложения первым изображением
в списке

    iconindex := 0;
    ImageList1.GetIcon(iconindex, Application.Icon);

Посмотрите на иконку программы ACDSee, которая показана в левом верхнем
углу. На ней изображён глаз. По-моему, было бы довольно эффектно, если
бы время от времени он подмигивал пользователю!
