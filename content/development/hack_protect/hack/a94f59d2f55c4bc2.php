<h1>Декомпиляция в Delphi</h1>
<div class="date">01.01.2007</div>


<p>Декомпиляция в Delphi</p>
<p>(перевод одноимённой статьи с delphi.about.com )</p>
<p>Читая форумы по программированию, иногда натыкаешься на вопрос типа: "У меня есть откомпилированная программа на Delphi. Как мне получить её исходный код?". Обычно такой вопрос возникает, когда программист потерял файлы проекта и у него остался только .exe. Как правило полностью восстановить исходный код на языке высокого уровня невозможно. Значит ли это, что другие тоже не смогут восстановить исходный код Вашей программы ? Хм ... и да и нет ...</p>
<p>Для начала сразу скажу, что восстановить исходный код в точности каким он был однозначно невозможно, так как не существует в мире такого декомпилятора, который бы смог сотворить такое.</p>
<p>После компиляции и линковки проекта и получения исполняемого файла все имена, используемые в программе конвертируются в адреса. Потеря имён означет, что декомпилятор создаст уникальное имя для каждой константы, переменной, функции и процедуры. Даже если мы и достигнем какого-то успеха в декомпиляции исполняемого файла, то получим уже другой синтаксис программы. Данная проблема связана с тем, что при компиляции практически идентичные куски кода могут быть скомпилированы в разные последовательности машинных команд (ASM), которые присутствуют в .exe файле. Естевственно декомпилятор не обладает такой степенью интеллектуальности, чтобы решить - какова же была последовательность инструкций языка высокого уровня в исходном проекте.</p>
<p>Когда же применяется декомпиляция ? Для этого существует довольно много причин. Вот некторые из них:</p>
<p>- Восстановление исходного кода;</p>
<p>- Перенос приложения на другую платформу;</p>
<p>- Определение наличия вирусов в коде программы или вредоносного кода;</p>
<p>- Исправление ошибок в программе, в случае, если создатель приложения не собирается этого делать :)</p>
<p>Легально ли всё это ? Хотя декомпиляция и не является взломом, но утвердительно ответить на этот вопрос довольно сложно. Обычно программы защищены законом об авторских правах, однако в большинстве стран на декомпиляцию делается исключение. В часности, когда необходимо изменить интерфейс программы для конкретной страны, а сервис приложения не позволяет этого сделать.</p>
<p>На данный момент Borland не предоставляет никаких программных продуктов, способных декомпилировать исполняемые файлы (.exe) либо откомпилированные Delphi-модули (.dcu) в исходный код (.pas).</p>
<p>Если же Вы всё-таки решились попробовать декомпилировать исполняемый файл, то необходимо знать следующие вещи. Исходные коды на Delphi обычно хранятся в файлах двух типов: сам исходник в ASCII кодировке (.pas, .dpr) и файлы ресурсов (.res, .rc, .dfm, .dcr). Dfm файлы хранят в себе свойства объектов, содержащихся в форме. При создании конечного .exe, Delphi копирует в него информацию из .dfm файлов. Каждый раз, когда мы изменяем координаты формы, описания кнопок или связанные с ними события, то Delphi записывает эти изменения в .dfm (за исключением кода процедур. Он сохраняется в файлах pas/dcu ). И наконец, чтобы получить при декомпиляции файл .dfm, нужно знать - какие типы ресурсов хранятся внутри Win32 исполняемого модуля.</p>
<p>Все программы, скомпилированные в Delphi имеют следующие секции: CODE, DATA, BSS, .idata, tls, .rdata, .rsrc. Самые важные для декомпиляции секции CODE и .rsrc. В статье "Adding functionality to a Delphi program" приведены некоторые интересные факты о исполняемых форматах Delphi, а так же информация о классах и DFM ресурсах. В этой статье есть один интересный момент под заголовком: "Как добавить свой обработчик события в уже откомпилированный файл, например, чтобы изменять тект на кнопке".</p>
<p>Среди многих типов ресурсов, которые сохранены в .exe файле, интерес представляет RT_RCDATA, который хранит информацию, которая были в DFM файле перед трансляцией. Чтобы извлеч DFM данные из .exe файла, мы можем вызываться API функцией EnumResourceNames.</p>
<p>Исскуство декомпилирования традиционно было уделом мастеров, знакомых с ассемблером и отладчиками. Некоторые Delphi декомпиляторы создают впечатление, что любой, даже с ограниченными техническими знаниями, может изменить по своему желанию большинство исполняемых файлов Delphi.</p>
<p>И в заключение, если Вы заинтересовались декомпилованием, то предлагаю Вам несколько Delphi декомпиляторов:</p>
<p>DeDe</p>
<p>DeDe довольно шустрая программка, позволяющая анализировать экзешники, скомпилированные в Delphi. После декомпиляции DeDe даёт Вам следующее:</p>
<p>- Все dfm файлы. Вы сможете открывать их и редактировать в Delphi</p>
<p>- Все объявленные методы с хорошо комментированным кодом на ассемблере с ссылками на строки, импортированных функций, методов и компонент в юните, блоки Try-Except и Try-Finally.</p>
<p>- Большое количество дополнительной информации.</p>
<p>- Вы можете создать папку Delphi проекта со всеми файлами dfm, pas, dpr. Не забудьте, что pas файлы содержат ассемблерный код.</p>
<p>Revendepro</p>
<p>Revendepro находит почти все структуры (классы, типы, процедуры, и т.д.) в программе, и генерирует их паскальное представление, процедуры естевственно будут представлены на языке ассемблера. К сожалению, полученный ассемблерный код не может быть заново откомпилирован. Так же доступен исходник этого декомпилятора. К сожалению, этот декомпилятор не совсем рабочий - генерирует ошибку при декомпиляции.</p>
<p>MRIP</p>
<p>Позволяет извлекать из Delphi приложения любые ресурсы: курсоры, иконки, dfm файлы, pas файлы и т.д. Но главная его особенность - это способность извлекать файлы, хранящиеся в других файлах. Поддерживается более 100 форматов файлов. MRip работает под DOS.</p>
<p>Exe2Dpr</p>
<p>Эта программа может восстановить частично потерянные исходники проекта. Не имеет интерфейса и работает с командной строки, например: 'exe2dpr [-o] exeFile' ( исходники проекта будут созданы в текущей директории).</p>

<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>

