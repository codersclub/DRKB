<h1>Hooks &ndash; аспекты реализации</h1>
<div class="date">01.01.2007</div>


<p class="author">Автор: Aleksey Pavlov</p>

<p>Моя обзорная статья на тему вариантов использования динамически компонуемых библиотек (DLL) вызвала множество вопросов, большая часть которых касалась использования глобальных ловушек (Hook) и размещению разного рода ресурсов в DLL. О ресурсах поговорим в следующий раз, а пока попробуем разобраться с ловушками.</p>
<p>Сразу хочу сделать несколько оговорок: речь в дальнейшем пойдёт только о 32-х разрядной Windows и о глобальных ловушках, т.к. именно при их программировании возникает большинство ошибок; все примеры будут даваться на Delphi, т.к. примеров и описаний для любителей С++ достаточно. </p>

<p>Давайте сначала разберёмся почему, иногда, даже опытные программисты допускают ошибки при написании глобальных ловушек. Первая, и самая распространённая причина: многие программисты, перейдя от 16-ти разрядной к 32-х разрядной Windows, порой забывают об изолированности адресных пространств процессов, такая забывчивость прощается при написании локальных ловушек, в случае с глобальными она может стать фатальной (подробнее об этом рассказано дальше в статье). Второй причиной является то, что в SDK (да и в MSDN тоже) даётся недостаточно информации по данной тематике, а та что есть часто трактуется неверно. Третья причина… хотя, думаю, стоит остановиться пока на этом. </p>

<p>Дальнейшее повествование предполагает, что читатель знаком с основными принципами работы с DLL и хотя бы в общих чертах представляет механизм их написания. </p>
<p>Что же происходит в системе когда мы "ставим" ловушку и что это вообще такое - ловушка ? </p>
<p>Ловушка (hook) - это механизм Windows, позволяющий перехватывать события, предназначенные некоторому приложению, до того как эти события до этого приложения дойдут. </p>

<p>Функции-фильтры - это функции, получающие уведомления о произошедшем событии от ловушки. </p>
<p>В зависимости от типа ловушки функции-фильтры могут изменять события, отменять их или просто реагировать на них. Таким образом, когда мы говорим "установил ловушку" мы подразумеваем процесс прикрепления функции-фильтра к выбранному нами типу ловушки. Итак, когда мы в своей программе используем функцию SetWindowsHookEx мы прикрепляем функцию-фильтр, указатель на которую мы и передаём вторым параметром, пример: </p>

<p>SetWindowsHookEx(WH_SHELL, @ShellHook, HInstance, 0); </p>

<p>в данном случае ShellHook - это и есть функция-фильтр. В дальнейшем, под словосочетанием "установили ловушку" будем понимать присоединение функции-фильтра к ловушке. </p>

<p>Что же происходит после того, как мы установили глобальную ловушку ? Понимание следующего параграфа является ключом для понимания механизма работы ловушек Windows, располагающихся в DLL. Если вы не поймёте его, вернитесь и перечитайте заново и так до тех пор, пока всё не станет ясным. </p>

<p>Наш Process1 устанавливает глобальную ловушку из DLL находящейся в адресном пространстве (АП) нашего процесса (Process1). DLL, находящаяся в АП процесса1 имеет свои данные, обозначенные на рисунке как Dll data. Когда система посылает событие, на которое мы установили ловушку, в Process2, то в Process2 отображается код DLL, находящийся в первом процессе (Dll code), НО НЕ ДАННЫЕ ! Все данные, только что отображённой в Process2 DLL, инициализируются заново (т.е. равны 0, nil, False в зависимости от типа). То есть, Process2 знать не знает о существовании Process1, и всё что в нём находится никак не относится к АП первого процесса, из которого произошло отображение кода DLL. В библиотеки, находящиеся не в АП вашего процесса, можно посылать только процессо-независимые данные, такие как, к примеру, дескрипторы окон (под термином "посылка" в данном случае подразумевается использование функций PostMessage() и SendMessage()). (О смысле красных овалов на рисунке поговорим позже, сейчас не стоит обращать на них внимания). </p>

<p>Если выше прочитанное вам понятно, то продолжим наш разговор и рассмотрим, что происходит, когда мы устанавливаем вторую ловушку такого же типа, что и первая. При установке в системе двух одинаковых ловушек Windows выстраивает их в цепочку. Когда система посылает сообщение, на которое мы установили ловушки, то первой срабатывает последняя ловушка в цепочке, т.е. hook n (см. рисунок). </p>


<p>О том, что бы сообщение дошло до n-1 ловушки (hook n-1) должен позаботится сам программист. Вот на этом-то этапе очень часто возникают ошибки. </p>
<p>Для вызова следующей ловушки в цепочке ловушек в Windows используется функция CallNextHookEx, первым параметром которой является дескриптор текущей ловушки, получаемый функцией SetWindowsHookEx. Теперь внимание: мы установили ловушку в Process1, т.е. функция SetWindowsHookEx выполнялась в DLL, находящейся в АП Process1 (см. рис.1) и, соответственно, дескриптор установленной ловушки возвращаемый функцией SetWindowsHookEx принадлежит данным DLL, находящимся в АП Process1. Пусть в Process2 возникает событие на которое поставлена ловушка, тогда Dll из первого процесса проецируется на АП Process2, а данные DLL в Process2 инициализируются заново, и получается, что в Process2 в переменной, в которой "лежал" дескриптор поставленной ловушки в Process1, будет равен 0. Функция-фильтр Process2, отработав, должна будет передать сообщение дальше по цепочке ловушек, т.е. выполнить функцию CallNextHookEx, первым параметром которой должен быть дескриптор текущей ловушки, но в данных DLL, находящейся в Process2 нет этого дескриптора (переменная, которая должна содержать его содержит ноль). "Как же быть в таком случае ? Как же нам узнать дескриптор ловушки, поставленной в другом процессе, если сами процессы ничего не знают друг о друге ?" - спросите вы. На этот вопрос я отвечу чуть позже, а пока давайте поверхностно пробежимся по типам ловушек, хотя информация о типах полностью приведена в SDK. </p>
<p>Как мы уже знаем, ловушка устанавливается с помощью Win32 API функции </p>

<p>SetWindowsHookEx(): </p>
<p>function SetWindowsHookEx(idHook: integer; lpfn: TFNHookProc; hmod: HINST; dwThreadID: DWORD): HHOOK; stdcall; </p>

<p>idHook: описывает тип устанавливаемой ловушки. Данный параметр может принимать одно из следующих значений: </p>
    <table border="1">
<TBODY>
      <tr>
        <td><p align="center"><b>Константа</b></td>
        <td><p align="center"><b>Описание</b></td>
      </tr>
      <tr>
        <td>WH_CALLWNDPROC</td>
        <td>Фильтр процедуры окна. Функция-фильтр ловушки
        вызывается, когда процедуре окна посылается
        сообщение. Windows вызывает этот хук при каждом
        вызове функции SendMessage.</td>
      </tr>
      <tr>
        <td>WH_CALLWNDPROCRET</td>
        <td>Функция-фильтр, контролирующая сообщения
        после их обработки процедурой окна приемника.</td>
      </tr>
      <tr>
        <td>WH_CBT</td>
        <td>В литературе встречаются следующие названия
        для этого типа фильтров: &quot;тренировочный&quot; или
        &quot;обучающий&quot;. Данная ловушка вызывается
        перед обработкой большинства сообщений окон,
        мыши и клавиатуры.</td>
      </tr>
      <tr>
        <td>WH_DEBUG</td>
        <td>Функция-фильтр, предназначенная для отладки.
        Функция-фильтр ловушки вызывается перед любой
        другой ловушкой Windows. Удобный инструмент для
        отладки и контроля ловушек.</td>
      </tr>
      <tr>
        <td>WH_GETMESSAGE</td>
        <td>Функция-фильтр обработки сообщений.
        Функция-фильтр ловушки вызывается всегда, когда
        из очереди приложения считывается любое
        сообщение.</td>
      </tr>
      <tr>
        <td>WH_HARDWARE</td>
        <td>Функция-фильтр, обрабатывающая сообщения
        оборудования. Функция-фильтр ловушки вызывается,
        когда из очереди приложения считывается
        сообщение оборудования.</td>
      </tr>
      <tr>
        <td>WH_JOURNALPLAYBACK</td>
        <td>Функция-фильтр вызывается, когда из очереди
        системы считывается любое сообщение.
        Используется для вставки в очередь системных
        событий.</td>
      </tr>
      <tr>
        <td>WH_JOURNALRECORD</td>
        <td>Функция-фильтр вызывается, когда из очереди
        системы запрашивается какое-либо событие.
        Используется для регистрации системных событий.</td>
      </tr>
      <tr>
        <td>WH_KEYBOARD</td>
        <td>Функция-фильтр &quot;обработки&quot; клавиатуры.
        Наверное, наиболее часто используемый тип
        ловушки. Функция-фильтр ловушки вызывается,
        когда из очереди приложения считывается
        сообщения wm_KeyDown или wm_KeyUp.</td>
      </tr>
      <tr>
        <td>WH_KEYBOARD_LL</td>
        <td>Низкоуровневый фильтр клавиатуры.</td>
      </tr>
      <tr>
        <td>WH_MOUSE</td>
        <td>Функция-фильтр, обрабатывающая сообщения мыши.
        Функция-фильтр ловушки вызывается, когда из
        очереди приложения считывается сообщение мыши.</td>
      </tr>
      <tr>
        <td>WH_MOUSE_LL</td>
        <td>Низкоуровневый фильтр мыши.</td>
      </tr>
      <tr>
        <td>WH_MSGFILTER</td>
        <td>Функция-фильтр специального сообщения.
        Функция-фильтр ловушки вызывается, когда
        сообщение должно быть обработано диалоговым
        окном приложения, меню или окном приложения. </td>
      </tr>
      <tr>
        <td>WH_SHELL</td>
        <td>Фильтр приложения оболочки. Функция-фильтр
        ловушки вызывается, когда создаются и
        разрушаются окна верхнего уровня или когда
        приложению-оболочке требуется стать активным.</td>
      </tr>
</TBODY>
    </table>

<p>Что бы упредить шквал писем в мой адрес, скажу сразу, что каждый, из вышеперечисленных, типов имеет свои особенности, о которых каждый может прочитать в SDK, MSDN или же найти их описание в Internet-e. </p>
<p>lpfn : это адрес функции-фильтра, которая является функцией обратного вызова. Функция-фильтр имеет тип TFNHookProc, определение которого выглядит следующим образом:</p>
<p>TFNHookProc = function (code: Integer; wparam: WPARAM; lparam: LPARAM): LRESULT stdcall; </p>
<p>Значение каждого из параметров функции-фильтра ловушки изменяется в зависимости от типа устанавливаемой ловушки. За более подробными разъяснениями значений параметров обращайтесь к справке по Win32 API. </p>
<p>hmod: данный параметр должен иметь значение hInstance в EXE или DLL-файлах, в которых содержится функция-фильтр ловушки (напомню, что это функция обратного вызова). Если речь идёт о глобальных ловушках, то данный параметр может принимать только дескриптор DLL, из которой устанавливается ловушка. Причина очевидна - EXE-файл не может быть отображён на АП другого процесса, тогда как DLL-фалы специально созданы для этого. Подчеркну это обстоятельство ещё раз: глобальные ловушки могут располагаться только в DLL, но никак не в EXE файлах ! </p>
<p>dwThreadID: данный параметр идентифицирует поток, с которым будет связана ловушка. Мы ведём речь о глобальных ловушках, поэтому данный параметр будет всегда равен 0, что означает, что ловушка будет связана со всеми потоками в системе. </p>
<p>Возвращаемое значение: функция SetWindowsHookEx возвращает дескриптор установленной ловушки, именно этот дескриптор нам и надо будет сделать доступным ВСЕМ экземплярам отображаемой DLL. Как это сделать я расскажу после небольшого примера, показывающего на практике необходимость сохранять дескриптор ловушки для того, что бы суметь вызвать предыдущую ловушку в цепочке. </p>
<p>Замечание: при установке двух ловушек разного типа, система создаст две цепочки ловушек. Т.е. каждому типу ловушки соответствует своя цепочка. Так при установке ловушки типа WH_MOUSE и WH_KEYBOARD обе эти ловушки будут находиться в разных цепочках и, соответственно, будут обрабатываться независимо друг от друга. </p>
<p>Для удаления функции-фильтра из очереди необходимо вызвать функцию UnhookWindowsHookEx. Данная функция принимает дескриптор ловушки, полученный функцией SetWindowsHookEx. Если удаление не удалось, то функция возвращает ноль, иначе не нулевое значение. В дальнейшем, под выражением "снять ловушку" будем подразумевать удаление функции-фильтра. </p>
<p>Теперь, когда вам известно как устанавливать ловушку и как её снимать, рассмотрим пару примеров, которые дадут наглядное представление об изолированности АП процессов и укажут на одну из самых распространённых ошибок. </p>
<p>Откройте каталог Example1, из прилагаемого к статье файла, далее зайдите в каталоги First и Second и скомпилируйте все имеющиеся в этих каталогах проекты. В итоге вы должны получить в одном каталоге файлы MainProg1.exe и hook_dll1.dll, и во втором - MainProg2.exe и hook_dll2.dll (не забудьте, что *.DLL файлы могут быть не видны, из-за того, что у вас в свойствах обозревателя выбран пункт "Не показывать скрытые и системные файлы" ) . Запустите MainProg1.exe и MainProg2.exe, расположите появившиеся окошки рядом. Теперь в окне MainProg1 нажмите "Load DLL and set hook", как только вы нажмёте на эту кнопку, ловушка типа WH_GETMESSAGE установится и теперь, когда какой либо процесс будет считывать сообщение из очереди, в этот процесс будет отображена hook_dll1.dll и выполнена функция-фильтр. При отображении в процесс этой DLL будет выводиться сообщение с именем модуля, из которого был загружен процесс, отобразивший эту DLL в своё АП. Если ловушка установлена успешно, - будет выведено соответствующее сообщение. Проделайте те же действия со второй формой (Example1/Process2). Теперь, после успешной установки двух ловушек, попробуйте кликнуть правой кнопкой мыши на какой-либо форме (но не на форме MainProg2). Вы увидите сообщение "HOOK2 working !", что означает что сработала вторая ловушка, которую мы установили последней и которая находится в конце очереди, но, несмотря на то, что в коде функции-фильтра второй ловушки мы пытались передать сообщение следующей ловушке (установленной нами из MainProg1) CallNextHookEx(SysHook, Code, wParam, lParam); первая ловушка не выполняется, потому что в процессе, которому принадлежит форма, на которой вы произвели клик, переменная SysHook будет равна нулю. Надеюсь, это понятно, если нет, - начинайте читать заново ;) Теперь попробуйте так же кликнуть правой кнопкой мыши на форму Example1/Process2 и вы увидите сначала сообщение "HOOK2 working !", а затем "HOOK1 working !". Почему ? - спросите вы. А потому, что в АП Process2 (в данных DLL) лежит дескриптор установленной из этого процесса ловушки и функция CallNextHookEx(SysHook, Code, wParam, lParam); работает как надо (SysHook не равна нулю, мы её сохранили в глобальных данных DLL - см. исходный код). Далее, попробуйте снять вторую ловушку (удалить функцию-фильтр из очереди) нажав на кнопку "TurnOff the hook". После того, как ловушка будет снята, попробуйте снова где-либо нажать правую кнопку мыши. При этом вы увидите, что ловушка, поставленная из первого приложения работает (будет появляться сообщение "HOOK1 working !"). Естественно, если вы, не сняв ловушку, закроете приложение, из которого она была установлена, ловушка будет уничтожена, а DLL выгружена, если более ни одним приложением не используется. ( Хотя, строго говоря, это не совсем так. Дело в том, что Windows использует механизм кэширования DLL в оперативной памяти. Делается это для того, что бы уменьшить накладные расходы на загрузку DLL с жёсткого диска в случае, если к этой DLL часто обращаются различные приложения, т.е. отображают эту DLL на своё АП. Более подробно об этом механизме можно почитать в специализированной литературе, для нас же, как для программистов, данное свойство ОС остаётся, как правило, прозрачным). </p>
<p>Думаю, теперь, разобравшись в исходных кодах библиотек из первого примера, вы поняли, как НЕ надо писать DLL, из которых вы устанавливаете глобальные ловушки. Представьте, что пользователь, использующий вашу программу, в которой задействованы глобальные ловушки, запустит другую программу, которая так же установит тот же вид ловушки, что и ваша, но установит её в конец очереди, в таком случае, если та, вторая программа, будет написана неправильно - ваша программа перестанет работать потому что вашей ловушке не будет передаваться сообщение из впереди стоящей. Это пример того, как некачественная работа одного программиста может испортить прекрасно выполненную работу другого. </p>
<p>Замечание: если вы работаете на Windows 2000, то вышеописанный пример будет работать иначе. Дело в том, что в Windows 2000 изменён механизм вызова ловушки, стоящей в очереди. Программисты Microsoft довели-таки его до ума, и в новой ОС он стал, по моему личному мнению, более логичен. В Windows 2000 если у вас имеется цепочка ловушек, то при выполнении функции CallNextHookEx(0, nCode, wParam, lParam ) вызывается следующая ловушка в цепочке, т.е. отпадает необходимость в передачи дескриптора, возвращаемого функцией SetWindowsHookEx. Таким образом, в первом примере будут вызываться обе ловушки и при клике на правую кнопку мыши вы увидите сообщение "HOOK2 working !", а затем и "HOOK1 working !". Рассмотрев и опробовав пример 2, вы увидите, что в Windows 2000 оба примера работают одинаково, хотя второй пример гораздо более сложен в плане реализации. Так как мы стремимся к тому, что бы наши программы были устойчивы в работе под любой версией Windows (имеются ввиду 32-х разрядные и выше), то в связи с этим я бы рекомендовал в ваших программах использовать метод, описанный далее в статье, а ещё лучше - делать проверку на ОС, под которой была запущена ваша программа и соответствующим образом работать с ловушками. К сожалению у меня нет описания, содержащего декларацию "новой" функции CallNextHookEx(), нововведение было обнаружено мной в результате тестирования своих программ на Windows 2000, поэтому возможны какие-то нюансы при работе с этой функцией. Лично я, работая с ловушками в среде Windows 2000, на другие изменения не натыкался, если кто-то располагает какой-либо интересной информацией по данному вопросу - буду признателен, если со мной ею поделятся. </p>
<p>Теперь поговорим о том, как избежать неприятных ситуаций, используя глобальные ловушки. </p>
<p>Для того, что бы все экземпляры DLL, находящиеся в разных процессах, имели доступ к дескриптору ловушки, надо выделить какую-то область, доступ к которой будут иметь все "желающие". Для этого воспользуемся одним из мощнейших механизмов Windows под названием "Файлы, отображённые в память" (Memory Mapped Files). В цели данной статьи не входит углубление в подробности работы с данным механизмом, так что если он кого-то заинтересует всерьёз - рекомендую почитать о нём в литературе, общие же понятия я постараюсь вкратце осветить. Механизм файлов, отображённых в память (MMF - Memory Mapped Files) позволяет резервировать определённую область АП системы Windows, для которой назначаются страницы физической памяти. Таким образом, с помощью MMF можно отображать в память не только файлы, но и данные, ссылаясь на них из своих программ с помощью указателей. В первом приближении работу механизма MMF можно представить следующим образом: Process1 создаёт отображение, которое связывает с некими данными (будь то файл на диске или значение неких переменных в самом Process1) и может изменять отображённые данные; затем Process2 так же отображает некие свои данные в тоже отображение, что и Process1, таким образом, изменения, внесённые Process1 в отображённые данные, будут видны Process2 и наоборот (см. рис.1 - красный овал c именем Global Data и есть зарезервированное под совместные нужды двух процессов АП). Данное приближение, вообще говоря, грубое, потому что всё намного сложнее, но для наших "нужд" этого будет вполне достаточно. Мы не будем создавать никаких временных файлов для передачи информации между процессами, мы воспользуемся файлом подкачки Windows (файл страничного обмена), таким образом, нам не придётся ни создавать ни уничтожать файлы, а придётся просто создать некоторое АП, которое будет доступно нашим приложениям и которое будет автоматически освобождаться системой, когда в нём отпадёт необходимость. К тому же, ясно, что работа с файлом подкачки куда быстрее, чем с обычным файлом, хранящимся на диске. Таким образом, к рассмотренному вами ранее Example1 можно применить следующий сценарий: при загрузки вашей программой (MainProg1.exe) библиотеки hook_dll1.dll эта библиотека создаёт отображённый в память файл, в котором сохраняет значение дескриптора установленной ловушки; затем некий процесс, в котором произошло событие, на которое была установлена ловушка, отображает на своё АП код hook_dll1.dll и уже новый экземпляр hook_dll1.dll, находящийся в АП другого процесса использует то же отображение, что и библиотека, из который была установлена ловушка, т.е. будет иметь доступ к сохранённому значению дескриптора установленной ловушки. Таким образом, вызов функции CallNextHookEx(Hook_Handle, Code, wParam, lParam); будет происходить вполне корректно, т.к. значение Hook_Handle будет содержать не 0, как в примере1, а значение, возвращённое функцией SetWindowsHookEx из первого экземпляра DLL. Возможно, данные объяснения кажутся вам запутанными, но после просмотра примера и повторного прочтения этих объяснений всё встанет на свои места. </p>
<p>Теперь пару слов о программной реализации всего вышесказанного</p>

<p>CreateFileMapping - Создаёт объект файлового отображения. Данная функция возвращает указатель (handle) на объект файлового отображения.</p>

<p>MapViewOfFile - Данная функция отображает образ объекта файлового отображения на АП процесса, из которого она была вызвана. Первым параметром данной функции является результат выполнения функции CreateFileMapping(). Результатом работы данной функции является указатель на начало выделенного АП (уже в том процессе, из которого была вызвана данная функция). См. рис.1. - красные овалы в Process1 и Process2 под названием GD1 и GD2 (Global Data 1/2). Следует отметить, что для различных процессов, использующих экземпляры одной и той же DLL, адреса выделенных областей будут различными (хотя могут и совпадать, но это совпадение носит вероятностный характер), хотя данные, на которые они будут ссылаться, одни и те же !</p>

<p>UnmapViewOfFile - Данная функция закрывает отображённый в память файл и освобождает его дескриптор. При удачном закрытие функция возвращает ненулевое значение и 0 в случае неудачи.</p>

<p>За подробной информацией о параметрах вышеописанных функций обращайтесь к SDK, а так же разберитесь в примере, который будет разобран ниже. </p>
<p>Замечание: первым параметром функции CreateFileMapping() должен быть передан дескриптор файла, которого мы собираемся отобразить. Т.к. мы собираемся отображать данные в файл подкачки, то следует передавать значение $FFFFFFFF или DWORD(-1), что соответствует тому же значению; но т.к. грядёт эра 64-разрядных систем, стоит использовать значение INVALID_HANDLE_VALUE, которое будет в 64 разрядной системе равно $FFFFFFFFFFFFFFFF соответственно. Для тех, кто переходил с ранних версий Delphi на более поздние (к примеру с Delphi2 на Delphi4) те, возможно, сталкивались с такого рода проблемами в своих программах. </p>
<p>Так как мы будем создавать именованный объект файлового отображения, то последним параметром функции CreateFileMapping() передадим имя объекта, которое впоследствии будут использовать другие процессы для ссылки на ту же область памяти. Следует упомянуть о том, что создаваемый таким образом объект должен иметь фиксированный размер, т.е. не может его изменять по ходу программы. </p>
<p>Теперь мы владеем всеми необходимыми знаниями для рассмотрения второго примера. Откройте каталог Example2 и выполните те же действия, что и в первом примере, предварительно внимательно разобравшись в исходных кодах. После того как вы запустите оба приложения и установите из них две функции-фильтра одного типа, попробуйте кликнуть правой кнопкой мыши на любом из окон и вы увидите, что теперь отрабатывают обе установленные ловушки, независимо от того, на каком из окон произошло нажатие кнопки мыши (т.е. несмотря на то, из какого экземпляра DLL выполняется вызов функции CallNextHookEx() ). Таким образом, когда какое-либо приложение будет отображать на своё АП DLL, в которой находится функция-фильтр, этот экземпляр DLL будет иметь доступ к данным, отображённым в память из Process1 или Process2, в зависимости от DLL. Думаю, после столь подробных объяснений всё должно быть понятно. </p>
<p>В завершении напишем программу, которая будет устанавливать ловушку типа WH_KEYBOARD и записывать в файл значения нажатых клавиш во всех приложениях (программа будет накапливать в буфере значения нажатых клавиш и как только их количество превысит 40 - все значения будут выведены в соответствующее окно формы). Попутно, в данном примере, новички могут найти ответы на многие вопросы, часто задаваемые в различных форумах. Все объяснения будут даваться в виде комментариев к исходному коду. Откройте каталог Example3, в нём вы найдёте исходные коды библиотеки и главной программы, - разберитесь с ними, а затем откомпилируйте и сами попробуйте программу в действии. </p>
<p>Благодарю Юрия Зотова за оказанную поддержку. </p>

<p>Список использованной литературы:</p>
Microsoft Win32 Software Development Kit. </p>
Стив Тейксейра и Ксавье Пачеко, "Delphi5. Руководство разработчика. Том 1. Основные методы и технологии". </p>
Kyle Marsh, "Hooks in Win32" (in the original). </p>
Dr. Joseph M. Newcomer, "Hooks and DLLs" (in the original). </p>
Moscow Power Engineering Institute (Technical University)</p>
Faculty of Nuclear Power Plants</p>
27.02.02 </p>
<p>© Written by Aleksey Pavlov. All rights reserved. 2002 ©</p>

<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>

