<h1>Перехватчики (Intercepts)</h1>
<div class="date">01.01.2007</div>

<p>13. Перехватчики (Intercepts)</p>
Перехватчик &#8211; это более высокий уровень, чем обработчик ввода/вывода и используется для модификации или перехвата данных независимо от источника и приемника.</p>
Перехватчики были сильно изменены в версии 9.0. В версии 8.0 перехватчик мог предоставлять только весьма ограниченную функциональность обработчика ввода/вывода. Перехватчики могут трансформировать уже принятые данные или данные для передачи. Перехватчики более не поддерживают никакой функциональности обработчика ввода/вывода (IOHandler), поскольку введены новые классы IOHandler, со всей необходимой&nbsp; функциональностью.</p>
Перехватчики попрежнему могут выполнять преобразования данных и но предоставляют больше возможностей в Indy 9.0. Возможности трансформация в Indy 8.0 были сильно ограничены, так как данные должны были иметь один и тот же размер. Это делало невозможным использовать их для реализации сжатия данных или логирования, поскольку не позволяло изменить размер данных.</p>
Перехватчики позволяют изменять данные после того, как они были приняты в IOHandler или изменять их перед посылкой в IOHandler. Перехватчики в данный момент используются для реализации ведения логов и отладки компонент. Они могут быть также использованы для реализации шифрования, сжатия, статических коллекторов или ограничитения трафика.</p>
13.1. Перехватчики</p>
Перехватчики взаимодействуют с входящими или исходящими данными и позволяют их записывать в лог или модифицировать. Перехватчики позволяют изменять входящие данные, после того как они приняты из сети, перед выдачей их пользователю.</p>
Перехватчики также позволяют модифицировать исходящие данные перед посылкой в сеть. Перехватчики могут быть использоваться для реализации ведения логов, шифрования и сжатия данных.</p>
Клиентские перехватчики базируются на соединениях (по одному на каждое). Они также могут быть использованы на сервере, если они назначены индивидуальному соединению.</p>
Примечание: Перехватчики в Indy 9 отличаются от перехватчиков в Indy 8. Перехватчики в Indy 8, выполняли комбинированную роль перехватчика и обработчика ввода/вывода. Что делало сложным разделение функций перехвата и обработки. Перехватчики Indy 8 также не могли изменять размер данных и поэтому были непригодны для сжатия.</p>
13.2. Ведение логов (Logging)</p>
Indy 8.0 имел один компонент ведения логов, который мог быть использован для различных источников. В Indy 9.0 компоненты логов теперь базируются на новом общем классе и имеют специализированные классы. Базовый класс также предоставляет свойства и функциональность, такую как регистрация времени, в дополнение к данным.</p>
Все классы ведения логов реализованы, как перехватчики. Это означает, что они перехватывают входящие данные, после того, как они были прочитаны и перед передачей исходящих в источник.</p>
Специализированные классы логов, следующее:</p>
<div style="text-align: justify; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 8px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#183;</td><td>TIdLogEvent &#8211; возбуждает события, когда данные приняты, или переданы, или при появлении события состояния. Класс TIdLogEvent полезен для реализации пользовательских логов, без необходимости в реализации нового класса.</td></tr></table></div><div style="text-align: justify; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 8px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#183;</td><td>TIdLogFile &#8211; Записывает данные в файл.</td></tr></table></div><div style="text-align: justify; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 8px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#183;</td><td>TIdLogDebug &#8211; Записывает данные в окно отладки Windows или в консоль Linux. Также отмечает данные, как принятые данные, переданные данные или информация о статусе. Класс TidLogDebug полезен для проведения простой отладки.</td></tr></table></div><div style="text-align: justify; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 8px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#183;</td><td>TIdLogStream &#8211; Не добавляет комментариев, отметок к данным, как другие классы. Вместо этого просто записывает сырые данные в указанный поток. Класс TIdLogStream может использоваться по разному, но обычно он очень эффективно используется для QA тестирования и удаленной отладки. Могут быть построены и пользовательские классы логов.</td></tr></table></div>&nbsp;</p>
