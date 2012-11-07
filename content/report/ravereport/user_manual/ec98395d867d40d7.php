<h1>Пакеты и обмер страниц</h1>
<div class="date">01.01.2007</div>


<p>Пакеты страниц</p>
<p>Вероятно, наиболее общим методом связывания страниц, будет последовательная пакетная обработка страниц, что определяется списком независимых определений страниц. Первая страница в списке начинает выполнение и продолжает до конца, затем вызывается вторая и так до последней страницы. Главной вещью, о которой надо помнить, что определение каждой страницы независимо от других и выполнение продолжается до окончаний, прежде чем начнется выполнение следующей страницы. Помните, что это проще для административных задач, при выполнении группы страниц на текущей основе.</p>
<p>Определите последовательность страниц печати, через свойство PageList, в пределах выбранного узла уровня Report. Когда это свойство будет выбрано (нажатием на кнопке эллипса), будет вызван диалог, который позволит построить список из списка определений страниц, в указанном узле дерева отчета. Преимущество этого метода - в том, что PageList независим от индивидуальных определений страниц. Это означает, что PageList может запустить целую последовательность страниц (отчетов), но индивидуальные отчеты могут все еще выбираться индивидуально и запускаться без ввода пакетной связи. Помните, что страницы отчета не видимы другим отчетам так, что если требуется гибкость в вызове отдельных определений страниц, определите многократно используемые страницы, как глобальные страницы, вместо страниц отчета.</p>
<p>ПРЕДУПРЕЖДЕНИЕ</p>
<p>Другой метод, группировать страниц, это установить в первой странице свойство GotoPage к другой странице. Теперь, когда первая страница закончится, автоматически начнется вторая страница. Проблема с данной техникой, что как только будет запущена первая страница, она ВСЕГДА запустит вторую страницу, так как они связаны вместе на уровне определений страниц.</p>
<p>Вызов страниц</p>
<p>(Узел Page - свойство GotoMode - установка gmCallEach)</p>
<p>Другой тип связи отчетов, где должен быть обычный поток страниц. Легчайший пример этого будет отчет, где каждая запись ВСЕГДА производит три страницы вывода. Это может быть отчет в виде формы, где страница 1 содержит демографическую информацию о пациенте, страница 2 содержит медицинскую информацию, и страница 3 содержит страховую информацию. Так, проходя по базе данных, каждая запись о пациенте будет производить три страницы отчета. Смотри упражнение для пошаговых инструкций как вызывать страницы.</p>
<p>Цепочка страниц</p>
<p>(Узел Page - свойство GotoMode - установка gmGotoDone)</p>
<p>Обмен страниц подобен пакетному режиму. Пакетная техника была обсужденная раньше, с использованием свойства PageList, и было предупреждение об использование свойства GotoPage. Тем не менее, если Вы планируете последовательность, то используйте свойство GotoPage со страницами их каталога глобальных страниц, оно очень мощное. Упражнение в конце данной главы дает определение Multi-Page определений, включая счет, файловую копию, документы о поставке и сопроводительные документы.</p>
<p>Различный формат первой страницы</p>
<p>(узел Page - свойство GotoMode - установка gmGotoNotDone)</p>
<p>Другой тип связи это когда в отчете первая страница отличается от других страниц. Это может быть отчет, которые имеет титульный лист, может быть с логотипом компании на странице 1, но оставшиеся страницы имеют другой одинаковый формат. Что Вам нужно сделать для этого, Вы должны создать отдельное определение для первой страницы, которое указывает на страницу 2. затем создать определение второй страницы (все оставшиеся страниц), которые дальше никуда не указывают. Упражнение в конце главы проходит через подробные шаги по выполнению данного процесса.</p>
<p>Различный формат четных/нечетных страниц</p>
<p>(Узел Page - свойство GotoMode - установка gmGotoNotDone)</p>
<p>Другой тип связи это когда отчет имеет различные форматы для четных/нечетных страниц. Это могут быть отчеты, которые печатаются на обеих сторонах листа бумаги (дуплексная печать) и перфорированные отверстия на одной стороне, так что бы конечный отчет мог быть вложен в скоросшиватель. Это будет означать, что внутренние границы (скажем 1 дюйм) могут быль больше, чем внешние границы (скажем Ѕ дюйма). Чтобы создавать цикл где определение страницы 1 (нечетные страницы) указывало на страницу 2 и не вызывало ее, если отчет закончен на этой странице, И определение страницы 2 (четные страницы) указывало на страницу 1 и не вызывало ее, если отчет закончен на этой странице. Этот цикл должен продолжаться пока отчет полностью не отпечатается. Смотрите упражнение в конце данной главы для получения подробных шагов для выполнения данного этого процесса.</p>
<p>Отчеты Пакет - Цепочка</p>
<p>Как только разработка отчета закончена и работает, повседневные процедуры отрегулировались. В этой точке, не будет необычным обнаружение того, что некоторые отчеты часто приходится печатать в определенной последовательности. Это могло быть группой отчетов, которые создаются в конце каждого месяца, квартала, и тому подобное. Другой пример мог быть серией исполнительных итогов, которые требуются верхнему уровню управления. Конечно, возможно запустить каждый требуемый отчет индивидуально для этих повторных случаев. Затем, когда они будут полностью сделаны, сгруппировать их вместе и отдать в офис. Это часто означает, что есть контрольная таблица, которая подробно описывает, какие повторные отчеты требуются, когда и для кого.</p>
<p>Эта проблема производства повторной последовательности отчетов решена в Rave путем связывания отчетов один с другими. Rave имеет способность связывать определения страниц отчетов, в широкий ряд путей, устанавливая различные комбинации трех свойств: Page.GotoMode, Page.GotoPage и Report.PageList. Важно отметить, что установка свойства GotoMode определяет поведение свойства GotoPage. Свойство PageList на уровне узла Report разработано для предоставления пути установки нескольких различных цепочек в заданной последовательности свойством GotoPage.</p>
<p>Хотя мы дадим примеры, как получить различные последовательности «пакет/цепочка», не возможно включить все возможные варианты. Секрет в том, что каждый должен понять и быть гибким в смешивании различных частей Rave. Конкретно, обратить особое внимание на каталог глобальных страниц и свойства GotoMode, GotoPage, Mirror и PageList. Различные комбинации этих свойств обеспечивают разнообразие параметров вывода. Есть много мощи в этом, поэтому наилучший совет начните с простых отчетов. Затем добавьте некоторые их этих мощных добавлений, и они принесут вам понимание.</p>
<p>Упражнение 27: вызов страниц</p>
<p>Путь выполнения этого следующий:</p>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#8226;</td><td>выполните все обычные определения для страницы 1;</td></tr></table></div>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#8226;</td><td>выполните все обычные определения для страницы 2;</td></tr></table></div>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#8226;</td><td>выполните все обычные определения для страницы 3;</td></tr></table></div>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#8226;</td><td>установите свойство GotoPage первой страницы указывать на вторую страницу;</td></tr></table></div>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#8226;</td><td>установите свойство GotoMode первой страницы в gmCallEach;</td></tr></table></div>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#8226;</td><td>установите свойство GotoPage второй страницы указывать на третью страницу;</td></tr></table></div>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#8226;</td><td>установите свойство GotoMode второй страницы в gmGotoDone;</td></tr></table></div>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#8226;</td><td>убедитесь, что свойство GotoPage последней страницы пустое.</td></tr></table></div>
<p>Установка свойство GotoPage первой страницы в gmCallEach активирует свойство после печати первой страницы. Так, по окончанию первой физической страницы, начнется выполнение второй страницы. Поскольку вторая страница имеет режим gmGotoDone, то переход будет, когда закончится печать второй страницы. Страница три отпечатается, и управление перейдет к первой странице, поскольку ее свойство GotoPage пусто. Таким способом Вы можете объединить любое количество страниц совместно. Ключ в том, что установка gmCallEach сохранит вызывающую страницу, чтобы всякий раз, встретится пустое свойство GotoPage, печать продолжилась на вызывающей странице.</p>
<p>Упражнение 28: цепочка страниц</p>
<p>В данном примере, мы собираемся сделать Multi-Page определение, которое включит счет, файловую копию, транспортную накладную и упаковочный лист.</p>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#8226;</td><td>Создайте секцию на глобальной странице, которая будет зеркально отображена позже.</td></tr></table></div>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">Выполните все нормальные определения для страницы счета в данной секции;</td></tr></table></div>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#8226;</td><td>Создайте секцию на глобальной странице, которая будет зеркально отображена позже.</td></tr></table></div>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">Выполните все нормальные определения для страницы файловой копии в данной секции;</td></tr></table></div>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#8226;</td><td>Создайте секцию на глобальной странице, которая будет зеркально отображена позже.</td></tr></table></div>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">Выполните все нормальные определения для страницы транспортной накладной в данной секции;</td></tr></table></div>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#8226;</td><td>Создайте секцию на глобальной странице, которая будет зеркально отображена позже.</td></tr></table></div>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">Выполните все нормальные определения для страницы упаковочного листа в данной секции;</td></tr></table></div>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#8226;</td><td>Создайте новый отчет, который будет хранить определения для этих страниц;</td></tr></table></div>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#8226;</td><td>Создайте новую страницу определения, «Invoice».</td></tr></table></div>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">Бросьте секцию на эту страницу и установите свойства Left и Top отраженные на глобальную секцию «Invoice», бросьте текстовый компонент в низ страницы "INVOICE COPY";</td></tr></table></div>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#8226;</td><td>Создайте новую страницу определения, «FileCopy1».</td></tr></table></div>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">Бросьте секцию на эту страницу и установите свойства Left и Top отраженные на глобальную секцию «FileCopy», бросьте текстовый компонент в низ страницы «FILE COPY 1»;</td></tr></table></div>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#8226;</td><td>Создайте новую страницу определения, «FileCopy2».</td></tr></table></div>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">Бросьте секцию на эту страницу и установите свойства Left и Top отраженные на глобальную секцию «FileCopy», бросьте текстовый компонент в низ страницы «FILE COPY 2»;</td></tr></table></div>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#8226;</td><td>Повторите данные шаги для транспортной накладной и упаковочного листа;</td></tr></table></div>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#8226;</td><td>Теперь вернитесь в определение страницы «Invoice» (НЕ глобальное определение).</td></tr></table></div>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">Установите PageMode в gmGotoDone.</td></tr></table></div>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">Установите PageGoto указывающим на страницу определения «File Copy 1»;</td></tr></table></div>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#8226;</td><td>Повторите эти шаги для каждой копии, помните оставить пустым последнее свойство PageGoto.</td></tr></table></div>
<p>Зеркальное отражение глобальной страницы позволяет многократно использовать основной дизайн. Данный пример показывает, «FileCopy» будет отражено дважды, и определение метки на каждой странице будет различаться.</p>
<p>Упражнение 29: различная первая страница</p>
<p>Путь выполнения этого следующий:</p>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#8226;</td><td>выполните все обычные определения для страницы 1;</td></tr></table></div>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#8226;</td><td>создайте новое определение для второй страницы;</td></tr></table></div>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#8226;</td><td>установите свойство GotoPage первой страницы указывающим на вторую страницу;</td></tr></table></div>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#8226;</td><td>установите свойство GotoMode первой страницы в gmGotoNotDone;</td></tr></table></div>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#8226;</td><td>выполните все обычные определения для страницы 1;</td></tr></table></div>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#8226;</td><td>убедитесь, что свойство GotoPage второй страницы оставлено пустым.</td></tr></table></div>
<p>Установка свойства GotoMode в gmGotoNotDone активизирует свойство GotoPage после того, как первая физическая страница отпечатается,  но только когда определение текущей страницы не завершится (например, EOF - конец файла). Так, по окончанию физической страницы 1, начнется выполнение страницы 2. Поскольку определения страницы 2 имеет пустым свойство GotoPage, определения страницы два останутся в силе, пока все оставшиеся физические страницы не завершатся.</p>
<p>Упражнение 30: различные четные и нечетные страницы</p>
<p>Путь выполнения этого следующий:</p>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#8226;</td><td>сделайте секцию на первой странице, которая установите для границ нечетных страниц. Например, установите свойства Left = 1.0, Width = 7.0, Top = 0.5 и Height = 10.0;</td></tr></table></div>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#8226;</td><td>закончите все остальные обычные определения для страницы 1 в данной секции;</td></tr></table></div>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#8226;</td><td>создайте новую страницу для определений;</td></tr></table></div>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#8226;</td><td>бросьте секцию на страницу 2, и установите параметры для верхней и левой границ, четных страниц. Например, Left = 0.5 и Top = 0.5;</td></tr></table></div>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#8226;</td><td>установите свойство Mirror секции страницы 2 указывающим на секцию страницы 1;</td></tr></table></div>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#8226;</td><td>установите свойство GotoPage второй страницы указывающим на первую страницу;</td></tr></table></div>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#8226;</td><td>установите свойство GotoPage первой страницы указывающим на вторую страницу;</td></tr></table></div>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr><td width="24">&#8226;</td><td>установите свойство GotoMode обеих страниц в gmGotoNotDone.</td></tr></table></div>
<p>Установка свойство GotoPage первой страницы в gmCallEach активирует свойство после печати каждой физической страницы, но только пока определение текущей страницы не закончено (например, EOF - конец файла). Так, по окончанию физической страницы 1, начнется выполнение страницы 2, по окончанию физической страницы 2, начнется выполнение страницы 1. Данный цикл будет продолжаться, пока одна из страниц не закончится. Если в данной точке, управление должно быть передано другой странице, используйте свойство компонент отчета PageList для выбора следующей страницы.</p>
