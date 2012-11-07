<h1>Кодовые потоки</h1>
<div class="date">01.01.2007</div>

<p>16. Кодовые потоки</p>
Многопоточность страшит многих программистов и часто расстраивает новичков. Потоки это элегантный путь решения многих проблем и он, однажды освоенный станет ценных вложением в вашу копилку опыта. Тема потоков может потребовать написания отдельной книги.</p>
16.1. Что такое поток?</p>
Поток это ваш код исполняемый паралелльно с другим вашим кодом в одной программе. Использование потоков позволяет выполнять несколько задач одновременно.</p>
Представим, что в вашей компании только один телефон. Поскольку, имеется только одна телефонная линия и только один человек может использовать ее в одно время. Тем не менее, если в установите несколько телефонных линий, то и другие смогут делать телефонные звонки не узнавая свободна линия или нет. Потоки позволяют вашему приложению делать несколько дел  одновременно.</p>
Параллельное выполнение потоков доступно даже если у вас один процессор. В действительности только одни поток исполняется, но операционная система принудительно прерывает потоки и исполняет их по очереди. Каждый поток выполняется только в течение очень короткого интервала времени. Это позволяет делать десятки тысяч переключений в секунду. Поскольку, переключение, вытесняющее и непредсказуемое, то будет казаться, что программы выполняются параллельно и программное обеспечение должно быть предусмотрено для работы в таком режиме.</p>
Если процессоров несколько, то потоки реально могут выполняться параллельно, но все равно каждый процессор выполняет только один поток.</p>
16.2. Достоинства потоков</p>
Использование потоков дает дополнительные преимущества перед обычным однопоточным дизайном.</p>
16.2.1. Управление приоритетами (Prioritization)</p>
Приоритеты отдельных потоков могут быть подстроены. Это позволяет отдельным серверным соединениям или клиентам получать больше процессорного времени.</p>
Если вы повышаете приоритет всех потоков, эффект не будет заметен, так как все они будут иметь равный приоритет. Тем не менее они могут отнять время у потоков других процессов. Вы должны осторожно относиться к этому и не устанавливать слишком высокий приоритет, поскольку это может вызвать конфликты  с потоками обслуживающими ввод/вывод.</p>
В большинстве случае вместо повышения приоритета, вы можете уменьшать его. Это позволяет менее важным задачам не забирать слишком много времени от более важных задач.</p>
Управление приоритетами потока также очень полезно на серверах и в некоторых случаях вы можете пожелать управлять приоритетом на основе логина. Если администратор подключается, то вы можете пожелать увеличить его приоритет, по сравнению с другими пользователями.</p>
16.2.2. Инкапсуляция</p>
Использование потоков позволяет отделить каждую задачу от других, чтобы они меньше влияли друг на друга.</p>
Если вы использовали Windows 3.1, то вы вероятно помните, как одно плохое приложение могло легко остановить всю систему. Потоки предотвращают подобное. Без потоков, все задачи должны были реализрваться в одном учвастке кода, создавая дополнительные сложности. С потоками, каждая задача может быть разделена на независимые секции, делая ваш код проще для программирования, когда требуется одновременное выполнение задач.</p>
16.2.3. Безопасность</p>
Каждый поток может иметь свои собственные атрибуты безопасности, базируясь на аутентификации или других критериях. Это особенно полезно для серверных реализаций, где каждый пользователь имеет поток, ассоциированный с его соединением. Это позволяет операционной системе, реализовать должную безопасность для каждого пользователя,  ограничивая его доступ к файлам и другим системным объектам. Без этого свойства вы должны бы реализовывать безопасность, возможно оставляя дыры в безопасности.</p>
16.2.4. Несколько процессоров</p>
Потоки могут автоматически использовать множество процессоров если они доступны . Если потоки не используются в вашем приложении, то вы имеете только один главный кодовый поток. Поток может исполняться только на одном процессоре и поэтому ваше приложение не исполняется максимально быстро.</p>
Другие процессы могут использовать другие процессоры, так же как и операционная система. Вызовы сделанные к операционной системе вашим приложением внутренне многопоточны и ваше приложение все равно получает определенное ускорение. В дополнение, время исполнения вашего приложение может лучше, поскольку и другие процессоры задействованы для других приложений и меньше нагружают ваш процессор.</p>
Наилучший путь получить преимущества от нескольких процессоров, это использование нескольких потоков в вашем приложении. Это не только позволяет вашему приложению использовать несколько процессоров, но и дает больше процессорного времени вашему приложению, поскольку у вас больше потоков.</p>
16.2.5. Не нужна последовательность</p>
Потоки предоставляют подлинное параллельное выполнение. Без потоков все запросы должны выполняться в одном потоке. Для этого работа каждой задачи должна быть разделена на малые части которые можно быстро выполнить. Если любая часть блокируется или требует много времени для исполнения, то все остальные части должны быть задержаны, пока она не выполнится. После того как одна части выполнится, начинается выполнение другой и так далее.</p>
С потоками, каждая задача может быть закодирована отдельно и операционная система разделит процессорное время между этими частями.</p>
16.3. Процессы против потоков</p>
Процессы отличаются от потоков, но их часто путают. Процесс это полностью законченный экземпляр приложения, который требует ресурсов для начала выполнения, включая передачу управления операционной системе и распределение дополнительной памяти. Преимущество процессов состоит в том, что они полностью изолированы один от другого, тогда как потоки изолированы только частично. Если процесс падает, то все остальные процесс остаются в неприкосновенности.</p>
16.4. Потоки против процессов</p>
Потоки подобны процессам и являются параллельно выполняемым кодом. Но потоки являются частью родительского процесса. Каждый поток имеет свой собственные стек, но использует совместную куча вместе с другими потоками, того же процесса. Потоки быстрее создавать, чем процесс. Потоки также создают меньшую нагрузку на операционную систему и требуют меньше памяти для работы.</p>
Поскольку потоки не полностью изолированы друг от друга, то их взаимодействие друг с другом значительно проще.</p>
16.5. Переменные потоков</p>
Переменные потока объявляются с использование ключевого слова ThreadVar.</p>
Переменные потока подобны глобальным переменным и объявляются подобным образом. Различие в том, что обычная глобальная переменная является глобальной для всех потоков, а переменные потока специфичны для каждого потока. Так в каждом потоке, появляется  свое собственное глобальное пространство.</p>
Переменные потока могут быть полезны, когда трудно передавать ссылки на объект между библиотеками или изолированными кусками кода. Конечно переменные потока имеют и ограничения. Переменные потока не могут быть использованы или объявлены внутри пакетов. Везде где только возможно, должны быть использованы члены-переменные в классе потока. Они обеспечивают меньшую нагрузку и доступны для использования в пакетах.</p>
16.6. Термины потоковый (threadable) и потоко-безопасный (threadsafe)</p>
Термин потоко-безопасный (threadsafe) часто используется или трактуется неправильно. Его часто применяют  одновременно к потоковый (threadable) и потоко-безопасный (threadsafe), что   приводит к ошибкам. В данном тексте, термины потоковый и потоко-безопасный точно определены и имеют разное значение.</p>
16.6.1. Термин потоковый (threadable)</p>
Термин потоковый означает, что объект может использоваться внутри потока или использоваться потоком, если он должным образом защищен. Объект помечается как потоковый и обычно не имеет зависимости от потоков.</p>
Если объект потоковый, то это означает, что он может использоваться в один потоке в каждый момент времени. Это может быть обеспечено созданием его локально в потоке или через глобальную защиту ресурсов.</p>
Примеры потоковых переменных - это значения типа Integer, String и другие ординарные типы, TList, TStringList и большинство невизуальных классов.</p>
Объект может иметь доступ к глобальным переменным или элементам управления GUI. Неограниченное (а часто и не нужное) использование глобальных переменных в большинстве  случаях, это то что мешает сделать компоненты потоковыми.</p>
Объект может быть библиотекой, компонентом, процедурой или .</p>
16.6.2. Термин потоко-безопасный (threadsafe)</p>
Термин потоко-безопасный означает, что объект осведомлен о потоках и имеет внутреннюю свою защиту ресурсов. Потоко-безопасные значения объекты могут использоваться в одном или нескольких потоках без применения защиты ресурсов.</p>
Примером потоко-безопасных классов является VCL класс TThreadList, а также потоко-безопасные классы Indy. Конечно операционная система также потоко-безопасна.</p>
16.7. Синхронизация</p>
Синхронизация - это процесс передачи информации из вторичного потока основному. VCL поддерживает это с помощью метода Sychronize класса TThread.</p>
16.8. Класс TThread</p>
Класс TThread это класс реализации потоков, который включен в VCL и предоставляет неплохую базу для построения потоков.</p>
Для реализация потока класс наследуется от TThread и переписывается метод Execute.</p>
16.9. Компонент TThreadList</p>
Компонент TThreadList - это потоко-безопасная реализация класса TList. Класс TList может быть использован в любом количестве потоков без необходимости защиты от одновременного доступа.</p>
Класс TThreadList работает подобно TList, но не совсем также. Некоторые методы, такие как as Add, Clear и Remove аналогичны. Для других операций, класс the TThreadList должен быть заблокирован с помощью метода LockList. метод LockList - это функции и она возвращает ссылку на внутренний экземпляр класса TList. Когда он заблокирован, все другие потоки будут заблокированы. По этому, очень важно разблокировать (Unlock) как можно быстрее.</p>
Пример операций с TThreadList:</p>
<pre>
with MyThreadList.LockList do 
try
  t := Bytes div {/} KILOry
  for i := 0 to Count - 1 do 
  begin
    // Operate on list items
    Items[i] := Uppercase(Items[i]);
  end;
finally 
  MyThreadList.UnlockList; 
end;
</pre>
</p>
Очень важно, что бы список всегда был разблокирован по окончанию кода и поэтому всегда блокирование и разблокирование должны делаться в защитном блоке try..finally. Если список остается заблокированным, то это приведет к зависанию других потоков при попытке их доступа к списку.</p>
16.10. Indy</p>
Indy содержит много дополнительных классов, которые дополняют VCL возможностями поддержки потоков. Данные классы в действительности независимы от ядра Indy и полезны и для всех приложений. Они существуют в Indy, поскольку Indy разработана для работы с потоками. Indy не только использует эти классы для серверных реализаций, но и предоставляет их разработчику. Данная глава предоставляет краткий обзор этих классов.</p>
16.11. Компонент TIdThread</p>
Компонент TIdThread - это наследник от TThread и добавляет дополнительные расширенные свойства, большинство из которых предназначены для построения серверов и также предоставляет поддержку пулов потоков и повторного использования.</p>
Если вы знакомы с потоками VCL, то очень важно принять во внимание, что TIdThread резко различается в нескольких ключевых областях. В TThread, метод Execute должен быть перегружен в наследниках, но в TIdThread должен быть перегружен метод Run. Ни в коем случаен не перегружайте метод Execute класса TIdThread, так как это будет препядствовать внутренним операциям TIdThread.</p>
Для всех наследников TIdThread, метод Run должен быть перегружен. Когда поток становится активным, выполняется метод Run. Метод Run последовательно вызывается в TIdThread, пока поток не будет остановлен.  Это может быть не очевидно для большинства клиентских программ, тем не менее это может быть особо полезно для всех серверов и некоторых случаев на клиенте. В этом также отличие от метода Execute класса TThread. Метод Execute вызывается только один раз. Когда завершается Execute, то поток также завершен.</p>
Есть и другие различия между TIdThread и TThread, но они не так значительны, как Run и Execute.</p>
16.12. Класс TIdThreadComponent</p>
Класс TIdThreadComponent - это компонент, который позволяет вам визуально строить новые потоки, просто добавляя событие в дизайн тайм. Это основано на визуальной инкапсуляции TIdThread, что позволяет делать новые потоки очень просто.</p>
Для использования TIdThreadComponent добавьте его на вашу форму, определите событие OnRun и установите свойство Active. Пример использования TIdThreadComponent можно увидеть в демонстрационном примере TIdThreadComponent, доступным с сайта проекта.</p>
16.13. Метод TIdSync</p>
Метод TThread имеет метод Synchronize, но он не имеет возможности передавать параметры в синхронизационные методы. Метод TIdSync имеет такую возможность. Метод TIdSync также позволяет возвращать значения из главного потока.</p>
16.14. Класс TIdNotify</p>
Синхронизация прекрасна, когда количество потоков небольшое. Тем не менее в серверных приложениях со многими потоками, они становятся узким горлышком и могут серьезно снизить производительность. Для решения этой проблемы, должны использоваться оповещения. В Indy класс TIdNotify реализует оповещения. Оповещения позволяют общаться с главным потоком, но в отличие от синхронизации потока неблокируют его, пока оповещение обрабатывается. Оповещения выполняют функцию, подобную синхронизации, но без снижения производительности.</p>
Тем не менее, оповещения имеют и ряд ограничений. Одно из них, что значение не может быть возвращено из главного потока, поскольку оповещения не останавливают вызоваюший поток.</p>
16.15. Класс TIdThreadSafe</p>
Класс TIdThreadSafe - это базовый класс, для реализации потоко-безопасных классов. Класс TIdThreadSafe никогда не используется сам по себе и разработан только как базовый класс.</p>
Indy содержит уже готовых наследников: TIdThreadSafeInteger, TIdThreadSafeCardinal, TIdThreadSafeString, TIdThreadSafeStringList, TIdThreadSafeList. Эти классы могут использоваться для потоко-безопасных версий типов integer, string и так далее. Они могут затем могут безопасно использоваться в любом количестве потоков, без необходимости заботиться об этом. В дополнение они поддерживают явное блокирование для расширенных целей.</p>
16.16. Общие проблемы</p>
Наибольшей проблемой при работе с потоками является параллельное выполнение. Поскольку потоки выполняются параллельно, то имеется проблема доступа к общим данным. При использовании потоков в приложении, возникают следующие проблемы:</p>
При выполнение клиентов в потоках, приносит следующие проблемы с конкурированием:</p>
<div style="text-align: justify; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 8px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">1.</td><td>обновление пользовательского интерфейса из потока.</td></tr></table></div>
<div style="text-align: justify; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 8px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">2.</td><td>общение с главным потоком из вторичных потоков.</td></tr></table></div>
<div style="text-align: justify; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 8px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">3.</td><td>доступ к данным главного потока из вторичных потоков.</td></tr></table></div>
<div style="text-align: justify; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 8px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">4.</td><td>возвращение результата из потока.</td></tr></table></div>
<div style="text-align: justify; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 8px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">5.</td><td>определение момента завершения потока.</td></tr></table></div>16.17. Узкие места</p>
Многие разработчики создают многопоточные приложения, которые работают нормально, пока количество потоков маленькое, но приложение деградирует, когда количество потоков увеличивается. Это эффект узкого горлышка. Эффект узкого горлышка проявляется когда какой то кусок кода блокирует другие потоки и другие потоки вынуждены ожидать его завершения. Не важно насколько быстр остальной код, проблема только в одном медленном куске. Код будет работать настолько быстро, насколько быстро работает его самая медленная часть.</p>
Многие разработчики вместо поиска узкого горлышка, тратят свое время на улучшение частей кода, который они считают недостаточно быстрым, тогда как узкое горлышко не позволяет достичь какого-либо эффекта.</p>
Обычно устранение одного узкого горлышка дает ускорение, больше чем сотни других оптимизаций. Поэтому, сфокусируйтесь на поиске узкого горлышка. И только после этого смотрите другой код для возможной оптимизации.</p>
Несколько узких мест будет рассмотрено ниже.</p>
16.17.1. Реализация критических секций</p>
Критические секции эффективным и простым способом позволяют управлять доступом к ресурсам, чтобы только один поток имел доступ к ресурсу одновременно.</p>
Часто одна критическая секция используется для защиты множества ресурсов. Допустим, что ресурсы A, B и C имеют одну общую критическую секцию для их защиты, хотя каждый ресурс независим. Проблема возникает, когда используется B, то A и C также заблокированы. Критические секции простые и выделенная критическая секция должна использоваться для каждого ресурса.</p>
Критические секции иногда могут заблокировать слишком много кода. Количество кода, между методами Enter и Leave в критической секции должно быть минимально возможным и в большинстве случаев должно использоваться несколько критических секций, если это возможно.</p>
16.17.2. Класс TMREWS</p>
Класс TMREWS может дать значительно увеличение производительности перед критическими секциями, если в основном доступ идет только по чтению и только иногда по записи. Тем не менее, класс TMREWS более сложный, чем критическая секция и требуется больше кода  для установки блокировки. Для небольших кусков кода, даже если запись минимальна, обычно критическая секция работает лучше, чем TMREWS.</p>
16.17.3. Синхронизация (Synchronizations)</p>
Синхронизация обычно используется для обновления пользовательского интерфейса.</p>
Проблема состоит в том, что синхронизация останавливает поток, пока она не будет закончена. Поскольку только главный поток обслуживает синхронизацию, только он может выполняться и остальные потоки выстраиваюися в очередь. Это делает все синхронизации самым главным узким горлышком.</p>
Используйте оповещение везде где только возможно.</p>
16.17.4. Обновление пользовательского интерфейса</p>
Многопоточные приложения часто делают слишком много обновлений пользовательского интерфейса. Потеря производительности быстро наступает из-за задержек в обновлении пользовательского интерфейса. В большинстве случаев многопоточные приложения выполняются медленнее, чем однопоточная версия.</p>
Особое внимание должно быть сделано при реализации серверов. Сервер есть сервер и основная  его задача обслуживать клиентов. Пользовательский интерфейс вторичен в данном случае. Поэтому пользовательский интерфейс лучше сделать в отдельном приложении, которое будет специальным клиентом для сервера. Другое решение - это использовать оповещения или пакетные обновления. В обоих этих случаях пользовательский интерфейс немного будет заторможен, но лучше иметь пользовательский интерфейс, который будет задержан на одну секунду, чем 200 клиентов, каждый их которых будет задержан на ту же секунду. Королями являются клиенты.</p>
