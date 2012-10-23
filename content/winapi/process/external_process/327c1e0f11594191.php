<h1>Взаимодействие с чужими окнами</h1>
<div class="date">01.01.2007</div>


<p>Представьте себе, глупый пользователь сидит как ни в чём небывало с умным видом уже в какой раз пытается составить документ в Microsoft Word'e, но вдруг окно начинает бешено скакать по экрану, в его заголовке выводятся непристойные сообщения, оно то сворачивается, то разворачивается, меняя постоянно свои размеры, а под конец совсем исчезает, унося в небытиё весь текст, который с таким трудом набил ламерюга... а если так себя в любой момент может повести любая программа... впечатления от этого останутся на долго!!!</p>

<p>Для того, чтобы сделать что-нибудь над каким-либо окном нужно сначала получить его дескриптор, т.е. его положение в оперативной памяти. Для этого нужно использовать функцию FindWindow. Ей нужно указать всего два параметра: сначала класс искомого окна, затем его заголовок. Ну с заголовком проблем вообщем-то нет - его мы видим, но вот как определить класс... ведь он скрыт от глас пользователя. В действительности мы может указать только заголовок окна, а вместо класса ставим nil.</p>

<p>Для начала запустите стандартную программу "Блокнот" - и что же мы видим? В блокноте в заголовке окна отслеживается имя текущего файла. Изначально, т.к. файла нет в использовании, заголовок блокнота выглядит так: "Безымянный - Блокнот". Постараемся по этому критерию найти окно блокнота. Выглядеть это будет так:</p>

<pre>
if FindWindow(nil, 'Безымянный - Блокнот') &lt;&gt; 0 then
  ShowMessage('Окно найдено')
else
  ShowMessage('Окно НЕнайдено');
</pre>

<p>Как мы видим из кода, если наша программа найдёт окно блокнота, мы увидим сообщение, гласящее об этом.</p>
<p>Далее попробуем передвинуть это окно</p>

<pre>
var
  h: HWND;
begin
  h := findwindow(nil, 'Безымянный - Блокнот');
  if h &lt;&gt; 0 then
    SetWindowPos(h, HWND_BOTTOM, 1, 1, 20, 20, swp_nosize);
end;
</pre>

<p>Опять находим блокнот. Его дескриптор помещаем в переменную класса HWND[С английского Handle Window - дескриптор окна]. Далее используем функцию SetWindowPos для задания позиции. В качестве параметров нужно указать:</p>

<p>Дескриптор окна, которое хотим переместить</p>
<p>Идентификатор окна, которое предшествует перемещаемому окну в Z-последовательности. Z-последовательность это порядок, в котором формировались окна. Данный параметр указывает с какого именно окна необходимо начинать писк. В качестве значений может принимать либо дескриптор какого-либо окна в системе, либо одно из нижеследующих значений:</p>
<p>HWND_BOTTOM Начало Z-последовательности</p>
<p>HWND_NOTOPMOST Первое окно которое располагается не "поверх все окон"</p>
<p>HWND_TOP Вершина Z-последовательности</p>
<p>HWND_TOPMOST Первое окно которое располагается "поверх все окон"</p>
<p>Позиция окна по горизонтали</p>
<p>Позиция окна по вертикали</p>
<p>Ширина окна</p>
<p>Высота окна</p>
<p>Спецификаторы изменения позиции и размеров окна[флаги]. Для задания значения можно комбинировать следующие константы</p>
<p>SWP_DRAWFRAME Прорисовка фрейма вокруг окна.</p>
<p>SWP_FRAMECHANGED Посылает сообщение WM_NCCALCSIZE окну, даже если размер его не был изменён. Если этот флаг не указан, сообщение WM_NCCALCSIZE будет посылаться, только после изменения размеров окна.</p>
<p>SWP_HIDEWINDOW Скрывает окно.</p>
<p>SWP_NOACTIVATE Не активизирует окно. Если же этот флаг не будет поставлен, окно активизируется и будет перемещено поверх всех окон. А вот встанет ли окно даже выше тех окон, которым задано HWND_TOPMOST или нет зависит от параметра hWndInsertAfter.</p>
<p>SWP_NOCOPYBITS Если этот спецификатор не будет установлен, тогда содержимое клиентской области окна будет скопировано и вставлено во вновь отобразившееся окно после его перемещения.</p>
<p>SWP_NOMOVE Сообщает, что нужно игнорировать параметры задания позиции окну.</p>
<p>SWP_NOOWNERZORDER Сообщает, что не следует изменять позицию окна владельца в Z-последовательности.</p>
<p>SWP_NOREDRAW Не перерисовывает окно.</p>
<p>SWP_NOREPOSITION Такой же как и SWP_NOOWNERZORDER.</p>
<p>SWP_NOSENDCHANGING Мешает окну получить сообщение WM_WINDOWPOSCHANGING.</p>
<p>SWP_NOSIZE Сообщает, что нужно игнорировать параметры задания размеров окну.</p>
<p>SWP_NOZORDER Сохраняет текущее положение в Z-последовательности (игнорирует сообщение hWndInsertAfter parameter).</p>
<p>SWP_SHOWWINDOW Отображает окно.</p>
<p>Если данная функция выполнится успешно, она возвратит отличное от нуля значение. Ну, вот, теперь мы можем передвигать и изменять в размерах чужие окна!!! Для того, чтобы изменить заголовок окна напишем следующий код:</p>

<pre>
SetWindowText(FindWindow(nil, 'Безымянный - Блокнот'),
'Дарова, ламерюга, типа ты попал... ');
</pre>

<p>Функции setwindowtext нужно указать только два параметра: это дескриптор нужного окна и новое значение для заголовка. Вот вообщем-то и всё!</p>

<p>Есть ещё одна интересная функция ShowWindow, которая позволяет скрывать или отображать окна. Использовать её нужно так::</p>

<pre>
ShowWindow(FindWindow(nil, 'Безымянный - Блокнот'), sw_hide);
</pre>

<p>В скобках указываем сначала над каким именно окном хотим издеваться, а затем что именно мы хотим с ним сделать. В качестве возможных действий можем указать:</p>

<p>SW_HIDE Скрывает окно и активизирует другое.</p>
<p>SW_MAXIMIZE Разворачивает окно.</p>
<p>SW_MINIMIZE Сворачивает окно.</p>
<p>SW_RESTORE Активизирует и выводит окно. Если окно было развёрнуто или свёрнуто - восстанавливает исходный размер и позицию.</p>
<p>SW_SHOW Активизирует и выводит окно с его оригинальным размером и положением.</p>
<p>SW_SHOWDEFAULT Активизирует с установками, заданными в структуре STARTUPINFO, которая была передана при создании процесса приложением запускающим нужную программу.</p>
<p>SW_SHOWMAXIMIZED Выводит окно в развёрнутом виде.</p>
<p>SW_SHOWMINIMIZED Выводит окно в виде пиктограммы на панели задач.</p>
<p>SW_SHOWMINNOACTIVE Выводит окно в свёрнутом виде на панели задач и не передаёт ему фокус ввода, т.е. окно, которое до этого было активно остаётся активно по прежнему.</p>
<p>SW_SHOWNA Отображает окно в его текущем состоянии. Активное окно остаётся активным по прежнему.</p>
<p>SW_SHOWNOACTIVATE Выводит окно в его последнем положении и с последними используемыми размерами. Активное окно остаётся активным по прежнему.</p>
<p>SW_SHOWNORMAL Выводит окно. Если оно было свёрнуто или развёрнуто - восстанавливает его оригинальные размеры и позицию</p>
<p>Но вся сложность действий заключается в том, что в заголовке Блокнота отслеживается имя текущего файла и использовать значение "Безымянный - Блокнот" мы можем не всегда : (. Тем более это не только в случае с блокнотом... Но есть выход: ведь функции FindWindow для поиска окна мы указываем не только заголовок нужного окна, но ещё его класс. Какой же это выход скажете вы, заголовок окна мы видим, значит знаем, что указывать - а класс окна... в действительности тоже может найти приложив немного усилий!</p>

<p>В пакет Delphi входим специальная утилита для отслеживание всех активных процессов, она называется WinSight32. Вот ею мы и воспользуемся. Запустите её, покопайтесь в списке процессов, ищите строку где значится текущий заголовок нужного окна, например Блокнота, и в левой части этой строки в фигурных скобках вы найдёте имя класса окна. Для блокнота это будет "Notepad". Теперь зная имя класса окна мы можем переписать поиск окна таким способом:</p>

<pre>
ShowWindow(FindWindow('Notepad', nil), sw_hide);
</pre>

<p>Теперь мы вместо заголовка окна указываем значение nil, игнорируя данный параметр.</p>

<p>Есть ещё один замечательный способ передачи команд окнам.- функция PostMessage. Ей в качестве параметров нужно указать:</p>

<p>Дескриптор окна, которому посылается сообщение или следующие значения:</p>
<p>HWND_BROADCAST Сообщение будет послано всем окнам верхнего уровня системы, включая неактивные и невидимые окна, overlapped-окна, и PopUp-окна, но сообщение не будет посылаться дочерним[Child] окнам.</p>
<p>NULL Ведёт себя как функция PostThreadMessage с переданным ей dwThreadId параметром.</p>
<p>Посылаемое сообщение</p>
<p>Первый параметр сообщения</p>
<p>Второй параметр сообщения</p>
<p>Например, если послать сообщение wm_quit блокноту - окно будет закрыто без вывода всяких сообщений о необходимости сохранения!</p>

<pre>
PostMessage(FindWindow('Notepad', nil), wm_quit, 0, 0);
</pre>

<p>Взято с <a href="https://delphiworld.narod.ru" target="_blank">https://delphiworld.narod.ru</a></p>
