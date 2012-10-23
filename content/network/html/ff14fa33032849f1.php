<h1>HTMLEditor &ndash; Краткий обзор</h1>
<div class="date">01.01.2007</div>


<p>Вступление - загрузка информации. </p>
<p>Часто в своих проектах, там, где нужно дать возможность пользователю редактировать текст, выделять различными шрифтами (стилями, цветами...) отдельные слова и в других подобных случаях, мы используем, чаще всего, TRichEdit. Всем он нравится как редактор?, хорош и удобен он в работе? На эти вопросы каждый ответит по своему, но в принципе, худо-бедно, пользоваться им можно. Можно потому что не видно другой альтернативы. Вернее она есть, и на много удобнее и продвинутее чем Rich'формат - это Html'формат, но он не доступен для визуального редактирования - т.е. для него нет редактора, поддерживающего стили, картинки, таблицы()., вот и получается что оно как бы есть, но его как бы нет. А если бы был (здесь можно помечтать, что с помощью такого редактора можно было бы сделать)? А.если нечто подобное есть, а вы об этом не знаете (здесь можно состроить гримасу удивления и задаться вопросом "зачем такое делать и никому об этом не говорить?")? Короче, альтернатива Rich'формату есть это Html, теперь давайте попробуем найти для него редактор. Но чтобы что-то искать, надо, как минимум, знать что это что-то есть. Когда же я стал искать, то я еще не знал о существовании такого редактора, да вобщем-то и искал не его и обнаружение его - это побочный эффект любопытства. </p>
<p>Куда ты завел нас...? </p>
<p>Что и зачем я искал вам не интересно, а вот что и где я нашел мы сейчас узнаем. </p>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 13px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="27">1.</td><td>Запускаем один экземпляр Delphi (у меня 5-ая версия). </td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 13px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="27">2.</td><td>В меню-баре выбираем пункт "Component", затем "Import ActiveX Control". </td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 13px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="27">3.</td><td>В появившемся окне, в списке зарегестрированных ActiveX Control'ов находим строку "DHTML Edit Control..." и выделяем ее (я не обещаю что у всех она будет, но если вдруг не будет попробуйте нажать кнопку "Add" и найти файл "C:\Program Files\Common Files\Microsoft Shared\Triedit\DHTMLED.OCX").. </td></tr></table></div>
<p>Результат должен быть примерно следующий:</p>
<img src="/pic/clip0315.gif" />
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 13px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="27">1.</td><td>Нажимаем кнопку "Install". </td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 13px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="27">2.</td><td>В следующем окне выбираем вкладку "Into new package". </td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 13px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="27">3.</td><td>Выбираем путь куда будет установлен наш ActiveX package и имя для него.</td></tr></table></div>
<img src="/pic/clip0316.gif" />
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 13px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="27">1.</td><td>Далее жмем "Ok". </td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 13px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="27">2.</td><td>После долгого раздумья появится окно, в котором нажмите "Compile".</td></tr></table></div>
<img src="/pic/clip0317.gif" />
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 13px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="27">1.</td><td>После чего в выскочившем сообщении нажмите "Ok". </td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 13px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="27">2.</td><td>Закройте все с сохранением вашей новой библиотеки. </td></tr></table></div>
<p>А теперь в два приема создаем проект и тестируем то что получилось. </p>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 13px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="27">1.</td><td>Создаем новый проект </td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 13px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="27">2.</td><td>находим палитру компонент "ActiveX", где видим две новые иконки </td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 13px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="27">3.</td><td>выбираем ту что называется "DHTMLEdit" </td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 13px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="27">4.</td><td>бросаем ее на форму </td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 13px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="27">5.</td><td>устанавливаем Align := alClient </td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 13px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="27">6.</td><td>запускаем проект </td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 13px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="27">7.</td><td>выделяем текст на странице которую вы сейчас читаете (Ctrl+A) и копируем с нее текст (Ctrl+C) </td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 13px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="27">8.</td><td>переходим в наш проект </td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 13px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="27">9.</td><td>ставим в поле курсор (щелкните мышью по полю) </td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 13px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="27">10.</td><td>нажимаем "Ctrl+V" </td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 0px 13px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="27">11.</td><td>смотрим и удивляемся. </td></tr></table></div>
<p>Текст можно редактировать, выделять, подсвечивать (Ctrl+B, Ctrl+I, Ctrl+U), искать (Ctrl+F), и даже кажется печатать(Ctrl+P) (не уверен так как у меня нет принтера). </p>
<p>А что дальше? </p>
<p>А вот в этом-то вся шутка юмора и заключается... А я не знаю что дальше, точнее как програмно работать с ним - выделять, вставлять рисунки, рисовать таблицы и т.д. Судя по тому что все это он может отображать, он должен и уметь все это создавать, но с разбегу у меня не получилось разобраться. Поэтому, заинтересовавшийся народ, вот вам ребус - работа с html-едитором, взаимодействие его с программой и с пользователем - все это теперь ваша забота, а мы будем ждать появления на страницах "Королевства" от вас статей на этот счет, а я, пардон, отойду в сторону - у меня другие интересы и задачи, я лишь посчитал своим долгом познакомить вас со своей находкой. Единственное только знаю, что его можно использовать и как html-editor, и как html-viewer. </p>
<p>Заключение </p>
<p>Это полностью моя статья, ни на что не претендующая, ни с кого не требующая, ни от куда не списанная (даже упоминаний о DHTMLEdit'оре не где не слышал). Описанный контрол, технической поддержке со стороны автора статьи не подлежит, даже ответов на вопросы по нему не предусматривается. Все. Удачи. Всем пока.</p>
<div class="author">Автор: <a href="mailto:skitl@mail.ru" target="_blank">Алексей Румянцев</a></div>

<p>Взято с <a href="https://delphiworld.narod.ru" target="_blank">https://delphiworld.narod.ru</a></p>
