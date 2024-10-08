---
Title: Взаимодействие с чужими окнами
Date: 01.01.2007
Source: <https://delphiworld.narod.ru>
---

Взаимодействие с чужими окнами
==============================

Представьте себе, глупый пользователь сидит как ни в чём небывало с
умным видом уже в какой раз пытается составить документ в Microsoft
Word\'e, но вдруг окно начинает бешено скакать по экрану, в его
заголовке выводятся непристойные сообщения, оно то сворачивается, то
разворачивается, меняя постоянно свои размеры, а под конец совсем
исчезает, унося в небытиё весь текст, который с таким трудом набил
ламерюга... а если так себя в любой момент может повести любая
программа... впечатления от этого останутся на долго!!!

Для того, чтобы сделать что-нибудь над каким-либо окном нужно сначала
получить его дескриптор, т.е. его положение в оперативной памяти. Для
этого нужно использовать функцию FindWindow. Ей нужно указать всего два
параметра: сначала класс искомого окна, затем его заголовок. Ну с
заголовком проблем вообщем-то нет - его мы видим, но вот как определить
класс... ведь он скрыт от глас пользователя. В действительности мы
может указать только заголовок окна, а вместо класса ставим nil.

Для начала запустите стандартную программу "Блокнот" - и что же мы
видим? В блокноте в заголовке окна отслеживается имя текущего файла.
Изначально, т.к. файла нет в использовании, заголовок блокнота выглядит
так: "Безымянный - Блокнот". Постараемся по этому критерию найти окно
блокнота. Выглядеть это будет так:

    if FindWindow(nil, 'Безымянный - Блокнот') <> 0 then
      ShowMessage('Окно найдено')
    else
      ShowMessage('Окно НЕнайдено');

Как мы видим из кода, если наша программа найдёт окно блокнота, мы
увидим сообщение, гласящее об этом.

Далее попробуем передвинуть это окно

    var
      h: HWND;
    begin
      h := findwindow(nil, 'Безымянный - Блокнот');
      if h <> 0 then
        SetWindowPos(h, HWND_BOTTOM, 1, 1, 20, 20, swp_nosize);
    end;

Опять находим блокнот. Его дескриптор помещаем в переменную класса
HWND[С английского Handle Window - дескриптор окна]. Далее используем
функцию SetWindowPos для задания позиции. В качестве параметров нужно
указать:

- Дескриптор окна, которое хотим переместить

- Идентификатор окна, которое предшествует перемещаемому окну в
Z-последовательности.

    Z-последовательность это порядок, в котором
    формировались окна. Данный параметр указывает с какого именно окна
    необходимо начинать писк. В качестве значений может принимать либо
    дескриптор какого-либо окна в системе, либо одно из нижеследующих
    значений:

    * HWND\_BOTTOM - Начало Z-последовательности
    * HWND\_NOTOPMOST - Первое окно которое располагается не "поверх все окон"
    * HWND\_TOP - Вершина Z-последовательности
    * HWND\_TOPMOST - Первое окно, которое располагается "поверх все окон"

- Позиция окна по горизонтали

- Позиция окна по вертикали

- Ширина окна

- Высота окна
 
- Спецификаторы изменения позиции и размеров окна [флаги].
Для задания значения можно комбинировать следующие константы:

* SWP\_DRAWFRAME - Прорисовка фрейма вокруг окна.
* SWP\_FRAMECHANGED - Посылает сообщение WM\_NCCALCSIZE окну, даже если
размер его не был изменён. Если этот флаг не указан, сообщение
WM\_NCCALCSIZE будет посылаться, только после изменения размеров окна.
* SWP\_HIDEWINDOW - Скрывает окно.
* SWP\_NOACTIVATE - Не активизирует окно. Если же этот флаг не будет
поставлен, окно активизируется и будет перемещено поверх всех окон. А
вот встанет ли окно даже выше тех окон, которым задано HWND\_TOPMOST или
нет зависит от параметра hWndInsertAfter.
* SWP\_NOCOPYBITS - Если этот спецификатор не будет установлен, тогда
содержимое клиентской области окна будет скопировано и вставлено во
вновь отобразившееся окно после его перемещения.
* SWP\_NOMOVE - Сообщает, что нужно игнорировать параметры задания позиции
окну.
* SWP\_NOOWNERZORDER - Сообщает, что не следует изменять позицию окна
владельца в Z-последовательности.
* SWP\_NOREDRAW - Не перерисовывает окно.
* SWP\_NOREPOSITION - Такой же как и SWP\_NOOWNERZORDER.
* SWP\_NOSENDCHANGING - Мешает окну получить сообщение
WM\_WINDOWPOSCHANGING.
* SWP\_NOSIZE - Сообщает, что нужно игнорировать параметры задания размеров окну.
* SWP\_NOZORDER - Сохраняет текущее положение в Z-последовательности
(игнорирует сообщение hWndInsertAfter parameter).
* SWP\_SHOWWINDOW - Отображает окно.

Если данная функция выполнится успешно, она возвратит отличное от нуля
значение.

Ну, вот, теперь мы можем передвигать и изменять в размерах чужие окна!!!

Для того, чтобы изменить заголовок окна напишем следующий код:

    SetWindowText(FindWindow(nil, 'Безымянный - Блокнот'),
        'Дарова, ламерюга, типа ты попал... ');

Функции setwindowtext нужно указать только два параметра: это дескриптор
нужного окна и новое значение для заголовка. Вот вообщем-то и всё!

Есть ещё одна интересная функция ShowWindow, которая позволяет скрывать
или отображать окна. Использовать её нужно так::

    ShowWindow(FindWindow(nil, 'Безымянный - Блокнот'), sw_hide);

В скобках указываем сначала над каким именно окном хотим издеваться, а
затем что именно мы хотим с ним сделать. В качестве возможных действий
можем указать:

- SW\_HIDE - Скрывает окно и активизирует другое.
- SW\_MAXIMIZE - Разворачивает окно.
- SW\_MINIMIZE - Сворачивает окно.
- SW\_RESTORE - Активизирует и выводит окно. Если окно было развёрнуто или
свёрнуто - восстанавливает исходный размер и позицию.
- SW\_SHOW - Активизирует и выводит окно с его оригинальным размером и
положением.
- SW\_SHOWDEFAULT - Активизирует с установками, заданными в структуре
STARTUPINFO, которая была передана при создании процесса приложением
запускающим нужную программу.
- SW\_SHOWMAXIMIZED - Выводит окно в развёрнутом виде.
- SW\_SHOWMINIMIZED - Выводит окно в виде пиктограммы на панели задач.
- SW\_SHOWMINNOACTIVE - Выводит окно в свёрнутом виде на панели задач и не
передаёт ему фокус ввода, т.е. окно, которое до этого было активно
остаётся активно по прежнему.
- SW\_SHOWNA - Отображает окно в его текущем состоянии. Активное окно
остаётся активным по прежнему.
- SW\_SHOWNOACTIVATE - Выводит окно в его последнем положении и с последними
используемыми размерами. Активное окно остаётся активным по прежнему.
- SW\_SHOWNORMAL - Выводит окно. Если оно было свёрнуто или развёрнуто -
восстанавливает его оригинальные размеры и позицию

Но вся сложность действий заключается в том, что в заголовке Блокнота
отслеживается имя текущего файла и использовать значение "Безымянный -
Блокнот" мы можем не всегда : (. Тем более это не только в случае с
блокнотом... Но есть выход: ведь функции FindWindow для поиска окна мы
указываем не только заголовок нужного окна, но ещё его класс. Какой же
это выход скажете вы, заголовок окна мы видим, значит знаем, что
указывать - а класс окна... в действительности тоже может найти
приложив немного усилий!

В пакет Delphi входим специальная утилита для отслеживание всех активных
процессов, она называется WinSight32. Вот ею мы и воспользуемся.

Запустите её, покопайтесь в списке процессов, ищите строку где значится
текущий заголовок нужного окна, например Блокнота, и в левой части этой
строки в фигурных скобках вы найдёте имя класса окна. Для блокнота это
будет "Notepad". Теперь зная имя класса окна мы можем переписать поиск
окна таким способом:

    ShowWindow(FindWindow('Notepad', nil), sw_hide);

Теперь мы вместо заголовка окна указываем значение nil, игнорируя данный
параметр.

Есть ещё один замечательный способ передачи команд окнам - функция
PostMessage. Ей в качестве параметров нужно указать:

- Дескриптор окна, которому посылается сообщение или следующие значения:
- HWND\_BROADCAST - Сообщение будет послано всем окнам верхнего уровня
системы, включая неактивные и невидимые окна, overlapped-окна, и
PopUp-окна, но сообщение не будет посылаться дочерним [Child] окнам.
- NULL - Ведёт себя как функция PostThreadMessage с переданным ей dwThreadId
параметром.
- Посылаемое сообщение
- Первый параметр сообщения
- Второй параметр сообщения

Например, если послать сообщение wm\_quit блокноту - окно будет закрыто
без вывода всяких сообщений о необходимости сохранения!

    PostMessage(FindWindow('Notepad', nil), wm_quit, 0, 0);

