<h1>Параллельное выполнение (Concurrency)</h1>
<div class="date">01.01.2007</div>

<p>15. Параллельное выполнение (Concurrency)</p>
В многопоточной среде ресурсы должны быть защищены так, чтобы они не были разрушены при одновременном доступе.</p>
Параллельное выполнение и потоки переплетаются и выбор, что изучать сначала может быть сложным. В данном разделе мы рассмотрим параллельное выполнение и попытаемся дать понятия для изучения потоков.</p>
15.1. Терминология</p>
15.1.1. Параллельное выполнение</p>
Параллельное выполнение &#8211; это состояние, когда много задач возникает в одно и тоже время. Когда конкурирование реализовано правильно это может рассматривать как «гармония», а если плохо, то как «хаос» .</p>
В большинстве случаев, задача выполняется в потоке (thread). Но также это могут быть процессы (process) или волокна (fiber). Разделение очень условное, но использование правильной адстракции является ключем к успеху.</p>
15.1.2. Борьба (споры) за ресурсы (Contention)</p>
Что же такое точно борьба за ресурсы? Борьба за ресурсы &#8211; это когда более чем одна задача пытается получить доступ к одному и тому же ресурсу, в то же самое время.</p>
Для тех, кто живет в большой семье обычно понятно, о чем идет речь, и может дать пример споров. Представим себе семью с шестью маленькими детьми, когда мама ставит на сто маленькую пиццу. Будет драка.</p>
Когда множеству конкурирующих задач требуется доступ к данным режиме чтения/записи, то данные должны быть защищены. Если доступ не контролируется, две или более задач могут разрушить их, когда одна задача пытается писать, а другая читать одновременно. Если одна задача записывает во время чтения другой, то возможно чтение и запись несогласованных данных.</p>
Обычно в этом случае не возникает исключения, и ошибка проявится позже в программе.</p>
Проблемы борьбы за ресурсы не возникают в приложениях при малой нагрузке и поэтому не обнаруживают себя во время разработки. По этому правильное тестирование должно производиться на большой нагрузке. Иначе это подобно «русской рулеткe” и проблемы будут возникать редко во время разработки и часто в рабочей среде.</p>
15.1.3. Защита ресурсов (Resource Protection)</p>
Защита ресурсов &#8211; это способ разрешения проблемы борьбы за ресурсы. К функциям защиты ресурсов относится разрешение доступа только одной задаче в одно и то же время.</p>
15.2. Разрешение споров (Resolving Contention)</p>
Когда множеству потоков требуется доступ до ресурсов в режиме чтения/записи, данные должны контролироваться для защиты их целостности. Это может наводить ужас на программиста не умеющего работать с потоками.</p>
Как правило, большинство серверов не нуждаются в глобальных данных. Обычно им требуется читать данные только во время инициализации программы. Так как здесь нет доступа по записи потоки могут читать глобальные данные без побочных эффектов.</p>
Общи пути разрешения споров приведены ниже.</p>
15.2.1. Только чтение (Read Only)</p>
Самый простой метод &#8211; это режим только чтение. Все простые типы (integers, strings, memory), которые используются в режиме только чтения - не требуют защиты. Это также относится и к таким сложным типам как TList и другие. Классы безопасны если только не используют глобальные переменные или глобальные поля классов в режиме чтения/записи.</p>
В дополнение, ресурсы должны быть записаны перед любыми попытками чтения. Это делается путем инициализацией ресурсов во время запуска, до того как задачи будут к ним обращаться.</p>
15.2.2. Атомарные операции (Atomic Operations)</p>
Методология утверждает, что атомарные операции не требуют защиты. Атомарные операции &#8211; это такие операции, которые очень малы для деления в процессоре.&nbsp; Поскольку, их размер маленький, то это не приводит к спорам, так как они выполняются разом и не могут быть прерваны во время исполнения. Обычно атомарные операции &#8211; это строки кода компилируемые в одну иструкцию ассемблера.</p>
Обычно задачи, такие как чтение или запись целых чисел (integer) или логических полей (boolean field) являются атомарными операциями, так как они выполняются с помощью единственной инструкции move. Тем не менее моя рекомендация, такая &#8211; никогда не рассчитывайте на атомарность операций, поскольку в некоторых случаях, даже при записи целого (integer) или логического (Boolean) может быть выполнено более одной инструкции, в зависимости от того, откуда данные читались. В дополнение, это требует знания внутренней природы компилятора, которое является предметом для изменения в любое время, без вашего оповещения. Закладываясь на атомарные операции вы можете написать код, который будет неоднозначным в некоторых случаях и может работать по разному на многопроцессорных машинах или других операционных системах.</p>
Я до недавнего времени считал атомарные операции очень защищенными. Тем не менее,&nbsp; приход .NET принесет серьезную проблему. Когда наш код был компилирован в IL, и затем перекомпилирован в машинный код на платформах различных производителей, можете ли вы быть уверены, что каждая строка вашего кода будет атомарной операцией в конце концов?</p>
Выбор конечно ваш, и конечно есть аргументы как за, так и против атомарных операций. Атомарные операции в большинстве случаев сохраняют только несколько микросекунд и несколько байт кода. Я настоятельно рекомендую не использовать атомарные операции, так как они дают мало преимуществ и являются потенциальным источником неприятонстей .</p>
15.2.3. Поддержка Операционной Системы (Operating System Support)</p>
Многие операционные системы имеют поддержку базовых потоко-безопасных операций.</p>
Windows поддерживает набор функций, известных как, блочные (Interlocked) функции. Польза от этих функций очень маленькая и состоит в поддержке только простой функциональности для целых чисел, как увеличение, уменьшение, добавление, обмен и обмен со сравнением.</p>
Количество функций варьируется от версии Windows и может быть причиной замораживания (deadlocks) в старых версиях Windows. В большинстве приложений они имеют малые плюсы.</p>
Поскольку их функциональность ограничена, не поддерживается повсюду, и дает лишь некоторое увеличение производительности, вместо них в Indy рекомендуется использовать потоко-безопасные эквиваленты (заменители). (threadsafe).</p>
Windows также имеет поддержку объектов IPC (interprocess communication), обертка вокруг которых имеется в Delphi. Данные объекты особенно полезны для программирования потоков и IPC.</p>
15.2.4. Явная защита (Explicit Protection)</p>
Явная защита заставляет каждую задачу знать, что ресурсы защищены и требуют явных шагов по доступу к ресурсу. Обычно такой код расположен в отдельной подпрограмме,&nbsp; которая используется многими задачами конкурентно и работает как потоко-безопасная обертка.</p>
Явная защита обычно использует для синхронизации доступа к ресурсу специальный объект. Вкратце, защита ресурса ограничивает доступ к ресурсу для одной задачи за раз. Защита ресурса не ограничивает доступ к ресурсу, это требует знания специфики каждого ресурса. Вместо этого она подобна сигналам движения и код адаптирован так чтобы следовать и управлять сигналам трафика. Каждый объект защиты ресурса реализует определенный тип сигнала, используя различную логику управления и налагая различные ограничения на производительность . Это позволяет выбрать подходяший объект защиты в зависимости от ситуации.</p>
Существует несколько типов объектов защиты ресурсов и они будут отдельно рассмотрены позже.</p>
15.2.4.1. Критические секции (Critical Sections)</p>
Критические секции могут быть использованы для управления доступом к глобальным ресурсам. Критические секции требуют мало ресурсов и реализованы в VCL как TCriticalSection. Вкратце, критические секции позволяют отдельному потоку в многопоточном приложении, временно блокировать доступ к ресурсу для других потоков исаользующих эту же&nbsp; критическую секцию. Критические секции подобны светофорам, которые зажинают зеленый сигнал только если впереди нет ни одной другой машины. Критические секции могут быть использованы, чтобы быть уверенным, что только один поток может исполняться в одно время. Поэтому, защищенные блоки должны быть минимального размера, так как они могут сильно понизить производительность, если будут неправильно использованы. Поэтому, каждый уникальный блок должен также использовать свою собственную критическую секцию (TCriticalSection) вместо использования единой для всего приложения.</p>
Для входа в критическую секцию вызовите метод Enter и затем метод Leave для выхода из секции. Класс TCriticalSection также имеет методы Acquire и Release, которые аналогичны Enter и Leave соответственно.</p>
Предположим, что сервер должен вести лог клиентов и отображать информацию в главном потоке. Мнение, что это должно быть синхронизироваться. Тем не менее, использование данного метода может негативно сказаться на производительности потока соединения, если много клиентов будут подключаться одновременно. В зависимости от потребностей сервера, лучшим решением был бы лог информации, а главный поток мог бы читать ее по таймеру. Следующий код является примером данной техники, которая использует критические секции.</p>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 8px 0px 0px 19px;"><pre>var
  GLogCS: TCriticalSection;
  GUserLog: TStringList;
procedure TformMain.IdTCPServer1Connect(AThread: TIdPeerThread);
var
  s: string;
begin
  // Username
  s := ReadLn;
  GLogCS.Enter; 
  try
 &nbsp;&nbsp; GUserLog.Add('User logged in: ' + s);
  finally 
 &nbsp;&nbsp; GLogCS.Leave; 
  end;
end;
procedure TformMain.Timer1Timer(Sender: TObject);
begin
  GLogCS.Enter; 
  try
 &nbsp;&nbsp; listbox1.Items.AddStrings(GUserLog);
 &nbsp;&nbsp; GUserLog.Clear;
  finally 
 &nbsp;&nbsp; GLogCS.Leave; 
  end;
end;
initialization
  GLogCS := TCriticalSection.Create;
  GUserLog := TStringList.Create;
finalization
  FreeAndNil(GUserLog);
  FreeAndNil(GLogCS);
end.
</pre>
&nbsp;</p>
В событии Connect имя пользователя читается во временную переменную перед входом в критическую секцию. Это сделано, чтобы избежать блокирования кода низкоскоростным клиентом в критической секции.</p>
Это позволяет сетевому соединению быть выполненным до входа в критическую секцию. Для сохранения максимальной производительности, код в критической секции сделан минимально возможным.</p>
Событие Timer1Timer возбуждается в главной форме. Интервал таймера может быть короче для более частых обновлений, но потенциально может замедлить восприятия соединения. Если требуется выполнять логирование и в других местах, кроме регистрации пользователей, то существует большая вероятность появления узкого места в производительности. Больший интервал обновлений, сводит задержки в интерфейсе к минимуму. Конечно, многие серверы не имеют никакого интерфейса, а те в которых он есть, он является вторичным и выполняется с меньгим приоритетом, чем поток, обслуживающий клиентов, что вполне допустимо.</p>
Примечание пользователям Delphi 4: Класс TCriticalSection находится в модуле SyncObjs. Модуль SyncObjs обычно не включен в Delphi 4 Standard Edition. Если Вы используете Delphi 4, то Вы можете загрущить SyncObjs.pas файл с web сайта Indy. Этот файл не срдержит всей функциональности реализованной Борланд, но имеет реализацию класса TCriticalSection.</p>
15.2.4.2. Класс TMultiReadExclusiveWriteSynchronizer (TMREWS)</p>
В предыдущем примере, Класс TCriticalSection был использован для защиты доступа к глобальным данным. Он нужен случаях когда глобальные данные всегда обновляются. Конечно, если глобальные данные должны быть доступны в режиме чтения и только иногда для записи, то использования класса TMultiReadExclusiveWriteSynchronizer будет более эффективно.</p>
Класс TMultiReadExclusiveWriteSynchronizer имеет очень длинное и трудно читаемое имя. Поэтому мы будем называть его просто TMREWS.</p>
Преимущества использования TMREWS состоит в том, что он позволяет конкурентное чтение из многих потоков, и действует как критическая секция, позволяя только одному потку доступ для записи. Недостатком TMREWS является, что он более сложен в использовании.</p>
Вместо Enter/Acquire и Leave/Release, TMREWS имеет методы: BeginRead, EndRead, BeginWrite и EndWrite.</p>
15.2.4.2.1. Специальное примечание к классу TMREWS</p>
До Delphi 6 в классе TMultiReadExclusiveWriteSynchronizer имелась проблема, приводящая к взаимному блокированию (dead lock) при повышении уровня блокировки с чтения на запись. Поэтому, вы не никогда должны использовать данную возможность изменения блокировки чтения в блокировку записи, несмотря на то, что документация утверждает что это можно сделать. </p>
Если вам нужна подобная функциональность, то имеется обходной путь. Он состоит в том, что сначала надо освободить блокировку чтения, а затем поставить блокировку записи. Тем не менее, если вы установили блокировку записи, то вы должны затем снова проверить условие, необходимое для начала записи. Если оно все еще выполняется, делаете свою запись,&nbsp; в противном случае немедленно снимите блокировку.</p>
Класс TMultiReadExclusiveWriteSynchronizer так требует особой осторожности при использовании в Delphi 6. Все версии класса TMultiReadExclusiveWriteSynchronizer включая, поставляемый в update pack 1 и в update pack 2 имеют серьезные проблемы, которые могут вызвать взаимную блокировку. Обходных путей пока нет.</p>
Borland в курсе этого и выпустил неофициальный патч и также ожидаются официальные патчи.</p>
15.2.4.2.2. Примечание к классу TMREWS в Kylix</p>
Класс TMultiReadExclusiveWriteSynchronizer в Kylix 1 и Kylix 2 реализован с помощью&nbsp; критических секций и не имеет преимуществ перед критическими секциями. Это сделано, что бы можно было писать общий код и для Linux и для Windows. </p>
В будущих версиях Kylix, класс TMultiReadExclusiveWriteSynchronizer вероятно будет изменен, что бы работал также как Windows.</p>
15.2.4.3. Выбор между Critical Sections и TMREWS</p>
Поскольку класс TMREWS имеет некоторые проблемы, мой совет просто избегать его. Если вы решили использовать его, вы должны быть уверены, что это действительно лучший выбор и он должен быть реализован с помощью пропатченной версии, не подверденной зависаниям.</p>
Правильное использование TCriticalSection в большинстве случаев дает обычно такой же быстрый синхронизированный доступ, а в некоторых случаях самый. Научитесь правильно использовать TCriticalSection, так как неправильное исаольщование может иметь негативное влияние на производительность.</p>
Ключом к защите любых ресурсов является использование множества точек входа в секции и выполнение критических секций кода как можно быстрее. Когда проблема может быть разрешена с помощью критических секций, то она должна решаться с их помощью, вместо использования TMREWS, поскольку критические секции проще и быстрее. В общем, всегда используйте критические секции вместо TMREWS.</p>
Класс TMREWS работает лучше, если встретятся следующие условия:</p>
<div style="text-align: justify; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 8px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="24">1.</td><td>доступ осуществляется по чтению и записи.</td></tr></table></div><div style="text-align: justify; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 8px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="24">2.</td><td>преобладает доступ по чтению.</td></tr></table></div><div style="text-align: justify; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 8px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="24">3.</td><td>период блокировки велик и не может быть разбит на меньшие независимые куски.</td></tr></table></div><div style="text-align: justify; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 8px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="24">4.</td><td>доступен пропатченый класс TMREWS и известно что он работает корректно.</td></tr></table></div>15.2.4.4. Сравнение производительности</p>
Как уже упоминалось ранее критические секции легковесны и мало влияют на производительность. Они реализованы в ядре операционной системы.&nbsp; ОС реализует их используя короткие эффективные ассемблерные команды.</p>
Класс TMREWS более сложен и поэтому больше влияет на производительность. Он должен управлять списком запросов для поддержания состояния блокировок.</p>
Для того чтобы продемонстрировать разницу был создан демонстрационный проект ConcurrencySpeed.dpr. Он проводит три простых замера:</p>
<div style="text-align: justify; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 8px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="24">1.</td><td>TCriticalSection &#8211; Enter и Leave</td></tr></table></div><div style="text-align: justify; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 8px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="24">2.</td><td>TMREWS &#8211; BeginRead и EndRead</td></tr></table></div><div style="text-align: justify; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 8px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="24">3.</td><td>TMREWS &#8211; BeginWrite и EndWrite</td></tr></table></div>Он делает это выполняя цикл заданное количество раз. Для примера 100000. В моих тестах я получил следующие результаты.</p>
TCriticalSection: 20</p>
TMREWS (Read Lock): 150</p>
TMREWS (Write Lock): 401</p>
Конечно, результаты зависят от компьютера. Но важна разница, а не абсолютные числа. Я могу видеть что при оптимальных условиях запись TMREWS в 7.5 раз медленне критических секций. А запись медленнее в 20 раз.</p>
Нужно также заметить, что критические секции практически не деградирую при нагрузке, тогда как TMREWS сильно сдает. Тест выполнялся в простом цикле, и не было других запросов на блокировку. В реальной жизни TMREWS будет еще медленнее чем показано здесь.</p>
15.2.4.5. Мьютексы (Mutexes)</p>
Функции мьютексов почти полностью аналогичны критическим секциям. Разница состоит в том, что мьютексы - это более мощная версия критических секций с большим количеством свойств и конечно в связи с этим большим воздействием на производительность.</p>
Мьютексы имеют дополнительные возможности по именованию, назначению атрибутов безопасности и они доступны между процессами.</p>
Мьютексы могут быть использованы для синхронизации потоков, но они редко используются в данном качестве. Мьютексы были разработаны и используются, для синхронизации между процессами.</p>
15.2.4.6. Семафоры (Semaphores)</p>
Семафоры подобны мьютексам, но вместо единичного доступа, позволяют множественный. Количество доступов, которое разрешено определяется при создании семафора.</p>
Представим, что мьютекс это охранник в банке, который позволяет доступ только одному человеку к банкомату (ATM). Только один человек за раз может использовать его и охранник защищает машину от доступа нескольких человек одновременно.</p>
В данном случае, семафор будет более предпочтителен, если установлено четыре банкомата. В этом случае охранник позволяет нескольким людям войти в банк и использовать эти банкоматы, но не более четырех человек одновременно .</p>
15.2.4.7. События (Events)</p>
События &#8211; это сигналы, которые могут быть использованы между потоками или процессами, для оповещения о том, что что-то произошло. События могут быть использованы для оповещения других задач, когда что-то произошло или требуется вмешательство.</p>
15.2.5. Потоко-безопасные классы</p>
Потоко-безопасные классы были специально разработаны для защиты специфических типов ресурсов. Потоко-безопасные классы реализуют специфический тип ресурса и имеют сокровенные знания, что это за ресурс и как он функционирует.</p>
Потоко-безопасные классы могут быть простыми, как потоко-безопасный integer или комплексными, как потоко-безопасные базы данных. Потоко-безопасные классы внутри используют потоко-безопасные объекты для выполнения своих функций.</p>
15.2.6. Изоляция (Compartmentalization)</p>
Изоляция &#8211; это процесс изоляции данных и назначения их только для использования одной задачей. На серверах изоляция - это естественный путь, так как каждый клиент может обслуживаться выделенным потоком.</p>
Когда изоляция не является естественной, необходимо оценить возмодность ее использования . Изоляция часто может быть достигнута путем создания копии глобальных данных, работы с этими данными и затем возврата этих данных в глобальную область. При использовании изоляции, данные блокируются только во время инициализации и после окончания выполнения задачи, или во время применения пакетных обновлений.</p>
&nbsp;</p>
