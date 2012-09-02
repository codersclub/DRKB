<h1>Какие есть директивы компилятора?</h1>
<div class="date">01.01.2007</div>


<p><span style="color: teal;">{$I+}</span> и <span style="color: teal;">{$I-}</span> - директивы контроля ввода/вывода</p>
<p><span style="color: teal;">{$M}</span> и <span style="color: teal;">{$S}</span> - директивы, определяющие размер стека</p>
<p><span style="color: teal;">{$M+}</span> и <span style="color: teal;">{$M-}</span> - директивы информации времени выполнения о типах </p>
<p><span style="color: teal;">{$Q+}</span> и <span style="color: teal;">{$Q-}</span> - директивы проверки переполнения целочисленных операций</p>
<p><span style="color: teal;">{$R}</span> - директива связывания ресурсов </p>
<p><span style="color: teal;">{$R+}</span> и <span style="color: teal;">{$R-}</span> - директивы проверки диапазона</p>
<p><span style="color: teal;">{$APPTYPE CONSOLE}</span> - директива создания консольного приложения</p>
<p>1) Директивы компилятора, разрешающие или запрещающие проверку утверждений.</p>
<p>По умолчанию <span style="color: teal;">{$C+}</span> или <span style="color: teal;">{$ASSERTIONS ON}</span></p>
<p>Область действия локальная</p>
<p>Директивы компилятора $C разрешают или запрещают проверку утверждений. Они влияют на работу процедуры Assert,используемой при отладке программ. По умолчанию действует</p>
<p>директива <span style="color: teal;">{$C+}</span> и процедура Assert генерирует исключение EAssertionFailed, если проверяемое утверждение ложно.</p>
<p>Так как эти проверки используются только в процессе отладки программы, то перед ее окончательной компиляцией следует указать директиву <span style="color: teal;">{$C-}</span>. При этом работа процедур Assert будет блокировано и генерация исключений EassertionFailed производиться не будет.</p>
<p>Директивы действуют на весь файл исходного кода независимо от того, в каком месте файла они расположены.</p>
<p>2) Директивы компилятора, включающие и выключающие контроль файлового ввода-вывода.</p>
<p>По умолчанию <span style="color: teal;">{$I+}</span> или <span style="color: teal;">{$IOCHECKS ON}</span></p>
<p>Область действия локальная</p>
<p>Директивы компилятора $I включают или выключают автоматический контроль результата вызова процедур ввода-вывода Object Pascal. Если действует директива <span style="color: teal;">{$I+}</span>, то при возвращении процедурой ввода-вывода ненулевого значения генерируется исключение EInOutError и в его свойство errorcode заносится код ошибки. Таким образом, при действующей директиве <span style="color: teal;">{$I+}</span> операции ввода-вывода располагаются в блоке try...except, имеющем обработчик исключения EInOutError. Если такого блока нет, то обработка производится методом TApplication.HandleException. </p>
<p>Если действует директива <span style="color: teal;">{$I-}</span>, то исключение не генерируется. В этом случае проверить, была ли ошибка, или ее не было, можно, обратившись к функции IOResult. Эта функция очищает ошибку и возвращает ее код, который затем можно анализировать.&nbsp; Типичное применение директивы <span style="color: teal;">{$I-}</span> и функции IOResult демонстрирует следующий пример:</p>
<pre>
{$I-}
 
AssignFile(F,s);
Rewrite(F);
 
{$I+}
i:=IOResult;
if i&lt;&gt;0 then 
  case i of
    2: ..........
    3: ..........
  end;
</pre>
<p>В этом примере на время открытия файла отключается проверка ошибок ввода вывода, затем она опять включается, переменной i присваивается значение, возвращаемое функцией IOResult и, если это значение не равно нулю (есть ошибка), то предпринимаются какие-то действия в зависимости от кода ошибки. Подобный стиль программирования был типичен до введения в Object Pascal механизма обработки исключений. Однако сейчас, по-видимому, подобный стиль устарел и применение директив $I потеряло былое значение.</p>
<p>3) Директивы компилятора, определяющие размер стека</p>
<p>По умолчанию <span style="color: teal;">{$M 16384,1048576}</span></p>
<p>Область действия глобальная</p>
<p>Локальные переменные в процедурах и функциях размещаются в стеке приложения. При каждом вызове процедуры или функции ее локальные переменные помещаются в стек. При выходе из процедуры или функции эти локальные процедуры удаляются из стека.</p>
<p>Директивы компилятора $M задают параметры стека приложения: его минимальный и максимальный размеры. Приложение всегда гарантировано имеет размер стека, равный его минимальной величине. Если при запуске приложения Windows обнаруживает, что не может выделить этот&nbsp; минимальный объем памяти, то выдается сообщение об этой ошибке.</p>
<p>Если во время работы выясняется, что минимального размера стека не хватает, то размер увеличивается на 4 K, но не более, чем до установленного директивой максимального размера. Если увеличение размера стека невозможно из-за нехватки памяти или из-за достижения его максимальной величины, генерируется исключение EStackOverflow. Минимальный размер стека по умолчанию равен 16384 (16K). Этот размер может изменяться параметром minstacksize директивы <span style="color: teal;">{$M}</span> или параметром number директивы <span style="color: teal;">{$MINSTACKSIZE}</span>.</p>
<p>Максимальный размер стека по умолчанию равен 1,048,576 (1M). Этот размер может изменяться параметром maxstacksize директивы <span style="color: teal;">{$M}</span> или параметром number директивы <span style="color: teal;">{$MAXSTACKSIZE number}</span>. Значение минимального размера стека может задаваться целым числом в диапазоне между1024&nbsp; и 2147483647. Значение максимального размера стека должно быть не менее минимального размера и не более 2147483647. Директивы задания размера стека могут включаться только в программу и не должны использоваться в библиотеках и модулях.</p>
<p>В Delphi 1 имеется процедура компилятора <span style="color: teal;">{$S}</span>, осуществляющая переключение контроля переполнения стека. Теперь этот процесс полностью автоматизирован и директива <span style="color: teal;">{$S}</span> оставлена только для обратной совместимости.</p>
<p>4) Директивы компилятора, включающие и выключающие генерацию информации времени выполнения о типах (runtime type&nbsp; information - RTTI).</p>
<p>По умолчанию <span style="color: teal;">{$M-}</span> или <span style="color: teal;">{$ TYPEINFO OFF}</span></p>
<p>Область действия локальная</p>
<p>Директивы компилятора $M включают или выключают генерацию информации времени выполнения о типах (runtime type information - RTTI). Если класс объявляется в состоянии <span style="color: teal;">{$M+}</span> или является производным от класса объявленного в этом состоянии, то компилятор генерирует RTTI о его полях, методах и свойствах, объявленных в разделе published. В противном случае раздел published в классе не допускается. Класс TPersistent, являющийся предшественником большинства классов Delphi и все классов компонентов, объявлен в модуле&nbsp; Classes в состоянии <span style="color: teal;">{$M+}</span>. Так что для всех классов, производных от него, заботиться о директиве <span style="color: teal;">{$M+}</span>не приходится.</p>
<p>5) Директивы компилятора, включающие и выключающие проверку переполнения при целочисленных операциях</p>
<p>По умолчанию <span style="color: teal;">{$Q-}</span> или <span style="color: teal;">{$OVERFLOWCHECKS OFF}</span></p>
<p>Область действия локальная</p>
<p>Директивы компилятора $Q включают или выключают проверку переполнения при целочисленных операциях. Под переполнением понимается получение результата, который не может сохраняться в регистре компьютера. При включенной директиве <span style="color: teal;">{$Q+}</span> проверяется переполнение при целочисленных операциях +, -, *, Abs, Sqr, Succ, Pred, Inc и Dec. После каждой из этих операций размещается код, осуществляющий соответствующую проверку.&nbsp; Если обнаружено переполнение, то генерируется исключение EIntOverflow. Если это исключение не может быть обработано, выполнение программы завершается.</p>
<p>Директивы $Q проверяют только результат арифметических операций. Обычно они используются совместно с директивами <span style="color: teal;">{$R}</span>,&nbsp; проверяющими диапазон значений при присваивании.</p>
<p>Директива <span style="color: teal;">{$Q+}</span> замедляет выполнение программы и увеличивает ее размер. Поэтому обычно она используется только во время отладки программы. Однако, надо отдавать себе отчет, что отключение этой директивы приведет к появлению ошибочных&nbsp; результатов расчета в случаях, если переполнение действительно произойдет во время выполнении программы. Причем&nbsp; сообщений о подобных ошибках не будет.</p>
<p>6) Директивы компилятора, включающие и выключающие проверку диапазона целочисленных значений и индексов</p>
<p>По умолчанию <span style="color: teal;">{$R}</span> или <span style="color: teal;">{$RANGECHECKS OFF}</span></p>
<p>Область действия локальная</p>
<p>Директивы компилятора $R включают или выключают проверку диапазона целочисленных значений и индексов. Если включена директива <span style="color: teal;">{$R+}</span>, то все индексы массивов и строк и все присваивания скалярным переменным и переменным с ограниченным диапазоном значений проверяются на соответствие значения допустимому диапазону. Если требования диапазона нарушены или присваиваемое значение слишком велико, генерируется исключение ERangeError. Если оно не&nbsp; может быть перехвачено, выполнение программы завершается.</p>
<p>Проверка диапазона длинных строк типа Long strings не производится.</p>
<p>Директива <span style="color: teal;">{$R+}</span> замедляет работу приложения и увеличивает его размер. Поэтому она обычно используется только во время отладки.</p>
<p>7) Директива компилятора, связывающая с выполняемым модулем файлы ресурсов</p>
<p>Область действия локальная</p>
<p>Директива компилятора <span style="color: teal;">{$R}</span> указывает файлы ресурсов (.DFM, .RES), которые должны быть включены в выполняемый модуль или в библиотеку. Указанный файл должен быть файлом ресурсов Windows. По умолчанию расширение файлов ресурсов - .RES. </p>
<p>В процессе компоновки компилированной программы или библиотеки файлы, указанные в директивах <span style="color: teal;">{$R}</span>, копируются в выполняемый модуль. Компоновщик Delphi ищет эти файлы сначала в том каталоге, в котором расположен модуль, содержащий директиву <span style="color: teal;">{$R}</span>, а затем в каталогах, указанных при выполнении команды главного меню Project | Options&nbsp; на странице Directories/Conditionals диалогового окна в опции Search path или в опции /R командной строки DCC32.</p>
<p>При генерации кода модуля, содержащего форму, Delphi автоматически включает в файл .pas директиву <span style="color: teal;">{$R *.DFM}</span>, обеспечивающую компоновку файлов ресурсов форм. Эту директиву нельзя удалять из текста модуля, так как в противном случае загрузочный модуль не будет создан и генерируется исключение EResNotFound.</p>
<p class="author">Автор ответа: Cashey  </p>
<p>Взято с Vingrad.ru <a href="https://forum.vingrad.ru" target="_blank">https://forum.vingrad.ru</a></p>
<p>Исправлено и пополнено: Jin X</p>
<p class="note">Примечание Vit</p>
<p>Все установленные в настройках опции компиляции можно вставить непосредственно в текст программы нажав клавиши Ctrl-O, O</p>
