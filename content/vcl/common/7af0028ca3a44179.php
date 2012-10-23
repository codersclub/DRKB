<h1>Перегрузка контролами (статья)</h1>
<div class="date">01.01.2007</div>


<p>Навороченные формы с огромным количеством визуальных компонентов, помноженные на количество этих форм, могут вызвать ряд серьезных проблем при разработке и использовании программы. </p>
<p>Приложение надолго подвисает при загрузке. Время уходит на инициализацию большого количества форм, стоящих в AutoCreate. </p>
<p>Наблюдаются многочисленные глюки при прорисовке, сообщения системы об ошибках и перерасходе ресурсов без видимых причин, вплоть до убиения приложения системой или краха системы. Характерно для Windows линии 9X, у которых максимальное количество графических и оконных ресурсов (GDI и USER) сильно ограничено. </p>
<p>Зачастую, чтобы не расставлять и настраивать множество однообразных контролов на форме вручную, программист пишет код для их программной инициализации и вставки, не учитывая при этом нюансы, о которых он не подозревал при визуальной разработке. В результате он может получить утечку памяти и прочих ресурсов, если форма создается/уничтожается динамически многократно в процессе работы. </p>
<p>Пользователь теряется в перегруженном интерфейсе программы, будучи не в состоянии использовать все его возможности и затрудняясь в выполнении простых задач. </p>
<p>ТИПОВЫЕ РЕШЕНИЯ.</p>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 13px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="27">1.</td><td>Уменьшить количество автоматически создаваемых форм. Создавать тяжелые формы в тот момент, когда они понадобятся, и уничтожать при закрытии. При этом нужно следить за своевременной очисткой и проверкой глобальных ссылок на формы. </td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 13px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="27">2.</td><td>У динамически создаваемых компонентов устанавливать владельца и родителя. Подробности - в статье "Жизнь и смерть в режиме run-time". </td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 13px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="27">3.</td><td>Большое количество форм не всегда оправдано. Если пользователь не получает дополнительных удобств от того, что может открыть много форм (часто он не может их увидеть одновременно или работает постоянно с одной), то это неверное архитектурное решение.</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 13px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="27"></td><td>Интерфейс MDI - хорошая концепция. Но всякое техническое решение имеет свою область применения. Это удобно, когда пользователю нужно работать с однотипными объектами в разных окнах и переходить от одного к другому, причем количество их заранее неизвестно, и допускается изменение размеров окна. Примеры - работа с документами (Word, Excel, etc.). </td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 13px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="27">4.</td><td>Как правило, многочисленные элементы управления не нужны пользователю одновременно (вспомните о правиле 7±2 - именно таково среднее количество объектов, за которыми человек может следить одновременно, не напрягаясь). Их можно разделить на группы и расположить на страницах компонента TPageControl. Таким способом можно скрыть видимую сложность очень большого интерфейса по вводу и редактированию данных.</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 13px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="27"></td><td>Если группы компонентов однотипны (меняются только данные), то решение еще более упрощается, с одновременным снятием нагрузки на ресурсы системы. Компонент TTabControl, который внешне выглядит также, как и TPageControl, содержит только одну группу контролов, а программист по событию смены закладки OnChange имеет возможность сменить данные. </td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 13px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="27">5.</td><td>Большое количество регулярно расположенных контролов TEdit, TLabel успешно заменяется на TStringGrid, специально для этого предназначенный. Кроме всего прочего, он имеет удобную прокрутку, размеры таблицы не будут ограничены размерами формы.</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 13px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="27"></td><td>В случае, если нужно много TComboBox, применяют следующую хитрость. Для визуализации используют TStringGrid, а для редактирования в текущую ячейку вставляют TComboBox, устанавливая ему размеры и координаты по ячейке и набивая его программно (если набор элементов меняется). Один и тот же экземпляр редактирующего контрола используется во всех ячейках, поскольку он не нужен одновременно везде. Эта же техника используется и в VCL для редактирования ячеек TStringGrid, TDBGrid.</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 13px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="27"></td><td>Есть масса компонентов типа TStringGrid сторонних разработчиков, которые расширяют возможности стандартного. </td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 13px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="27">6.</td><td>DB-aware визуальные компоненты - такие как TDBGrid - способны обрабатывать огромный объем данных, не требуя при этом пропорциональное количество ресурсов GDI/USER. В конце концов, если не хочется связываться с СУБД, можно загнать информацию в TClientDataSet и кормить из него DB-aware controls на форме. Одновременно получаешь все прелести сортировки и фильтрации данных.</td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 13px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="27"></td><td>В случае сложного набора контролов для каждой записи, при необходимости видеть несколько таких групп одновременно, хорошо подходит компонент TDBCtrlGrid. </td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 13px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="27">7.</td><td>Следует стремиться уменьшить количество компонентов - потомков TWinControl (например - TButton), заменяя их на потомки TGraphicControl (пример - TSpeedButton). Последние не используют объекты USER, поскольку не являются окнами в понятиях Windows. </td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 13px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="27">8.</td><td>Рекомендуется разрабатывать и эксплуатировать ресурсоемкие приложения в среде Windows NT и ее наследников (2000, XP).</td></tr></table></div>
<div class="author">Автор: <a href="https://www.delphikingdom.com/asp/users.asp?ID=730" target="_blank">Александр Малыгин</a></div>

<p>Взято с <a href="https://delphiworld.narod.ru" target="_blank">https://delphiworld.narod.ru</a></p>
