---
Title: Для чего нужен WinAPI
Date: 01.01.2007
---


Для чего нужен WinAPI
=====================

Иногда требуется работать с объектами WINDOWS не используя VCL. Где это
может пригодиться?

Например:

- При отсутствии у приложения окна - консольный проект.

- Если нужно работать быстро, а известно, что функции WinApi работают на
порядок быстрее, чем стандартные классы Delphi.

- Работа с устройствами ввода - вывода. Многие вещи в Дельфи можно делать
через только через дескриптор, например чтение сообщений из MailSlot,
работа с процессами и thread и т.д.

**Что это такое?**

WINAPI - это набор фунций WINDOWS предоставляемый нам через стандартные
библиотеки (kernel32.dll gdi.exe и т.д.). Раз эти библиотеки
распространяются вместе с WINDOWS, следовательно их можно использовать
на любых машинах (с этой платформой).

Хотя, следует оговориться, что та или иная библиотека может иметь
различную версию. Но нам програмистам на Delphi по большей части это не
важно.

**Использование**

Для использования нужно в разделе uses добавить модуль windows. Внем то
и описано большинство функций.

Создадим проект.

На форме разместим кнопку и поле ввода TEdit.

В обработчике события кнопки onClick запишем следующий код:

    procedure Tform1.Button1onClick(Sender: TTobject);
    var
      h: cardinal;
    begin
      h := FindWindow(Edit1.Text, nil);
      ShowWindow(h,
        SW_MINIMIZE);
    end;

Теперь откомпилируйте и запустите его. В поле ввода введите заголовок
любого окна которое открыто у вас на рабочем столе (например
"(Без имени) - Блокнот"). Нажмите кнопку и окно минимизируется.

Этот простой проект демонстрирует принцип работы с дескрипторами. Сначало
его нужно получить у функции FindWindow, которая ищет окно по заголовку
и возвращает его дескриптор. А потом следует передать его функции
ShowWindow котрая с параметром SW\_MINIMIZE минимизирует окно.

Краткий обзор завершен. Из всего вышеперечисленного следует, что WINAPI
это не монстр, а обычная техника работы с фунциями, правда несколько
специфическая.

Успешной работы.
