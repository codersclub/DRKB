<h1>Протокол IP</h1>
<div class="date">01.01.2007</div>

<p>Протокол IP</p>
<p>Радик Усманов<br>
<p>radik@binep.ac.ru </p>
<p>Сентябрь 1994 г. </p>
Реферат: Документ содержит русский перевод спецификации сетевого протокола IP (Internet Protocol) - основного протокола международной компьютерной сети Internet. Оригинальный документ известен, как RFC791. </p>
<p>Примечания редактора</p>
<p>Оригинальная версия документа RFC791 размещается на сервере ISI (Information Sciences Institute): </p>
<p> URL - http://info.internet.isi.edu/in-notes/rfc/files/rfc791.txt</p>
<p>Спецификации протоколов стека IP: </p>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 7px 0px 7px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="24">&#183;</td><td>UDP - User Datagram Protocol </td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 7px 0px 7px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="24">&#183;</td><td>TCP - Transmission Control Protocol </td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 7px 0px 7px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="24">&#183;</td><td>ICMP - Internet Control Message Protocol </td></tr></table></div>
<p>RFC 791&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Internet протокол </p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Проект Darpa Internet&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Спецификация протокола &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; сентябрь 1981&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; приготовлено для &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Агенства расширенных оборонных исследовательских проектов &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Офис технологий обработки информации &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 1400 Wilson Boulevard&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Arlington, Virginia 22209&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Институтом Информатики &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Университета Южной Каролины &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 4676 Admiralty Way&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Marina del Rey, California 90291&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Содержание &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </p>
<p>  Предисловие</p>
<p>1. Введение</p>
<p>  1.1 Обоснование</p>
<p>  1.2 Цель</p>
<p>  1.3 Интерфейсы</p>
<p>  1.4 Действие</p>
<p>2. Обзор</p>
<p>  2.1 Связь с другими протоколами</p>
<p>  2.2 Сценарий работы</p>
<p>  2.3 Описание функций</p>
<p>  2.4 Шлюзы</p>
<p>3. Спецификация</p>
<p>  3.1 Формат заголовка Internet</p>
<p>  3.2 Обсуждение</p>
<p>  3.3 Интерфейсы</p>
<p>Приложение А: Примеры и сценарии</p>
<p>Приложение Б: Порядок передачи данных</p>
<p>Толковый словарь</p>
<p>Ссылки</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Предисловие &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </p>
<p>Данный документ устанавливает Internet протокол в стандарте DOD. Он </p>
<p>основан на шести предыдущих версиях спецификации протокола ARPA </p>
<p>Internet, и из них в значительной степени заимствован его текст. Вместе </p>
<p>с тем в эту работу внесены многие изменения, касающиеся как </p>
<p>терминологии, так и собственно изложения материала. Это издание освещает </p>
<p>адресацию, обработку ошибок, коды опций, а также безапасность, историю и </p>
<p>поддержку свойств протокола Internet.</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Джон Постел (Jon Postel)</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Редактор</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Протокол Internet&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Программа DARPA Internet&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Спецификация протокола &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 1. Введение &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </p>
<p>1.1 Обоснование</p>
<p> &nbsp; Протокол Internet создан для использования в объединенных системах </p>
<p>компьютерных коммуникационных сетей с коммутацией пакетов. Такие системы </p>
<p>были названы "catenet" [1]. Протокол Internet обеспечивает передачу </p>
<p>блоков данных, называемых датаграммами, от отправителя к получателям, </p>
<p>где отправители и получатели являются хост-компьютерами, </p>
<p>идентифицируемыми адресами фиксированной длины. Протокол Internet </p>
<p>обеспечивает при необходимости также фрагментацию и сборку датаграмм для </p>
<p>передачи данных через сети с малым размером пакетов.</p>
<p>1.2 Цель</p>
<p> &nbsp; Протокол Internet специально ограничен задачами обеспечения функций, </p>
<p>необходимых для передачи битового пакета (датаграммы Internet) от </p>
<p>отправителя к получателю через объединенную систему компьютерных сетей. </p>
<p>Нет механизмов для увеличения достоверности конечных данных, управления </p>
<p>протоколом, синхронизации или других услуг, обычно приненяемых в </p>
<p>протоколах передачи от хоста к хосту. Протокол Ineternet может обобщить </p>
<p>услуги поддерживающих его сетей с целью предоставления услуг различных </p>
<p>типов и качеств.</p>
<p>1.3 Интерфейсы</p>
<p> &nbsp; Данный протокол получил название в соответствии с протоколами </p>
<p>передачи информации между хост-компьютерами в межсетевой среде. Протокол </p>
<p>вызывает в локальной сети протоколы для передачи датаграммы Internet на </p>
<p>следующий шлюз или хост-получатель.</p>
<p> &nbsp; Например, модуль TCP вызывал бы модуль Internet с тем, чтобы получить </p>
<p>сегмент TCP (включая заголовок TCP и данные пользователя) как </p>
<p>информационную часть Internet пакета. Модуль TCP обеспечил бы адреса и </p>
<p>другие параметры в заголовке модуля Internet в качестве параметров </p>
<p>рассматриваемого вызова. Модуль Internet в этом случае создал бы </p>
<p>датаграмму Internet и прибегнул бы к услугам локальной сети для передачи </p>
<p>датаграммы Internet.</p>
<p> &nbsp; Например, в случае сети ARPANET модуль Ineternet вызывал бы локальный </p>
<p>сетевой модуль, который бы добавлял к датаграмме Internet проводник типа </p>
<p>1822 [2], создавая сообщение ARPANET для передачи на IMP. Адрес ARPANET </p>
<p>получился бы из адреса Intenet с помощью интерфейса локальной сети и </p>
<p>относился бы к некоторому хост-компьютеру в сети ARPANET, который мог бы </p>
<p>быть шлюзом в другие сети.</p>
<p>1.4 Действие</p>
<p> &nbsp; Протокол Internet выполняет две главные функции: адресацию и </p>
<p>фрагментацию.</p>
<p> &nbsp; Модули Internet используют адреса, помещенные в заголовок Internet, </p>
<p>для передачи Internet датаграмм их получателям. Выбор пути передачи </p>
<p>называется маршрутизацией.</p>
<p> &nbsp; Модули Internet используют поля в заголовке Internet для фрагментации </p>
<p>и восстановления датаграмм Internet, когда это необходимо для их </p>
<p>передачи через сети с малым размером пакетов.</p>
<p> &nbsp; Сценарий действия состоит в том, что модуль Internet меняет размер на </p>
<p>каждом из хостов, задействованных в internet-коммуникации и на каждом из </p>
<p>шлюзов, обеспечивающих взаимодействие между сетями. Эти модули </p>
<p>придерживаются общих правил для интерпретации полей адресов, для </p>
<p>фрагментации и сборки Internet датаграмм. Кроме этого, данные модули (и </p>
<p>особенно шлюзы) имеют процедуры для принятия решений о маршрутизации, а </p>
<p>также другие функции.</p>
<p> &nbsp; Протокол Internet обрабатывает каждую Internet датаграмму как </p>
<p>независимую единицу, не имеющую связи ни с какими другими датаграммами </p>
<p>Internet. Протокол не имеет дело ни с соединениями, ни с логическими </p>
<p>цепочками (виртуальными или какими-либо другими).</p>
<p> &nbsp; Протокол Internet использует четыре ключевых механизма для </p>
<p>формирования своих услуг: задание типа сервиса, времени жизни, опций и </p>
<p>контрольной суммы заголовка.</p>
<p> &nbsp; Тип обслуживания используется для обозначения требуемой услуги. Тип </p>
<p>обслуживания - это абстрактный или обобщенный набор параметров, который </p>
<p>характеризует набор услуг, предоставляемых сетями, и составляющих </p>
<p>собственно протокол Internet. Этот способ обозначения услуг должен </p>
<p>использоваться шлюзами для выбора рабочих параметров передачи в </p>
<p>конкретной сети, для выбора сети, используемой при следующем переходе </p>
<p>датаграммы, для выбора следующего шлюза при маршрутизации сетевой </p>
<p>Internet датаграммы.</p>
<p> &nbsp; Механизм времени жизни служит для указания верхнего предела времени </p>
<p>жизни Internet датаграммы. Этот параметр устанавливается отправителем </p>
<p>датаграммы и уменьшается в каждой точке на проходимом датаграммой </p>
<p>маршруте. Если параметр времени жизни станет нулевым до того, как </p>
<p>Internet датаграмма достигнет получателя, эта датаграмма будет </p>
<p>уничтожена. Время жизни можно рассматривать как часовой механизм </p>
<p>самоуничтожения.</p>
<p> &nbsp; Механизм опций предоставляет функции управления, которые являются </p>
<p>необходимыми или просто полезными при определенных ситуациях, однако он </p>
<p>ненужен при обычных комминикациях. Механизм опций предоставляет такие </p>
<p>возможности, как временные штампы, безопасность, специальная </p>
<p>маршрутизация.</p>
<p> &nbsp; Контрольная сумма заголовка обеспечивает проверку того, что </p>
<p>информация, используемая для обработки датаграмм Internet, передана </p>
<p>правильно. Данные могут содержать ошибки. Если контрольная сумма </p>
<p>неверна, то Internet датаграмма будет разрушена, как только ошибка будет </p>
<p>обнаружена.</p>
<p> &nbsp; Протокол Internet не обеспечивает надежности коммуникации. Не имеется </p>
<p>механизма подтверждений ни между отправителем и получателем, ни между </p>
<p>хост-компьютерами. Не имеется контроля ошибок для поля данных, только </p>
<p>контрольная сумма для заголовка. Не поддерживается повторная передача, </p>
<p>нет управления потоком.</p>
<p> &nbsp; Обнаруженные ошибки могут быть оглашены посредством протокола ICMP </p>
<p>(Internet Control Message Protocol) [3], который поддерживается модулем </p>
<p>Internet протокола.</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 2. Обзор &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </p>
<p>2.1 Связь с другими протоколами</p>
<p> &nbsp; Следующая диаграмма иллюстрирует место протокола Internet в иерархии </p>
<p>протоколов.</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; +------+ +-----+ +------+&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; +-----+</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; |Telnet| | FTP | | TFTP |&nbsp; ...&nbsp; | ... |</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; +------+ +-----+ +------+&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; +-----+</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; |&nbsp;&nbsp; |&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; |&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; |</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; +-----+&nbsp;&nbsp;&nbsp;&nbsp; +-----+&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; +-----+</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; | TCP |&nbsp;&nbsp;&nbsp;&nbsp; | UDP |&nbsp;&nbsp; ...&nbsp; | ... |</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; +-----+&nbsp;&nbsp;&nbsp;&nbsp; +-----+&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; +-----+</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; |&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; |&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; |</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; +--------------------------+</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; | Internet Protocol &amp; ICMP |</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; +--------------------------+</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; |</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; +------------------------+</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; | Local Network Protocol |</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; +------------------------+</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Рис. 1 Взаимодействие протоколов</p>
<p> &nbsp; Протокол Internet взаимодействует с одной стороны с протоколами </p>
<p>передачи информации между хост-компьютерами, а с другой - с протоколами </p>
<p>локальной компьютерной сети. При этом локальная сеть может являться </p>
<p>малой компьютерной сетью, участвующей в создании большой сети, такой как </p>
<p>ARPANET.</p>
<p>2.2 Сценарий работы</p>
<p> &nbsp; Схему действий для передачи датаграммы от одной прикладной программы </p>
<p>к другой можно проиллюстрировать следующим образом:</p>
<p> &nbsp; Предположим, что перенос будет включать прохождение одного </p>
<p>промежуточного шлюза. Отправляющая прикладная программа готовит свои </p>
<p>данные и вызывает свой локальный Internet модуль для отправки этих </p>
<p>данных в качестве датаграммы, а в качестве аргументов этого вызова </p>
<p>передает адрес получателя и другие параметры.</p>
<p> &nbsp; Модуль Internet готовит заголовок датаграммы и стыкует с ним данные. </p>
<p>Модуль Internet определяет локальный сетевой адрес, соответствующий </p>
<p>данному адресу Internet. В данном случае это адрес шлюза.</p>
<p> &nbsp; Модуль передает данную датаграмму и адрес в локальной сети в </p>
<p>распоряжение интерфейса локальной сети.</p>
<p> &nbsp; Интерфейс локальной сети создает соответствующий этой сети заголовок </p>
<p>и соединяет с ним датаграмму. Затем он передает по локальной сети </p>
<p>полученный таким образом результат.</p>
<p> &nbsp; Датаграмма достигает хост-компьютер, играющий роль шлюза и </p>
<p>расположенный в вершине сети. Интерфейс локальной сети отделяет этот </p>
<p>заголовок и передает датаграмму на модуль Internet. Модуль Internet </p>
<p>определяет из Internet адреса, что датаграмма должна быть направлена на </p>
<p>хост-компьютер во второй сети. Модуль Internet определяет адрес </p>
<p>хоста-получателя в локальной сети. Он обращается к интерфейсу локальной </p>
<p>сети с тем, чтобы она переслала данную датаграмму по назначению.</p>
<p> &nbsp; Интерфейс создает заголовок локальной сети и соединяет с </p>
<p>ним датаграмму, а затем результат на правляет на хост-получатель. </p>
<p> &nbsp; На хосте-получателе интерфейс локальной сети удалает заголовок </p>
<p>локальной сети и передает оставшееся на Internet модуль.</p>
<p> &nbsp; Модуль Internet определяет, что рассматриваемая выше датаграмма </p>
<p>предназначена для прикладной программы на этот хосте. Модуль передает </p>
<p>данные прикладной программе в ответ на системный вызов. В качестве </p>
<p>результата этого вызова передаются адрес получателя и другие параметры.</p>
<p>прикладная программа &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; прикладная программа</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; \&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; /</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp; модуль Internet&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; модуль Internet&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; модуль Internet</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; \&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; /&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; \&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; /</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; LNI-1&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; LNI-1&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; LNI-2&nbsp;&nbsp;&nbsp;&nbsp; LNI2</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; \&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; /&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; \&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; /</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; локальная сеть 1&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; локальная сеть 2</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Рис. 2 Путь передачи датаграммы</p>
<p>2.3 Описание функций</p>
<p> &nbsp; Функция или цель протокола Internet состоит в передаче датаграммы </p>
<p>через набор объединенных компьютерных сетей. Это осуществляется </p>
<p>посредством передачи датаграмм от одного модуля Internet к другому до </p>
<p>тех пор, пока не будет достигнут получатель. Модули Internet находятся </p>
<p>на хостах и шлюзах системы Internet. Датаграммы направляются с одного </p>
<p>модуля Internet на другой через конкретные компьютерные сети, основанные </p>
<p>на интерпретации Internet адресов. Таким образом, одним из важных </p>
<p>механизмов протокола Internet является Internet адрес.</p>
<p> &nbsp; При передаче сообщений с одного Internet модуля на другой датаграммы </p>
<p>могут нуждаться в прохождении через сети, для которых максимальный </p>
<p>размер пакета меньше, чем размер датаграммы. Чтобы преодолеть эту </p>
<p>сложность, в протокол Internet включен механизм фрагментации.</p>
<p> &nbsp; Адресация. В протоколе сделано разграничение между именами, адресами </p>
<p>и маршрутами [4]. Имя показывает искомый нами объект. Адрес показывает </p>
<p>его местонахождение. Internet имеет дело с адресами. Перевод имен в </p>
<p>адреса является задачей протоколов более высокого уровня (прикладных </p>
<p>программ или протоколов передачи синхронизации с хоста на хост). </p>
<p>Собственно модуль Internet осуществляет отображение адресов Internet на </p>
<p>адреса локальной сети. Создание карты адресов локальной сети для </p>
<p>получения маршрутов - задача процедур более низкого уровня (процедур </p>
<p>локальной сети или шлюзов). </p>
<p> &nbsp; Адреса имеют фиксированную длину четыре октета (32 бита). Адрес </p>
<p>начинается с сетевого номера, за которым следует локальный адрес </p>
<p>(называемый полем остатка "rest"). Существуют три формата или класса </p>
<p>адресов Internet. В классе a самый старший бит нулевой. Следующие 7 бит </p>
<p>определяют сеть. а последние 24 бита - локальный адрес. В классе b самые </p>
<p>старшие два бита равны соответственно 1 и 0, следующие 14 бит определяют </p>
<p>сеть, а последние 16 бит - локальный адрес. В классе c три самых старших </p>
<p>бита равны соответственно 1,1 и 0, следующие 21 бит определяют сеть, а </p>
<p>последние 8 бит - локальный адрес.</p>
<p> &nbsp; При отображении карты Internet адресов на адреса локальной сети </p>
<p>следует соблюдать осторожность. Единичный хост-компьютер должен уметь </p>
<p>работать так, как если бы на его месте существовало несколько отдельных </p>
<p>хост-компьютеров для использования нескольких адресов Internet. </p>
<p>Некоторые хост-компьютеры будут также иметь несколько физических </p>
<p>интерфейсов (multi-homing). </p>
<p> &nbsp; Таким образом, следует обеспечить каждый хост-компьютер несколькими </p>
<p>физическими сетевыми интерфейсами, имеющими по несколько логических </p>
<p>адресов Internet. </p>
<p> &nbsp; Примеры построения карты адресов можно найти в документе "Address </p>
<p>Mapping" [5].</p>
<p> &nbsp; Фрагментация. Фрагментация Internet датаграммы необходима, когда эта </p>
<p>датаграмма возникает в локальной сети, позволяющей работать с пакетами </p>
<p>большого размера, и затем должна пройти к получателю через другую </p>
<p>локальную сеть, которая ограничивает пакеты меньшим размером.</p>
<p> &nbsp; Internet датаграмма может быть помечена как нефрагментируемая. Любая </p>
<p>Internet датаграмма, помеченная таким образом, не может быть </p>
<p>фрагментирована модулем Internet ни при каких условиях. Если же Internet </p>
<p>датаграмма, помеченная как нефрагментируемая, тем не менее не может </p>
<p>достигнуть получателя без фрагментации, то вместо этого она будет </p>
<p>разрушена.</p>
<p> &nbsp; Фрагментация, перенос и сборка в локальной сети, невидимые для модуля </p>
<p>Internet протокола, называются внутрисетевой фрагментацией и могут быть </p>
<p>всегда использованы [6].</p>
<p> &nbsp; Необходимо, чтобы Internet процедуры фрагментации и сборки могли </p>
<p>разбивать датаграмму на почти любое количество частей, которые </p>
<p>впоследствии могли бы быть вновь собраны. Получатель фрагмента </p>
<p>использует поле идентификации для того, чтобы быть убежденным в том, что </p>
<p>фрагменты различных датаграмм не будут перепутаны. Поле смещения </p>
<p>фрагмента сообщает получателю положение фрагмента в исходной датаграмме. </p>
<p>Смещение фрагмента и длина определяют кусок исходной датаграммы, </p>
<p>принесенный этим фрагментом. Флаг "more fragments" показывает </p>
<p>(посредством перезагрузки) появление последнего фрагмента. Эти поля дают </p>
<p>достаточное количество информации для сборки датаграмм. </p>
<p> &nbsp; Поле идентификации позволяет отличить фрагменты одной датаграммы от </p>
<p>фрагментов другой. Модуль Internet, отправляющий Internet датаграмму, </p>
<p>устанавливает в поле идентификации значение, которое должно быть </p>
<p>уникальным для данной пары отправитель - получатель, а также время, в </p>
<p>течении которого датаграмма будет активна в системе Internet. Модуль </p>
<p>протокола, отправляющий нерасчлененную датаграмму, устанавливает в нуль </p>
<p>флаг "more fragments" и смещение во фрагменте. </p>
<p> &nbsp; Чтобы расчленить большую Internet датаграмму, модуль протокола </p>
<p>Internet (например, шлюз), создает две новые Intenet датаграммы и </p>
<p>копирует содержимое полей Internet заголовка из большой датаграммы в оба </p>
<p>новых Internet заголовка. Данные из старой датаграммы делятся на две </p>
<p>части по границе на очередном восьмом октете (64 бита). Полученная таким </p>
<p>образом вторая часть может быть кратна 8 октетам, а может и не быть, но </p>
<p>первая часть кратна всегда. Заказывается количество блоков первой части </p>
<p>NFB (количество блоков фрагмента). Первая часть данных помещается в </p>
<p>первую новую Internet датаграмму, в поле общей длины помещается длина </p>
<p>первой датаграммы. Флаг "more fragments" устанавливается в единицу. </p>
<p>Вторая часть данных помещается во вторую новообразованную Internet </p>
<p>датаграмму, в поле общей длины заносится длина второй датаграммы. В поле </p>
<p>смещения фрагмента во второй Internet датаграмме устанавливается </p>
<p>значение такого же поля в исходной большой датаграмме, увеличенное на </p>
<p>NFB.</p>
<p> &nbsp; Эта процедура может быть обобщена на случай многократного расщепления </p>
<p>исходной датаграммы.</p>
<p> &nbsp; Чтобы собрать фрагменты Internet датаграммы, модуль протокола </p>
<p>Internet (например, модуль на хост-компьютере) объединяет Internet </p>
<p>датаграммы, имеющие одинаковые значения в полях идентификатора, </p>
<p>отправителя, получателя и протокола. Собственно объединение заключается </p>
<p>в помещении данных из каждого фрагмента в позицию, указанную в заголовке </p>
<p>Internet пакета в поле "fragment offset". Первый фрагмент будет иметь в </p>
<p>поле "fragment offset" нулевое значение, а последний фрагмент будет </p>
<p>иметь флаг "more fragments", вновь установленный в нуль.</p>
<p>2.4 Шлюзы</p>
<p> &nbsp; С помощью шлюзов протокол Internet осуществляет передачу датаграмм </p>
<p>между сетями. Шлюзы также поддерживают протокол шлюз-шлюз (GGR) [7] для </p>
<p>координации маршрутизации и передачи другой управляющей информации для </p>
<p>протокола Internet.</p>
<p> &nbsp; Нет нужды держать на шлюзе протоколы более высокого уровня, а функции </p>
<p>GGP добавляются к возможностям IP модуля.</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; +--------------------------------+</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; | Internet протокол &amp; ICMP &amp; GGP |&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; +--------------------------------+</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; |&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; |</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; +----------------+&nbsp; +----------------+</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; | локальная сеть |&nbsp; | локальная сеть |</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; +----------------+&nbsp; +----------------+</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Рис. 3&nbsp;&nbsp; Протоколы шлюзов</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 3. Специфиация &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </p>
<p>3.1 Формат заголовка Internet</p>
<p> &nbsp; Ниже приведена полная схема полей заголовка Internet</p>
<p>+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+</p>
<p>|Version|&nbsp; IHL&nbsp; |Type of Service|&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Total Length&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; |</p>
<p>+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+</p>
<p>|&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Identification&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; |Flags|&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Fragment Offset&nbsp;&nbsp;&nbsp; |</p>
<p>+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+</p>
<p>|&nbsp; Time to Live |&nbsp;&nbsp;&nbsp; Protocol&nbsp;&nbsp; |&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Header Checksum&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; |</p>
<p>+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+</p>
<p>|&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Source Address&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; |</p>
<p>+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+</p>
<p>|&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Destination Address&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; |</p>
<p>+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+</p>
<p>|&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Options&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; |&nbsp;&nbsp;&nbsp; Padding&nbsp;&nbsp;&nbsp; |</p>
<p>+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Рис. 4 Пример заголовка Internet датаграммы &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </p>
<p>Заметим, что каждая позиция соответствует одному биту.</p>
<p>Version (версия) 4 бита</p>
<p> &nbsp; Поле версии показывает формат заголовка Internet. Данный документ &nbsp;&nbsp; </p>
<p> &nbsp; описывает версию 4. </p>
<p>IHL (длина Internet заголовка) 4 бита</p>
<p> &nbsp; Длина Internet заголовка измеряется в словах по 32 бита каждый и </p>
<p> &nbsp; указывает на начало поля данных. Заметим, что корректный заголовок </p>
<p> &nbsp; может иметь минимальный размер 5 слов. </p>
<p>Type of Service (тип сервиса) 8 бит</p>
<p> &nbsp; Тип сервиса определяет с помощью неких абстрактных параметров тип </p>
<p> &nbsp; требуемого обслуживания. Эти параметры должны использоваться для </p>
<p> &nbsp; управления выбором реальных рабочих характеристик при передаче </p>
<p> &nbsp; датаграммы через конкретную сеть. Некоторые сети осуществляют </p>
<p> &nbsp; обслуживание с приоритетом, которое неким образом дает преимущество </p>
<p> &nbsp; для продвижения данной датаграммы по сравнению со всеми остальными. </p>
<p> &nbsp; Реально выбор осуществляется между тремя альтернативами: малой </p>
<p> &nbsp; задержкой, высокой достоверностью и высокой пропускной способностью.</p>
<p> &nbsp; биты 0-2&nbsp; приоритет</p>
<p> &nbsp; бит 3&nbsp;&nbsp;&nbsp;&nbsp; 0 - нормальная задержка, 1 - малая задержка</p>
<p> &nbsp; бит 4&nbsp;&nbsp;&nbsp;&nbsp; 0 - нормальная пропускная способность, </p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 1 - высокая пропускная способность</p>
<p> &nbsp; бит 5&nbsp;&nbsp;&nbsp;&nbsp; 0 -&nbsp; обычная достоверность, 1 - высокая достоверность</p>
<p> &nbsp; биты 6-7 зарезервированы</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp; 0&nbsp;&nbsp;&nbsp;&nbsp; 1&nbsp;&nbsp;&nbsp;&nbsp; 2&nbsp;&nbsp;&nbsp;&nbsp; 3&nbsp;&nbsp;&nbsp;&nbsp; 4&nbsp;&nbsp;&nbsp;&nbsp; 5&nbsp;&nbsp;&nbsp;&nbsp; 6&nbsp;&nbsp;&nbsp;&nbsp; 7</p>
<p> &nbsp; +-----+-----+-----+-----+-----+-----+-----+-----+</p>
<p> &nbsp; |&nbsp;&nbsp;&nbsp;&nbsp; приоритет &nbsp; |&nbsp; D&nbsp; |&nbsp; T&nbsp; |&nbsp; R&nbsp; |&nbsp; 0&nbsp; |&nbsp; 0&nbsp; |</p>
<p> &nbsp; +-----+-----+-----+-----+-----+-----+-----+-----+</p>
<p> &nbsp; Приоритет</p>
<p> &nbsp; 111 - управление сетью</p>
<p> &nbsp; 110 - межсетевое управление </p>
<p> &nbsp; 101 - CRITIC/ECP</p>
<p> &nbsp; 100 - более, чем мгновенно</p>
<p> &nbsp; 011 - мгновенно</p>
<p> &nbsp; 010 - немедленно</p>
<p> &nbsp; 001 - приоритетно</p>
<p> &nbsp; 000 - обычный маршрут</p>
<p> &nbsp; Использование индикации задержки, пропускной способности и </p>
<p> &nbsp; достоверности может, в некотором смысле, увеличить стоимость </p>
<p> &nbsp; обслуживания. Во многих сетях улучшение одного из этих параметров </p>
<p> &nbsp; связано с ухудшением другого. Исключения, когда имело бы смысл </p>
<p> &nbsp; устанавливать два из этих трех параметров, очень редки.</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp; Тип обслуживания используется для указания типа обработки </p>
<p> &nbsp; датаграммы при ее прохождении через систему Internet. Примеры </p>
<p> &nbsp; отображения типа обслуживания в протоколе Internet на реальные </p>
<p> &nbsp; услуги, предоставляемые такими сетями, как AUTODIN II, ARPANET, </p>
<p> &nbsp; SATNET и PRNET даны в документе "Service Mapping" [8]. Значение </p>
<p> &nbsp; "управление сетью" следует присваивать приоритету только для </p>
<p> &nbsp; использования внутри локальной сети. Управление и реальное </p>
<p> &nbsp; использование этого аргумента должно находиться в согласии с каждой </p>
<p> &nbsp; применяющей его сетью. Аргумент "межсетевое управление" предназначен </p>
<p> &nbsp; только для использования шлюзами, берущими на себя управление. Если </p>
<p> &nbsp; вышеописанные аргументы приоритета находят применение в какой-либо </p>
<p> &nbsp; сети, то это означает, что данная сеть может управлять приемом и </p>
<p> &nbsp; использованием этих аргументов.</p>
<p>Total Length (общая длина) 16 бит</p>
<p> &nbsp; Общая длина - это длина датаграммы, измеренная в октетах, включая </p>
<p> &nbsp; Internet заголовок и поле данных. Это поле может задавать длину </p>
<p> &nbsp; датаграммы вплоть до 65535 октетов. В большинстве хост-компьютеров и </p>
<p> &nbsp; сетей столь большие датаграммы не используются. Все хосты должны быть </p>
<p> &nbsp; готовы принимать датаграммы вплоть до 576 октетов длиной (приходят ли </p>
<p> &nbsp; они целиком или по фрагментам). Хостам рекомендуется отправлять </p>
<p> &nbsp; датаграммы размером более чем 576 октетов, только если они уверены, </p>
<p> &nbsp; что принимающий хост готов обслуживать датаграммы повышенного </p>
<p> &nbsp; размера. </p>
<p> &nbsp;&nbsp;&nbsp;&nbsp; Значение 576 выбрано с тем, чтобы соответсвующим образом </p>
<p> &nbsp; ограниченный блок данных передавался вместе с требуемой информацией в </p>
<p> &nbsp; заголовке. Например, этот размер позволяет заполнять датаграмму полем </p>
<p> &nbsp; данных размером в 512 октетов и заголовком в 64 октета. Наибольший </p>
<p> &nbsp; Internet заголовок занимает 60 октетов, а его типичный размер </p>
<p> &nbsp; составляет всего 20 октетов, что оставляет место под заголовки </p>
<p> &nbsp; протоколов более высокого уровня. </p>
<p>Identification (идентификатор) 16 бит</p>
<p> &nbsp; Идентификатор устанавливается отправителеим для сборки фрагментов </p>
<p> &nbsp; какой-либо датаграммы.</p>
<p>Flags (различные управляющие флаги) 16 бит</p>
<p> &nbsp; бит 0&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; зарезервирован, должен быть нуль</p>
<p> &nbsp; бит 1 (DF) 0 - возможно фрагментирование, 1 - запрет фрагментации</p>
<p> &nbsp; бит 2 (MF) 0 - последний фрагмент, 1 - будут еще фрагменты</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp; 0&nbsp;&nbsp;&nbsp; 1&nbsp;&nbsp;&nbsp; 2</p>
<p> &nbsp; +----+----+----+</p>
<p> &nbsp; |&nbsp; 0 | DF | MF |</p>
<p> &nbsp; +----+----+----+</p>
<p>Fragment Offset (смещение фрагмента) 13 бит</p>
<p> &nbsp; Это поле показывает, где в датаграмме находится этот фрагмент. </p>
<p> &nbsp; Смещение фрагмента изменяется порциями по 8 октет (64 бита). Первый </p>
<p> &nbsp; фрагмент имеет смещение нуль.</p>
<p>Time to Live (Время жизни) 8 бит</p>
<p> &nbsp; Это поле показывает максимальное время, в течении которого датаграмме </p>
<p> &nbsp; позволено находиться в системе Internet. Если это поле имеет значение </p>
<p> &nbsp; нуль, то датаграмма должна быть разрушена. Значение этого поля </p>
<p> &nbsp; изменяется при обработке заголовка Internet. Время измеряется в </p>
<p> &nbsp; секундах. Однако, поскольку каждый модуль, обрабатывающий датаграмму, </p>
<p> &nbsp; должен уменьшать значение поля TTL по крайней мере на единицу, даже </p>
<p> &nbsp; если он обрабатываетт эту датаграмму менне, чем за секунду, то поле </p>
<p> &nbsp; TTL следует понимать как максимальный интервал времени, в течении </p>
<p> &nbsp; которого датаграмма может сущенствовать. Внимание следует обратить на </p>
<p> &nbsp; разрушение датаграмм, не могущих достигнуть получателя, а также на </p>
<p> &nbsp; ограничение времени жизни датаграммы.</p>
<p>Protocol (Протокол) 8 бит</p>
<p> &nbsp; Это поле показывает, какой протокол следующего уровня использует </p>
<p> &nbsp; данные из Internet датаграммы. Значения для различных протоколов </p>
<p> &nbsp; приводятся в документе "Assigned Numbers" [9].</p>
<p>Header Checksum (Контрольная сумма заголовка) 16 бит</p>
<p> &nbsp; Поскольку некоторые поля заголовка меняют свое значение (например, </p>
<p> &nbsp; время жизни), это значение проверяется и повторно рассчитывается при </p>
<p> &nbsp; каждой обработке Internet заголовка.</p>
<p> &nbsp; Алгоритм контрольной суммы следующий:</p>
<p> &nbsp;&nbsp;&nbsp; Поле контрольной суммы - это 16 бит, дополняющие биты в сумме всех </p>
<p> &nbsp;&nbsp;&nbsp; 16 битовых слов заголовка. Для вычисления контрольной суммы </p>
<p> &nbsp;&nbsp;&nbsp; значение этого поля устанавливается в нуль.</p>
<p> &nbsp; Контрольную сумму легко рассчитать и опытным путем доказать ее </p>
<p> &nbsp; адекватность, однако это временная мера и должна быть заменена CRC </p>
<p> &nbsp; процедурой в зависимости от дальнейшего опыта.</p>
<p>Source Address (адрес отправителя) 32 бита (см. часть 3.2)</p>
<p>Destination Address (адрес получателя) 32 бита (см. часть 3.2)</p>
<p>Options (опции)&nbsp;&nbsp;&nbsp; поле переменной длины</p>
<p> &nbsp; Опции могут появиться в датаграммах, а могут и не появляться. Они </p>
<p> &nbsp; должны поддерживаться всеми Internet модулями (хостами и шлюзами). </p>
<p> &nbsp; Не обязательно каждая конкретная датаграмма несет опции, но нести их </p>
<p> &nbsp; все же может. </p>
<p> &nbsp; В некоторых приложениях опция секретности должна присутствовать во </p>
<p> &nbsp; всех датаграммах.</p>
<p> &nbsp; Поле опций не имеет постояннойц длины. Опций может не быть, а может </p>
<p> &nbsp; быть несколько. Существуют два формата опции:</p>
<p> &nbsp; - единичный октет с указанием типа опции</p>
<p> &nbsp; - единичный октет с указанием типа опции, октет для указания длины </p>
<p> &nbsp; опции, и, наконец, октеты собственно данных.</p>
<p> &nbsp; Октет длины поля учитывает октет типа опции, сам себя и октеты с </p>
<p> &nbsp; данными для опции. </p>
<p> &nbsp; Считается, что октет типа опции состоит из трех полей:</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp; 1 бит &nbsp; флаг копирования</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp; 2 бита  класс опции</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp; 5 бит &nbsp; номер опции</p>
<p> &nbsp; Флаг копирования показывает, что эта опция копируется во все </p>
<p> &nbsp; фрагменты при фрагментации.</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp; 0 - не копируется</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp; 1 - копируется</p>
<p> &nbsp; Классы опции</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp; 0 - управление</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp; 1 - резервировано</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp; 2 - отладка и измерения</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp; 3 - резервировано</p>
<p> &nbsp; Определены следующие опции Internet</p>
<p> &nbsp; класс номер длина описание</p>
<p> &nbsp;&nbsp;&nbsp; 0&nbsp;&nbsp;&nbsp;&nbsp; 0&nbsp;&nbsp;&nbsp;&nbsp; -&nbsp;&nbsp; Конец списка опций. Эта опция занимает лишь один </p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; октет, октет длины отсутствует.</p>
<p> &nbsp;&nbsp;&nbsp; 0&nbsp;&nbsp;&nbsp;&nbsp; 1&nbsp;&nbsp;&nbsp;&nbsp; -&nbsp;&nbsp; Нет операции. Эта опция занимает лишь один октет. </p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Не имеет октета длины.</p>
<p> &nbsp;&nbsp;&nbsp; 0&nbsp;&nbsp;&nbsp;&nbsp; 2&nbsp;&nbsp;&nbsp; 11&nbsp;&nbsp; Безопасность. Используется для поддержания </p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; безопасности, изоляции, разделения на группы </p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; пользователей (TCC), обработки кодов ограничения, </p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; соответсвующих DOD требованиям.</p>
<p> &nbsp;&nbsp;&nbsp; 0&nbsp;&nbsp;&nbsp;&nbsp; 3&nbsp;&nbsp; перем Потеря маршрута отправителя. Используется для </p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; передачи Internet датаграммы, основанной на </p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; имеющейся у отправителя информации</p>
<p> &nbsp;&nbsp;&nbsp; 0&nbsp;&nbsp;&nbsp;&nbsp; 9&nbsp;&nbsp; перем Определение маршрута отправителя. Используется для </p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; передачи Internet датаграммы, основанной на </p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; имеющейся у отправителя информации</p>
<p> &nbsp;&nbsp;&nbsp; 0&nbsp;&nbsp;&nbsp;&nbsp; 7&nbsp;&nbsp; перем Запись маршрута. Используется для отслеживания </p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; проходимого Internet датаграммой маршрута.</p>
<p> &nbsp;&nbsp;&nbsp; 0&nbsp;&nbsp;&nbsp;&nbsp; 8&nbsp;&nbsp;&nbsp;&nbsp; 4&nbsp;&nbsp; Идентификатор маршрута. Используется для поддержки </p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; идентификации потока.</p>
<p> &nbsp;&nbsp;&nbsp; 2&nbsp;&nbsp;&nbsp;&nbsp; 4&nbsp;&nbsp; перем Временной штамп Internet.</p>
<p> &nbsp; Отдельные описания опций</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; +--------+</p>
<p> &nbsp; Тип 0&nbsp;&nbsp; |00000000| End of Option List&nbsp;&nbsp; (конец списка опций)</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; +--------+</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp; Эта опция обозначает конец списка опций. Он может не совпадать с </p>
<p> &nbsp;&nbsp;&nbsp;&nbsp; окончанием Internet заголовка, обозначаемым полем Internet header </p>
<p> &nbsp;&nbsp;&nbsp;&nbsp; length. Эта опция используется после всех опций, но не после </p>
<p> &nbsp;&nbsp;&nbsp;&nbsp; каждой. Она необходима только в том случае, если конец списка </p>
<p> &nbsp;&nbsp;&nbsp;&nbsp; опций не совпал с окончанием Internet заголовка.</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp; Может быть скопирован, внесен или удален при фрагментации, или по </p>
<p> &nbsp;&nbsp;&nbsp;&nbsp; какой-либо другой причине.</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; +--------+</p>
<p> &nbsp; Тип 1&nbsp;&nbsp; |00000001| No operation&nbsp; (нет действий)</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; +--------+</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp; Эта опция может быть использована между другими опциями. Ее целью </p>
<p> &nbsp;&nbsp;&nbsp;&nbsp; может служить, к примеру, выравнивание очередной опции по 32- </p>
<p> &nbsp;&nbsp;&nbsp;&nbsp; битной границе. Может быть скопирована, внесена или удалена при </p>
<p> &nbsp;&nbsp;&nbsp;&nbsp; фрагментации и по любой другой причине.</p>
<p> &nbsp; Тип 130&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Security&nbsp; (безопасность)</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp; Эта опция дает способ хост-компьютерам отправлять параметры, </p>
<p> &nbsp;&nbsp;&nbsp;&nbsp; связанные с безопасностью, закрытостью, введением ограничений и </p>
<p> &nbsp;&nbsp;&nbsp;&nbsp; параметрами TCC (закрытой группой пользователей). Формат этой </p>
<p> &nbsp;&nbsp;&nbsp;&nbsp; опции следующий:&nbsp; (длина 11 октетов)</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp; +--------+--------+---///---+---///---+---///---+---///----+</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp; |10000010|00001011|SSS...SSS|CCC...CCC|HHH...HHH|&nbsp;&nbsp; TCC&nbsp;&nbsp;&nbsp; |</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp; +--------+--------+---///---+---///---+---///---+---///----+</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp; Поле S (security) 16 бит</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Указывает один из 16 уровней безопасности (восемь из которых </p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; зарезервировано).</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 00000000 00000000 - неклассифицировано</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 11110001 00110101 - конфиденциальный</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 01111000 10011010 - EFTO</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 10111100 01001101 - MMMM</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 01011110 00100110 - PROG</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 10101111 00010011 - ограниченный</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 11010111 10001000 - секретный</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 01101011 11000101 - особо секретный</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 00110101 11100010 - резервировано</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 10011010 11110001 - резервировано</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 01001101 01111000 - резервировано</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 00100100 10111101 - резервировано</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 00010011 01011110 - резервировано</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 10001001 10101111 - резервировано</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 11000100 11010110 - резервировано</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 11100010 01101011 - резервировано</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp; Поле C (compartments) 16 бит</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Нулевое значение во всех позициях используется когда передача </p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; информации не ограничена. Остальные значения для этого поля </p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; можно получить от Секретного Оборонного Агенства.</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp; Поле H (введение ограничений) 16 бит</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Значения для управления и внесения меток являются буквенно- </p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; цифровыми диграммами и опредены в документе DIAM 65-19 </p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; "Standard Security Markings".</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp; Поле TCC (поле управления переносом) 24 бита</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Дает средства для отслеживания процесса отделения, его значения </p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; контролируются группами заинтересованных подписчиков. Значения </p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; TCC имеют три поля для записей и могут быть получены из </p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; документа HQ DCA Code 530.</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp; Рассматриваемый тип должен копироваться при фрагментации. Эта </p>
<p> &nbsp;&nbsp;&nbsp;&nbsp; опция появляется в датаграмме не более одного раза.</p>
<p> &nbsp; Тип 131&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Loose Source and Record Route</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; (Потеря отправителя и запись маршрута)</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp; +--------+--------+---------+------- // ------+</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp; |10000011| длина  |указатель|данные о маршруте|</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp; +--------+--------+---------+------- // ------+</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp; Опция потери отправителя и записи маршрута (LSRR) обеспечивает </p>
<p> &nbsp;&nbsp;&nbsp;&nbsp; средства, позволяющие отправителю Internet датаграммы передавать </p>
<p> &nbsp;&nbsp;&nbsp;&nbsp; информацию, используемую шлюзами при передаче датаграмм по </p>
<p> &nbsp;&nbsp;&nbsp;&nbsp; назначению, а также записывать информацию о маршруте.</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp; Опция начинается с кода типа. Второй октет - октет длины, которая </p>
<p> &nbsp;&nbsp;&nbsp;&nbsp; учитывает код типа опции и сам себя, а также октет указателя. </p>
<p> &nbsp;&nbsp;&nbsp;&nbsp; Третий октет является указателем на данные о маршруте, он </p>
<p> &nbsp;&nbsp;&nbsp;&nbsp; определяет октет, с которого начинается следующий адрес </p>
<p> &nbsp;&nbsp;&nbsp;&nbsp; отправителя, подлежащий обработке. Указатель отсчитывается от </p>
<p> &nbsp;&nbsp;&nbsp;&nbsp; начала рассматриваемой опции, а его наименьшее допустимое значение </p>
<p> &nbsp;&nbsp;&nbsp;&nbsp; - 4.</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp; Данные о маршруте состоят из ряда Internet адресов. Каждый </p>
<p> &nbsp;&nbsp;&nbsp;&nbsp; Internet адрес - это 32 бита или 4 октета. Если указатель </p>
<p> &nbsp;&nbsp;&nbsp;&nbsp; превышает длину, то маршрут отправителя пуст (поле с записями </p>
<p> &nbsp;&nbsp;&nbsp;&nbsp; маршрута заполнено), а маршрутизация должна основываться на </p>
<p> &nbsp;&nbsp;&nbsp;&nbsp; значениях поля с адресом получателя.</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp; Если адрес, записанный в поле адреса получателя, был достигнут, а </p>
<p> &nbsp;&nbsp;&nbsp;&nbsp; указатель не превысил длину, то следующий адрес в маршруте </p>
<p> &nbsp;&nbsp;&nbsp;&nbsp; отправителя замещает адрес в поле с адресом получателя. Записанный </p>
<p> &nbsp;&nbsp;&nbsp;&nbsp; адрес маршрута заменяет только что использованный адрес </p>
<p> &nbsp;&nbsp;&nbsp;&nbsp; отправителя, а указатель увеличивается на 4.</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp; Записанный адрес маршрута является собственным Internet адресом </p>
<p> &nbsp;&nbsp;&nbsp;&nbsp; Internet модуля, известным во внешнем окружении, куда эта </p>
<p> &nbsp;&nbsp;&nbsp;&nbsp; датаграмма направляется. </p>
<p> &nbsp;&nbsp;&nbsp;&nbsp; Эта процедура замещения исходного маршрута записанным маршрутом </p>
<p> &nbsp;&nbsp;&nbsp;&nbsp; (хотя при обратном порядке он должен использоваться как маршрут </p>
<p> &nbsp;&nbsp;&nbsp;&nbsp; отправителя) означает, что данная опция (а также и весь IP </p>
<p> &nbsp;&nbsp;&nbsp;&nbsp; заголовок) сохраняет постоянный размер при прохождении датаграммы </p>
<p> &nbsp;&nbsp;&nbsp;&nbsp; по Internet системе.</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp; Эта опция называется потерей маршрута отправителя (loose source </p>
<p> &nbsp;&nbsp;&nbsp;&nbsp; route), поскольку шлюз или IP хост могут использовать любые </p>
<p> &nbsp;&nbsp;&nbsp;&nbsp; маршруты через любое количество других промежуточных шлюзов для </p>
<p> &nbsp;&nbsp;&nbsp;&nbsp; достижения следующего адреса в рассматриваемом маршруте. При </p>
<p> &nbsp;&nbsp;&nbsp;&nbsp; фрагментации опция должна копироваться. В датаграмме она должна </p>
<p> &nbsp;&nbsp;&nbsp;&nbsp; появляться не более одного раза.</p>
<p> &nbsp; Тип 137&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Strict Source and Record Route</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; (Уточнить отправитель и записать маршрут)</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp; +--------+--------+---------+------- // --------+</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp; |10001001| длина  |указатель| данные о маршруте |</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp; +--------+--------+---------+------- // --------+</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp; Опция "уточнить отправитель и записать маршрут" (SSRR) дает </p>
<p> &nbsp;&nbsp;&nbsp;&nbsp; средства отправителю Internet датаграммы для поддержания </p>
<p> &nbsp;&nbsp;&nbsp;&nbsp; информации о маршрутизации, которая должна использоваться шлюзами </p>
<p> &nbsp;&nbsp;&nbsp;&nbsp; при передаче датаграммы по назначению, а также для записи этой </p>
<p> &nbsp;&nbsp;&nbsp;&nbsp; информации.</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Опция начинается с кода типа. Второй октет - длина опции, </p>
<p> &nbsp;&nbsp;&nbsp;&nbsp; которая учитывает код типа опции и октет длины, октет указателя (3 </p>
<p> &nbsp;&nbsp;&nbsp;&nbsp; октета с данными о маршруте). Третий октет является указателем на </p>
<p> &nbsp;&nbsp;&nbsp;&nbsp; данные маршрута, определяющим октет, с которого начинается </p>
<p> &nbsp;&nbsp;&nbsp;&nbsp; следующий адрес отправителя, подлежащий обработке. Указатель </p>
<p> &nbsp;&nbsp;&nbsp;&nbsp; отсчитывается с начала этой опции, а наименьшее допустимое </p>
<p> &nbsp;&nbsp;&nbsp;&nbsp; значение указателя - 4.</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Данные о маршруте состоят из серии Internet адресов. Каждый </p>
<p> &nbsp;&nbsp;&nbsp;&nbsp; Internet адрес - это 32 бита или 4 октета. Если указатель </p>
<p> &nbsp;&nbsp;&nbsp;&nbsp; превышает длину, то маршрут отправителя пуст (записываемый маршрут </p>
<p> &nbsp;&nbsp;&nbsp;&nbsp; полон), а маршрутизация основывается на значении поля с адресом </p>
<p> &nbsp;&nbsp;&nbsp;&nbsp; получателя.</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Если адрес в поле адреса получателя был достигнут, а указатель </p>
<p> &nbsp;&nbsp;&nbsp;&nbsp; не превышает длины, то следующий адрес в маршруте отправителя </p>
<p> &nbsp;&nbsp;&nbsp;&nbsp; замещает адрес в поле с адресом получателя, а записанный адрес </p>
<p> &nbsp;&nbsp;&nbsp;&nbsp; маршрута замещает только что использованный адоес отправителя, </p>
<p> &nbsp;&nbsp;&nbsp;&nbsp; указатель увеличивается на 4.</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Записанный адрес маршрута - это собственный Internet - адрес </p>
<p> &nbsp;&nbsp;&nbsp;&nbsp; Internet - модуля, как он был бы распознан во внешней среде, куда </p>
<p> &nbsp;&nbsp;&nbsp;&nbsp; эта датаграмма направляется.</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Эта процедура замещения маршрута отправителя записанным </p>
<p> &nbsp;&nbsp;&nbsp;&nbsp; маршрутом (хотя в обратном порядке он должен использоваться как </p>
<p> &nbsp;&nbsp;&nbsp;&nbsp; маршрут отправителя) означает, что опция (и весь IP заголовок) </p>
<p> &nbsp;&nbsp;&nbsp;&nbsp; сохраняет постоянный размер при прохождении датаграммы через </p>
<p> &nbsp;&nbsp;&nbsp;&nbsp; Internet систему.</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Эта опция является точным маршрутом отправителя, поскольку шлюз </p>
<p> &nbsp;&nbsp;&nbsp;&nbsp; или IP хост должен посылать данную датаграмму непосредственно на </p>
<p> &nbsp;&nbsp;&nbsp;&nbsp; следующий адрес в маршруте отправителя через напрямую соединенную </p>
<p> &nbsp;&nbsp;&nbsp;&nbsp; сеть, на адрес, показывающий следующий шлюз или хост, указанный в </p>
<p> &nbsp;&nbsp;&nbsp;&nbsp; маршруте.</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Опция должна копироваться при фрагментации. Появляется не более </p>
<p> &nbsp;&nbsp;&nbsp;&nbsp; одного раза в датаграмме.</p>
<p>Тип 7&nbsp; Record Route&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; (Записать маршрут)</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp; +--------+--------+---------+------- // --------+</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp; |00000111| длина  |указатель| данные о маршруте |</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp; +--------+--------+---------+------- // --------+</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Опция записи маршрута дает средства для записи маршрута </p>
<p> &nbsp;&nbsp;&nbsp;&nbsp; Internet датаграммы. </p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Опция начинается с кода типа. Второй октет определяет длину </p>
<p> &nbsp;&nbsp;&nbsp;&nbsp; опции, которая учитывает код типа опции, сам себя, октет указателя </p>
<p> &nbsp;&nbsp;&nbsp;&nbsp; и длину трех октетов с данными о маршруте. Третий октет является </p>
<p> &nbsp;&nbsp;&nbsp;&nbsp; указателем на данные маршрута. Указатель определяет октет, с </p>
<p> &nbsp;&nbsp;&nbsp;&nbsp; которого начинается следующее поле для размещения адреса маршрута. </p>
<p> &nbsp;&nbsp;&nbsp;&nbsp; Указатель отсчитывается от начала рассматриваемой опции, а его </p>
<p> &nbsp;&nbsp;&nbsp;&nbsp; наименьшее допустимое значение - 4.</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Записываемый маршрут состоит из серии Internet адресов. Каждый </p>
<p> &nbsp;&nbsp;&nbsp;&nbsp; Internet адрес - это 32 бита или 4 октета. Если указатель больше, </p>
<p> &nbsp;&nbsp;&nbsp;&nbsp; чем длина опции, то поле с записываемым маршрутом заполнено. Хост </p>
<p> &nbsp;&nbsp;&nbsp;&nbsp; - компьютер, создающий эту опцию, должен зарезервировать поле с </p>
<p> &nbsp;&nbsp;&nbsp;&nbsp; данными о маршруте и достаточным размером, с тем, чтобы оно </p>
<p> &nbsp;&nbsp;&nbsp;&nbsp; вместило все ожидаемые адреса. Размер этой опции не изменяется при </p>
<p> &nbsp;&nbsp;&nbsp;&nbsp; добавлении адресов. Первоначальное содержимое поля под данные о </p>
<p> &nbsp;&nbsp;&nbsp;&nbsp; маршруте должно быть нулевым.</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Когда Internet модуль направляет датаграмму, он проверяет ее на </p>
<p> &nbsp;&nbsp;&nbsp;&nbsp; присутствие рассматриваемой опции с записываемым маршрутом. Если </p>
<p> &nbsp;&nbsp;&nbsp;&nbsp; она присутствует, то он вставляет свой собственный Internet адрес </p>
<p> &nbsp;&nbsp;&nbsp;&nbsp; в качестве распознанного во внешней среде, куда эта датаграмма </p>
<p> &nbsp;&nbsp;&nbsp;&nbsp; направлена. Вставка осуществляется в опцию записи маршрута, в то </p>
<p> &nbsp;&nbsp;&nbsp;&nbsp; место, на которое указывает октет указателя. Указатель затем </p>
<p> &nbsp;&nbsp;&nbsp;&nbsp; увеличивается на 4.</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Если поле с данными о маршруте уже заполнено (указатель </p>
<p> &nbsp;&nbsp;&nbsp;&nbsp; превышает длину), то датаграмма направляется без вставки адреса в </p>
<p> &nbsp;&nbsp;&nbsp;&nbsp; опцию заполняемого маршрута. Если имеется некоторое пространство, </p>
<p> &nbsp;&nbsp;&nbsp;&nbsp; но недостаточное для вставки полного адреса, то исходная </p>
<p> &nbsp;&nbsp;&nbsp;&nbsp; датаграмма считается ошибочной и разрушается. И в том, и в другом </p>
<p> &nbsp;&nbsp;&nbsp;&nbsp; случае на хост-отправитель напрвляется сообщение о проблеме с ICMP </p>
<p> &nbsp;&nbsp;&nbsp;&nbsp; параметром [3].</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; При фрагментации не копируется, присутствует лишь в первом </p>
<p> &nbsp;&nbsp;&nbsp;&nbsp; фрагменте. В датаграмме присутствует не более одного раза.</p>
<p>Тип 136 (длина 4)&nbsp;&nbsp;&nbsp;&nbsp; Stream Identifier&nbsp;&nbsp;&nbsp;&nbsp; (Идентификатор потока)</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp; +--------+--------+--------------------+</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp; |10001000|00000010|идентификатор потока|</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp; +--------+--------+--------------------+</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Эта опция дает средства для поддержания 16-битовой SATNET </p>
<p> &nbsp;&nbsp;&nbsp;&nbsp; идентифткации потока в сетях, которые парвоначально не </p>
<p> &nbsp;&nbsp;&nbsp;&nbsp; поддерживали потоковую концепцию.</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Опцтя должна копироваться при фрагментации. В датаграмме </p>
<p> &nbsp;&nbsp;&nbsp;&nbsp; появляется не более одного раза.</p>
<p>Тип 68&nbsp;&nbsp;&nbsp;&nbsp; Internet timestamp&nbsp;&nbsp;&nbsp;&nbsp; (Временной штамп Internet)</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp; +--------+--------+---------+-----+-----+</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp; |01000100| длина  |указатель|oflw | flg |</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp; +--------+--------+---------+-----+-----+</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp; |&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Internet адрес &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; |</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp; +---------------------------------------+</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp; |&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Timestamp&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; |</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp; +---------------------------------------+</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp; |&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; |</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Длина - это количество октетов в опции, которое учитывает </p>
<p> &nbsp;&nbsp;&nbsp;&nbsp; октеты типа, длины, указателя и overflow/flag (максимальная длина </p>
<p> &nbsp;&nbsp;&nbsp;&nbsp; 40 октетов).</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Указатель - это количество октетов от начала этой опции до </p>
<p> &nbsp;&nbsp;&nbsp;&nbsp; конца временных штампов, плюс единица (т.е. он указывает на октет, </p>
<p> &nbsp;&nbsp;&nbsp;&nbsp; с которого начинается свободное место для следующего временного </p>
<p> &nbsp;&nbsp;&nbsp;&nbsp; штампа). Наименьшее допустимое значение - 5. Поле временного </p>
<p> &nbsp;&nbsp;&nbsp;&nbsp; штампа считается заполненным, когда указатель превышает длину </p>
<p> &nbsp;&nbsp;&nbsp;&nbsp; опции.</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Overflow (oflw, переполнение  4 бита) - это количество IP </p>
<p> &nbsp;&nbsp;&nbsp;&nbsp; модулей, которые не могут произвести регистрацию временных штампов </p>
<p> &nbsp;&nbsp;&nbsp;&nbsp; по причине отсутствия свободного места.</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Flag (flg, флаги  4 бита) - это</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp; 0 - оставлять лишь временные штампы, размещенные в следующих друг </p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; за другом 32-битных словах</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp; 1 - каждому временному штампу предшествует Internet адрес </p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; регистрируемого объекта</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp; 3 - поля Internet адресов определены заранее. IP модуль лишь </p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; регистрирует свой временной штамп, если его собственный адрес </p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; совпадает со следующим указанным Inernet адресом.</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp; Timestamp - это выровненный по правой границе 32-битный временной </p>
<p> &nbsp;&nbsp;&nbsp;&nbsp; штамп в миллисекундах (относительно полуночи по Единому Времени). </p>
<p> &nbsp;&nbsp;&nbsp;&nbsp; Если время в миллисекундах неопределимо или не может быть </p>
<p> &nbsp;&nbsp;&nbsp;&nbsp; отсчитано относительно полуночи по Единому Времени, то может быть </p>
<p> &nbsp;&nbsp;&nbsp;&nbsp; внесено любое другое время в качестве временного штампа при </p>
<p> &nbsp;&nbsp;&nbsp;&nbsp; условии, что самый старший бит в поле временного штампа будет </p>
<p> &nbsp;&nbsp;&nbsp;&nbsp; установлен в единицу (что указавает на использование </p>
<p> &nbsp;&nbsp;&nbsp;&nbsp; нестандартного значения).</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Хост-отправитель должен создавать эту опцию так, чтобы поля для </p>
<p> &nbsp;&nbsp;&nbsp;&nbsp; временных штампов были достаточны для размещения всей ожидаемой </p>
<p> &nbsp;&nbsp;&nbsp;&nbsp; информации. Размер опции не изменяется при добавлении временных </p>
<p> &nbsp;&nbsp;&nbsp;&nbsp; штампов. Первоначально содержимое поля под временные штампы должно </p>
<p> &nbsp;&nbsp;&nbsp;&nbsp; быть заполнено нулями, либо Internet адреса должны чередоваться с </p>
<p> &nbsp;&nbsp;&nbsp;&nbsp; нулями.</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Если поле с временными штампами уже заполнено (указатель </p>
<p> &nbsp;&nbsp;&nbsp;&nbsp; превышает длину опции), то датаграмма передается без вставки </p>
<p> &nbsp;&nbsp;&nbsp;&nbsp; временного штампа, а счетчик переполнения увеличивается на </p>
<p> &nbsp;&nbsp;&nbsp;&nbsp; единицу.</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Если имеется место, но оно недостаточно для вставки полного </p>
<p> &nbsp;&nbsp;&nbsp;&nbsp; временного штампа, или же счетчик переполнения сам переполнен, то </p>
<p> &nbsp;&nbsp;&nbsp;&nbsp; исходная датаграмма рассматривается как ошибочная и уничтожается. </p>
<p> &nbsp;&nbsp;&nbsp;&nbsp; И в том, и в другом случае на хост-отправитель должно посылаться </p>
<p> &nbsp;&nbsp;&nbsp;&nbsp; сообщение о проблеме с ICMP параметром [3].</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Опция временного штампа не копируется при фрагментации, а </p>
<p> &nbsp;&nbsp;&nbsp;&nbsp; сохраняется в первом фрагменте. В датаграмме появляется не более </p>
<p> &nbsp;&nbsp;&nbsp;&nbsp; одного раза.</p>
<p>Padding (Выравнивание)</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp; Выравнивание Internet заголовка используется для того, чтобы </p>
<p> &nbsp;&nbsp;&nbsp;&nbsp; убедиться в том, Internet заголовок заканчивается на 32-битной </p>
<p> &nbsp;&nbsp;&nbsp;&nbsp; границе. Варавнивание осуществляется нулями.</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 3.2 Обсуждение</p>
<p> &nbsp; Реализация протокола должна быть ясной. Каждая реализация должна </p>
<p>предвидеть работу с другими реализациями, созданными другими людьми. </p>
<p>Хотя цель этой спецификации - уточнение данного протокола, тем не менее </p>
<p>существует различие интерпретаций. В общем случае реализация должна </p>
<p>сохранять консерватизм в манере отправления, а свобода существует лишь в </p>
<p>манере получения информации. А именно, реализация должна быть аккуратной </p>
<p>в посылке хорошо определенных датаграмм и должна принимать любую </p>
<p>датаграмму, которую она могла бы интерпретировать (т.е. нет среды для </p>
<p>технических ошибок).</p>
<p> &nbsp; Основные Internet службы ориентированы на датаграммы и обеспечивают </p>
<p>фрагментацию датаграмм на шлюзах, сборку на модуле Internet протокола на </p>
<p>хосте-получателе. Конечно, фрагментация и сборка датаграмм в сети или по </p>
<p>предварительному согласованию между шлюзами также разрешена, поскольку </p>
<p>это очевидно для Internet протоколов и протоколов более высокого уровня. </p>
<p>Этот очевидный тип фрагментации и сборки называется фрагментацией, </p>
<p>зависящей от сети (или Internet), и далее здесь не обсуждается.</p>
<p> &nbsp; Отправителей и получателей на уровне хост-компьютера позволяют </p>
<p>отличать Internet адреса, а также поле протокола. Предполагается, что </p>
<p>каждый протокол будет определять, есть ли нужда в мультиплексировании на </p>
<p>хосте.</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Адресация &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </p>
<p> &nbsp; Чтобы обеспечить гибкость в присвоении адресов комптьютерным сетям и </p>
<p>позволить применение большого количества малых и средних сетей, поле </p>
<p>адреса кодируется таким образом, чтобы определять малое количество сетей </p>
<p>с большим количеством хостов, среднее количество сетей со средним </p>
<p>количеством хостов и большое количество сетей с малым количеством </p>
<p>хостов. Дополнительно имеется escape код для расширенного режима </p>
<p>адресации.</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp; Форматы адресации</p>
<p> &nbsp; Старшие биты &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Формат &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Класс</p>
<p> &nbsp;&nbsp;&nbsp; 0&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 7 бит в сети, 24 бита для хостов &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; А</p>
<p> &nbsp;&nbsp;&nbsp; 10&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 14 бит в сети, 16 бит для хостов &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; В</p>
<p> &nbsp;&nbsp;&nbsp; 110&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 21 бит для сети, 8 бит для хостов &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; С</p>
<p> &nbsp;&nbsp;&nbsp; 111&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; переход в расширенный режим адресации</p>
<p> &nbsp; Нулевое значение в поле сети означает данную сеть. Этот режим </p>
<p>используется только в определенных ICMP сообщениях. Расширенный режим </p>
<p>адресации неопределен. Обе эти возможности зарезервированы для будущих </p>
<p>реализаций. Реальные значения, присваиваемые сетевым адресам, даны в </p>
<p>документе "Assigned Numbers" [9].</p>
<p> &nbsp; Локальный адрес, присвоенный локальной сети, должен позволять </p>
<p>одиночному физическому хосту работать как несколько отдельных Internet </p>
<p>хостов. А именно, должен существовать промежуток между адресами Internet </p>
<p>хостов и должны присутствовать интерфейсы между сетью и хостом, которые </p>
<p>позволили бы нескольким Internet адресам соответствовать одному </p>
<p>интерфейсу. Хост должен иметь возможность для поддержки нескольких </p>
<p>физических интерфейсов и для обработки датаграмм с любого из них, как </p>
<p>если бы они были адресованы к единственному хосту.</p>
<p> &nbsp; Карта соответствия между Internet адресами и адресами таких сетей, </p>
<p>как ARPANET, SATNET, PRNET и др. описаны в документе "Address Mapping" </p>
<p>[5].</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Фрагментация и сборка &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </p>
<p> &nbsp; Поле Internet идентификации (ID) используется вместе с </p>
<p>адресамиотправителя и получателя, полями протокола для идентификации </p>
<p>фрагментов датаграммы при сборке.</p>
<p> &nbsp; Бит флага More Fragments (MF) устанавливается, если датаграмма не </p>
<p>является последним фрагментом. Поле Fragment Offset идентифицирует </p>
<p>расположение фрагмента относительно начала в первоначальной </p>
<p>нефрагментированной датаграмме. Единица измерения - 8 октетов. Стратегия </p>
<p>фрагментации разработана так, чтобы нефрагментированная датаграмма имела </p>
<p>нули во всех полях с информацией о фрагментации (MF=0, Fragment </p>
<p>Offset=0). Если же Internet датаграмма фрагментируется, то выделение </p>
<p>информации производится кусками и по границе 8 октет.</p>
<p> &nbsp; Данный формат позволяет использовать 2**32=8192 фрагментов по 8 </p>
<p>октетов каждый, а в целом 65536 октетов. Заметим, что это совпадает со </p>
<p>значением поля общей длины для датаграммы (конечно, заголовок </p>
<p>учитывается в общей длине датаграммы, но не фрагментов).</p>
<p> &nbsp; Когда происходит фрагментация, то некоторые опции копируются, а </p>
<p>другие остаются лишь в первом фрагменте.</p>
<p> &nbsp; Каждый Internet модуль должен быть способен передать датаграмму из 68 </p>
<p>октетов без дальнейшей фрагментации. Это происходит потому, что Internet </p>
<p>заголовок может включать до 60 октетов, а минимальный фрагмент - 8 </p>
<p>октетов. Каждый Internet - получатель должен быть в состоянии принять </p>
<p>датаграмму из 576 октетов в качестве единого куска, либо в виде </p>
<p>фрагментов, подлежащих сборке.</p>
<p> &nbsp; Процесс фрагментации может повлиять на предыдущие поля</p>
<p> &nbsp; (1) - поле опций</p>
<p> &nbsp; (2) - флаг "more fragments"</p>
<p> &nbsp; (3) - смещение фрагмента</p>
<p> &nbsp; (4) - поле длины Internet заголовка</p>
<p> &nbsp; (5) - поле общей длины</p>
<p> &nbsp; (6) - контрольная сумма заголовка</p>
<p> &nbsp; Если бит флага запрета фрагментации (Don't Fragment - DF) установлен, </p>
<p>то Internet фрагментация данной датаграммы запрещена, даже если она </p>
<p>может быть разрушена. Данное средство может использоваться для </p>
<p>предотвращения фрагментации в тех случаях, когда хост-получатель не </p>
<p>имеет достаточных ресурсов для сборки Internet фрагментов.</p>
<p> &nbsp; Одним из примеров использования средства запрета фрагментации должна </p>
<p>служить линия, ведущая к малому хосту. Маленький хост может иметь </p>
<p>фмксированную загрузочную программу, которая принимает датаграмму, </p>
<p>помещает в памяти, а затем исполныет ее.</p>
<p> &nbsp; Процедуры фрагментации и сборки наиболее просто описываются </p>
<p>примерами. Следующие процедуры являются учебными реализациями.</p>
<p> &nbsp; В следующих псевдопрограммах принимается следующая нотация:</p>
<p>"=&lt;" означает "меньше или равно", "#" означает "не равно", "=" означает </p>
<p>"равно", "&lt;-" означает "устанавливается в". Кроме этого, "с x по y" </p>
<p>означает включительно по x, но не включая y. К примеру, выражение "с 4 </p>
<p>по 7" означало бы включение 4,5 и 6, но не включало бы 7.</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Пример процедуры фрагментации &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </p>
<p> &nbsp;&nbsp; Датаграмма наибольшего размера, которая еще может быть передана </p>
<p>через очередную локальную сеть, называется наибольшей передаваемой </p>
<p>единицей (maximum transmission unit - MTU).</p>
<p> &nbsp; Если общая длина датаграммы меньше или равна максимальной </p>
<p>передаваемой единице, то датаграмма передается следующим процедурам </p>
<p>обработки. В противном случае прежде она разбивается на два фрагмента, </p>
<p>причем первый из них будет иметь максимальный размер, соотвественно во </p>
<p>второй фрагмент будет помещен остаток исходной датаграммы. Первый </p>
<p>фрагмент отправляется на дальнейшую обработку, а второй повторно </p>
<p>подвергается только что рассмотренной процедуре, если и его размер </p>
<p>окажется слишком большим.</p>
<p> &nbsp; Обозначения:</p>
<p>FO&nbsp; - смещение фрагмента</p>
<p>IHL - длина Internet заголовка</p>
<p>DF&nbsp; - флаг запрета фрагментации</p>
<p>MF&nbsp; - флаг появления дополнительных фрагментов</p>
<p>TL&nbsp; - общая длина</p>
<p>OFO - старое смещение фрагмента</p>
<p>OIHL- старая длина Internet заголовка</p>
<p>OMF - старое значение флага появление дополнительных фрагментов</p>
<p>OTL - старое значение общей длины</p>
<p>NFB - количество блоков фрагментации</p>
<p>MTU - максимальная длина переноса</p>
<p>Процедура</p>
<p> &nbsp; IF TL =&lt; MTU THEN отправить датаграмму на следующие процедуры </p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; обработки</p>
<p> &nbsp; ELSE</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; IF DF =1 THEN разрушить датаграмму</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ELSE</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; создать первый фрагмент</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; (1) скопировать исходный Internet заголовок;</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; (2) OIHL &lt;- IHL; OTL &lt;- TL; OMF &lt;- MF;</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; (3) NFB &lt;- (MTU - IHL*4)/8;</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; (4) взять первые NFB*8 октетов данных;</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; (5) скорректировать заголовок:</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; MF &lt;- 1; TL &lt;- (IHL*4)+(NFB*8);</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; пересчитать контрольную сумму;</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; (6) направить данный фрагмент на последующие</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; процедуры обработки</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; создать второй фрагмент:</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; (7) выборочно скопировать Internet заголовок (некоторые</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; опции не копируются, см. определение опций)</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; (8) добавить оставшиеся данные</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; (9) скорректировать заголовок</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; IHL &lt;- (((OIHL*4)-(длина нескопированных опций))+3)/4;</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; TL &lt;- OTL - NFB*8 - (OIHL-IHL)*4;</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; FO &lt;- OFO + NFB;&nbsp; MF &lt;- OMF;</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; пересчитать контрольную сумму;</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; (10) Приготовить этот фрагмент к повторному тесту на </p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; необходимость фрагментации. Выполнить.</p>
<p> &nbsp; В предыдущей процедуре каждый фрагмент (за исключением последнего) </p>
<p>получает максимально разрешенную длину. Альтернатива может заключаться в </p>
<p>создании датаграмм, не достигающих максимального размера. Для примера, </p>
<p>она может включать процедуру фрагментации, которая повторно делит </p>
<p>большие датаграммы пополам до тех пор, пока получающиеся фрагменты не </p>
<p>станут короче, чем максимальный допустимый размер передаваемой единицы.</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Пример процедуры сборки &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </p>
<p> &nbsp; Для каждой датаграммы идентификатор буфера определяется как </p>
<p>объединение полей адреса отправителя, адреса получателя, протокола и </p>
<p>идентификации. Если это целая датаграмма (поля fragment offset и more </p>
<p>fragments нулевые), то все ресурсы, связанные с этим </p>
<p>идентификатором буфера, освобождаются, а сама датаграмма направляется на </p>
<p>следующие процедуры обработки.</p>
<p> &nbsp; Если следующий фрагмент не связан с этим идентификатором буфера, то </p>
<p>выделяются ресурсы для сборки. Они включают буфер данных, буфер </p>
<p>заголовка, битовую таблицу фрагментации, поле общей длины данных, а </p>
<p>также таймер. Данные из фрагмента помещаются в буфер данных в </p>
<p>соответствии со значением полей fragment offset и длины, а также </p>
<p>устанавливаются биты в битовой таблице фрагментации согласно полученным </p>
<p>блокам фрагментов.</p>
<p> &nbsp; Если это первый фрагмент (поле fragment offset нулевое), то его </p>
<p>заголовок помещается в буфер заголовка. Если это последний фрагмент </p>
<p>(поле more fragments нулевое), то вычисляется общая длина данных. Если </p>
<p>этот фрагмент завершает датаграмму (проверяется по установке битов в </p>
<p>таблице фрагментации), то датаграмма направляется на следующий этап </p>
<p>обработки. В противном случае таймер устанавливается на максимальное из </p>
<p>двух: текущее значение таймера и время жизни для данного фрагмента. </p>
<p>Выполнение процедуры сборки приостанавливается.</p>
<p> &nbsp; Если таймер отсчитал положенное время, то все ресурсы сборки, </p>
<p>связанные с данным идентификатором буфера, освобождаются. Первоначальная </p>
<p>установка таймера является нижней границей для времени ожидания при </p>
<p>сборке. Это происходит потому, что всемя ожидания будет увеличено, если </p>
<p>время жизни приходящего фрагмента окажется больше, но не может быть </p>
<p>уменьшено. Установка таймера может достигать максимального времени жизни </p>
<p>(примерно 4.25 минуты). В настоящее время рекомендуется первоначально </p>
<p>устанавливать таймер на 15 секунд. Это значение можно изменить при </p>
<p>получении достаночного практического опыта. Заметим, что выбор значения </p>
<p>для этого параметра связи связан с емкостью буфера и скоростью получения </p>
<p>данных с коммуникационных сетей. Например, скорость получения данных </p>
<p>следует умножать на размер буфера (т.е. 10 кбайт/сек * 15 сек = </p>
<p>150 кбайт).</p>
<p>Обозначения</p>
<p>FO&nbsp;&nbsp;&nbsp; - смещение фрагмента</p>
<p>IHL&nbsp;&nbsp; - длина Internet заголовка</p>
<p>MF&nbsp;&nbsp;&nbsp; - флаг More Fragments</p>
<p>TTL&nbsp;&nbsp; - время жизни</p>
<p>NFB&nbsp;&nbsp; - количество фрагментов</p>
<p>TL&nbsp;&nbsp;&nbsp; - общая длина</p>
<p>TDL&nbsp;&nbsp; - общая длина данных</p>
<p>BUFID - идентификатор буфера</p>
<p>RCVBT - битовая таблица фрагментации</p>
<p>TLB&nbsp;&nbsp; - нижняя граница для значения таймера</p>
<p>Процедура</p>
<p>(1) BUFID &lt;- отправитель|получатель|протокол|идентификация;</p>
<p>(2) IF FO = 0 AND MF = 0 THEN</p>
<p>(3)&nbsp;&nbsp;&nbsp;&nbsp; IF буфер с идентификатором BUFID выделены THEN</p>
<p>(4)&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; завершить сборку для этого идентификатора BUFID;</p>
<p>(5)&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Приготовить датаграмму для дальнейшей обработки.</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Запустить обработку</p>
<p>(6)&nbsp;&nbsp;&nbsp;&nbsp; ELSE</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; IF буфер для идентификатора BUFID не выделен THEN</p>
<p>(7)&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; выделить ресурсы для сборки с идентификатором BUFID</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; TIMER &lt;- TLB; TDL &lt;- 0;</p>
<p>(8)&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; перенести данные из фрагмента в буфер данных с идентификатором</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; BUFID, данные с октета FO*8 по октет (TL-(IHL*4))+FO*8;</p>
<p>(9)&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; установить биты RCVBT с FO по FO+((TL-(IHL*4)+7)/8);</p>
<p>(10)&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; IF MF = 0 THEN TDL &lt;- TL-(IHL*4)+(FO*8)</p>
<p>(11)&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; IF FO = 0 THEN поместить заголовок в буфер заголовка</p>
<p>(12)&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; IF TDL # 0 AND все биты RCVBT с 0 по (TDL+7)/8 выставлены THEN</p>
<p>(14)&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; TL &lt;- TDL+(IHL*4)</p>
<p>(15)&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Приготовить датаграмму к дальнейшей обработке</p>
<p>(16)&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Освободить все ресурсы сборки для этого идентификатора </p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; BUFID. Запустить обработку.</p>
<p>(17)&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; TIMER &lt;- MAX(TIMER,TTL);</p>
<p>(18)&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; приостановить работу до получения следующего фрагмента или</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; сигнала от таймера</p>
<p>(19) Сигнал от таймера:</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Освободить все ресурсы, связанные с этим идентификатором BUFID. </p>
<p> &nbsp; В случае, если два или более фрагмента содержат одни и те же данные, </p>
<p>либо идентичны или частично перекрываются, то эта процедура будет </p>
<p>использовать последнюю полученную копию при создании буфера данных и </p>
<p>воссоздании датаграммы.</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Идентификация &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </p>
<p> &nbsp; Выбор способа идентификации исходит из необходимости уникальной </p>
<p>идентификации фрагментов конкретной датаграммы. Модуль протокола, </p>
<p>собирающий фрагменты, считает, что они относятся к одной и той же </p>
<p>датаграмме, если они имеют общего отправителя, получателя, протокол и </p>
<p>идентификатор. Таким образом, отправитель должен выбрать идентификатор </p>
<p>таким образом, чтобы он был уникален для данной пары отправителя - </p>
<p>получателя, для данного протокола и в течении того времени, пока данная </p>
<p>датаграмма (или любой ее фрагмент) может существовать в сети Internet.</p>
<p> &nbsp; Очевидно, что модуль протокола, отправляющий датаграммы, должен иметь </p>
<p>таблицу идентификаторов, где каждая запись соотносится с каждым отдельным </p>
<p>получателем, с которым осуществлялась связь, и указывает последнее </p>
<p>значение максимального времени жизни датаграммы в сети Internet.</p>
<p> &nbsp; Однако, поскольку поле идентификатора позволяет использовать 65536 </p>
<p>различных значений, некоторые хост-компьютеры могут использовать просто </p>
<p>уникальные идентификаторы независимо от адреса получателя.</p>
<p> &nbsp; Обычно идентификаторы выбирают протоколы более высокого уровня, </p>
<p>например модули TCP протокола могут повторно передавать идентичные TCP </p>
<p>сегменты. Вероятность правильного приема увеличивалась бы, если повторная </p>
<p>передача осуществлялась с тем же самым идентификатором, что и исходная </p>
<p>датаграмма, поскольку ее фрагменты могли бы использоваться для сборки </p>
<p>правильного TCP сегмента.</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Тип обслуживания &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </p>
<p> &nbsp; Тип обслуживания (TOS) используется для выбора качества Internet </p>
<p>сервиса. Тип обслуживания определяется абстрактными параметрами </p>
<p>приоритета, задержки, продолжительности и достоверности. Эти параметры </p>
<p>должны отображаться на реальные параметры сервиса для конкретных сетей, </p>
<p>через которые проходит данная датаграмма.</p>
<p>Приоритет. Независимая единица измерения для важности данной датаграммы.</p>
<p>Задержка. Указание задержки важно для датаграмм с этим знаком.</p>
<p>Пропускная способность. Для датаграмм с этим знаком важна высокая скорость </p>
<p> &nbsp; передачи данных.</p>
<p>Достоверность. Для датаграмм с таким типом обслуживания важен более </p>
<p> &nbsp; высокий уровень усилий, предпринимаемых для обеспечения достоверности.</p>
<p> &nbsp; Например, сеть ARPANET имеет бит приоритета, а также выбор между </p>
<p>"стандартными" сообщениями (тип 0) и "неконтролируемыми" (тип 3) (также в </p>
<p>качестве одного из сервисных параметров может использоваться выбор между </p>
<p>единичным пакетом и многопакетными сообщениями). Неконтролируемые </p>
<p>сообщения имеют тенденцию иметь меньшую достоверность, но и меньшую </p>
<p>задержку. Допустим, Internet датаграмма должна быть передана через сеть </p>
<p>ARPANET. Пусть тип Internet сервиса определен как</p>
<p> приоритет:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 5</p>
<p> задержка:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 0</p>
<p> пропускная способность: 1</p>
<p> достоверность:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 1</p>
<p> &nbsp; В рассматриваемом примере отображение описанных параметров на </p>
<p>параметры, допустимые в сети ARPANET, привело бы к установке бита </p>
<p>приоритета ARPANET (поскольку приоритет Internet находится в верхней </p>
<p>половине своего диапазона), выбору стандартного типа сообщений (поскольку </p>
<p>указаны требования высокой пропускной способности и достоверности, а </p>
<p>параметр задержки сброшен). Дополнительные детали реализации сервиса даны </p>
<p>в документе "Service Mappings" [8].</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Время жизни &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </p>
<p> &nbsp; Время жизни устанавливается отправителем в соответствии с максимальным </p>
<p>значением, которое данная датаграмма может иметь в системе Internet. Если </p>
<p>датаграмма пребывает в системе Internet дольше, чем указанное время жизни, </p>
<p>она подлежит уничтожению.</p>
<p> &nbsp; Значение в поле, где указано время жизни, должно уменьшаться в каждой </p>
<p>точке, где обрабатывается Internet заголовок, с тем, чтобы показать время, </p>
<p>потраченное на обработку датаграммы. Даже если нет возможности получать </p>
<p>информацию о том, сколько реально времени было потрачено, значение этого </p>
<p>поля должно быть уменьшено на единицу. Время изменяется в секундах (т.е. </p>
<p>указанная единица соответствует одной секунде). Таким образом, </p>
<p>максимальное время жизни составляет 255 секунд или 4.25 минуты. Поскольку </p>
<p>каждый модуль, обрабатывающий датаграмму, должен уменьшать значение поля </p>
<p>TTL по крайней мере на единицу, даже если он обрабатывает ее быстрее, чем </p>
<p>за секунду, то поле TTL следует рассматривать лишь как верхнюю границу для </p>
<p>времени существования датаграммы. Цель процедуры заключается в разрушении </p>
<p>датаграмм, не достигших получателя, а также в ограничении времени жизни </p>
<p>датаграммы в сети.</p>
<p> &nbsp; Некоторые протоколы более высокого уровня, управляющие соединениями, </p>
<p>основываются на предположении, что старые датаграммы-дубликаты не </p>
<p>достигают цели по истечении определенного времени. TTL - это способ, с </p>
<p>помощью которого такие протоколы могли бы убедиться, что их предположение </p>
<p>удовлетворяется.</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Опции &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </p>
<p> &nbsp; Опции могут присутствовать в любой датаграмме, но должны всегда быть </p>
<p>обработаны. А именно, наличие или отсутствие какой-либо опции дело </p>
<p>отправителя, но каждый Internet модуль должен быть в состоянии произвести </p>
<p>разбор каждой опции.</p>
<p> &nbsp; Опции могут оканчиваться не на 32-битной границе. В этом случае </p>
<p>Interntet заголовок может дополняться нулевыми октетами. Первый из них </p>
<p>должен интрепретироваться как заключительная опция, а остальные - как </p>
<p>октеты выравнивания Internet заголовка по границе.</p>
<p> &nbsp; Каждый Internet модуль должен быть в состоянии реагировать на каждую </p>
<p>опцию. Например, опция безопасности требует классификации, внесения </p>
<p>ограничений, или передачи по изолированному пути.</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Контрольная сумма &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </p>
<p> &nbsp; Пересчет контрольной суммы Internet заголовка осуществляется каждый раз </p>
<p>при его изменении. Например, это происходит при уменьшении времени жизни, </p>
<p>добавлении или изменении Internet опций или при фрагментации. Контрольная </p>
<p>сумма на уровне Internet имеет целью защиту полей Internet заголовка от </p>
<p>ошибок при пересылке.</p>
<p> &nbsp; Существуют некоторые приложения, которые могли бы допустить несколько </p>
<p>ошибочных битов в поле данных при условии отсутствия задержки. Однако, </p>
<p>если Internet протокол усиливает ошибочность данных, то такие приложения </p>
<p>не могут поддерживаться.</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Ошибки &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </p>
<p> &nbsp; Ошибки Internet заголовка могут быть оглашены посредством ICMP </p>
<p>сообщений [3].</p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 3.3 Интерфейсы &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </p>
<p> &nbsp; Функциональное описание взаимодействия между пользователем и Internet </p>
<p>протоколом будет, в лучшем случае, умозрительным в силу специфики </p>
<p>операционной системы. Следовательно, мы должны предупредить читатетлей, </p>
<p>что различные реализации Internet протокола будут иметь различный </p>
<p>интерфейс с пользователем. Тем не менее, все реализации должны давать </p>
<p>определенный минимальный набор услуг, с тем, чтобы гарантировать , что все </p>
<p>они придерживаются единой иерархи протоколов. Данная глава описывает </p>
<p>интерфейс с функцией, обызательный для всех реализаций.</p>
<p> &nbsp; Internet протокол взаимодействует, с одной стороны, с локальной </p>
<p>сетью, а с другой - с протоколом более высокого уровня или прикладной </p>
<p>программой. В дальнейшем протокол более высокого уровня или прикладную </p>
<p>программу (или даже программу межсетевого шлюза) мы будем называть </p>
<p>"пользователем", поскольку они используют Internet модуль для своих </p>
<p>целей. Поскольку Internet протокол - это протокол работы с датаграммами, </p>
<p>то в промежутке между этапами их передачи системе придаются минимальные </p>
<p>ресурсы памяти, она поддерживает определенные регистры состояния, а </p>
<p>следовательно, каждый вызов пользователем Internet протокола сообщает </p>
<p>системе всю информацию, необходимую для осуществления требуемого </p>
<p>сервиса. </p>

