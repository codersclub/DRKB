<h1>Выполнение отчета</h1>
<div class="date">01.01.2007</div>


<p>Обзор</p>
<p>После создания отчета, отображение и создание отчета в электронном формате, выполним следующие шаги. Имеется несколько путей получить отчет на бумаге или в электронных форматах. Данная глава показывает различные пути для показа отчета и также простую печать.</p>
<p>Выполнение отчетов</p>
<p>Одно из общих возможностей использования Rave это выполнение отчета. Выполнение отчета позволяет пользователю увидеть результат разработки отчета. Выполнение подобно тому, что многие разработчики знают как компиляция и в действительности происходит некоторая внутренняя «компиляция».</p>
<p>Есть несколько различных путей, как может быть выполнен отчет. Это делается или через меню Project, используя функциональную клавишу F9, или выбирая иконку Execute Report&nbsp; в панели проекта.</p>
<p>Использование функциональной клавиши F9 является наиболее подходящим методом, так как это часто повторяемое и общее действие при разработке отчета.</p>
<p>При использовании любого пути для выполнения отчета, пользователю предоставляются различные параметры. Диалог Output Options показывает различные параметры доступные во время выполнения.</p>
<p>Позже в этой главе мы объясним каждый параметр в деталях.</p>
<p>Диалог предпочтений</p>
<p>Перед тем как проходить по каждому параметр, есть несколько предпочтений, которые должны быть объяснены, что бы понять выполнение отчетов. Перейдите в меню Edit и выберите пункт Preferences, после чего появится диалог предпочтений.</p>
<p>На закладке Printing в диалоге предпочтений есть несколько различных параметров , которые можно изменить и которые оказывают влияние на выполнение отчета. Некоторые из параметров могут быть установлены здесь, но также дублируются и в диалоге Output Options, который появляется перед выполнением. В данной главе каждый из параметров будет объяснен.</p>
<p>В области Output Options диалога Printing Preferences, параметр Show Setup Dialog устанавливает должен ли показываться диалог Output Options (как показано здесь) при выполнении отчета. Иногда выгоднее запретить диалог Output Options, особенно во время разработки или тестирования. Но это означает, что параметры, содержащиеся&nbsp; здесь, должны быть установлены перед скрытием данного диалога. Также, любые изменения должны быть сделаны или путем повторной активации диалога или указание их в диалоге предпочтений.</p>
<p>По умолчанию устройство вывода отчета задается установками в Print Destination диалога Printing Preferences и отражается в диалоге Output Options. Изменение значений в области Print Destination диалога Printing Preferences имеет прямой эффект на значения по умолчанию в диалоге Output Options. Есть два параметра, которые можно выбрать: просмотр и принтер. Выбор одного из них делается при помощи радио кнопок, делает этот параметр значением по умолчанию и когда диалог Output Options появляется, данное значение по умолчанию оказывается выбранным.</p>
<p>Параметр Preview Grid действует тем же образом как сетка Grid (линии которой видны в дизайнере страниц) во время разработки. Данные параметры позволяют отображать сетку на окне просмотра. Установки сетки позволяют изменять Print Preview Page, включая изменение цвета, стиля и шага сетки. Если оба значения шага сетки, горизонтальный и вертикальный, будут установлены в 0, то сетка будет отсутствовать. Но указание чисел в установках горизонтально и вертикального шага, размещает сетку на Print Preview Page. Цвет линий изменяет цвет сетки. Стиль линий задается через выпадающее меню.</p>
<p>Параметры просмотра, имеют эффект только на просмотр. Имеется шесть параметров, которые можно установить. При использовании просмотра, окно отображается по умолчанию в нормальном состоянии. Подобно другим окнам Windows, окно просмотра можно минимизировать или максимизировать. Для установки используйте выпадающее меню в настройках Initial Window State.</p>
<p>Параметр Zoom Factor показывает по умолчанию процент увеличения (zoom) при первом показе просмотра. Параметр Zoom Increment указывает процент изменения Zoom при каждом нажатии на иконку Zoom In/Zoom Out. Как и дизайнер страниц, окно просмотра может иметь горизонтальную линейку, вертикальную линей или обе линейки, путем указания в Ruler Type (используйте выпадающее меню для выбора). Единицы измерения могут быть заданы или в дюймах или в сантиметрах.</p>
<p>Параметр ShadowDepth задает уровень тени окна просмотра и только для эстетики.</p>
<p>Параметр Monochrome Preview Display,&nbsp; сделан для совместимости с некоторыми видео картами, на которых могут быть проблемы при показе отчета в цвете. Это не рекомендовано для использования, только при необходимости.</p>
<p>Просмотр отчета</p>
<p>Поскольку Preview первично используется для предварительного просмотра отчета, имеют много возможностей, гораздо больше, чем это интуитивно понятно по их именам.</p>
<p>Начнем выполнение отчета. Когда появится диалог Output Options, радио кнопку выбора можно отметить. Нажатие OK продолжит выполнение в режиме просмотра.</p>
<p>&nbsp;</p>
<p>Окно просмотра используется для просмотра вывода сгенерированного отчета. Вид вывода на экран отличается от вывода на принтере. Вывод не экран базируется на постраничном выводе. Наверху окна просмотра есть панель, которая позволяет&nbsp; навигацию по отчету и другие функции, которые будут объяснены в следующих&nbsp; абзацах.</p>
<p>Большинство функций разрешенных в окне просмотра могут быть выполнены или с помощью панели или через меню окна просмотра. Мы пройдемся по функциям меню и объясним их в оставшейся части данной главы.</p>
<p>Первая группа иконок (разделенная вертикальной линией в панели), может быть найдена в меню File. Они используются для открытия, сохранения, печати или выхода из просмотра отчета.</p>
<p>Несмотря на то, что окно просмотра показывает текущий отчет их дизайнера, оно также позволяет загрузить предыдущий сохраненный отчет (расширение NDR). Это можно выполнить выбором пункт Open из меню File. Появится диалог, запрашивающий требуемый файл отчета. Когда файл NDR, текущий отчет, который был открыт, отменяется. Это не означает, отчет не может быть повторно сгенерирован. Для получения предыдущего отчета, просто повторите его генерацию, и выбери просмотр. Единственный отчет, который можно повторно регенерировать, это отчет который был перед этим просмотрен. Другие отчеты могут быть повторно просмотрены, только если они были сохранены или путем открытия их проектов и повторного выполнения.</p>
<p>Пункт Save As используется для сохранения отчета из просмотра. Выберите пункт,&nbsp; и появится диалог сохранения файла. Используйте этот диалог для сохранения текущего отчета в различные форматы, включая PDF и HTML (эти два формата будут рассмотрены позже в данной главе). Другой формат, в который может быть сохранен отчет, это NDR тип отчета, который является снимком текущего отчета.</p>
<p>Поскольку отчеты могут печататься напрямую, выбрав Execute и затем Printer, окно просмотра также предоставляет эту функцию, поскольку часто необходимо проверять просмотр до проведения подлинной печати.</p>
<p>Отставшие функции напрямую влияют на просмотр отчета на окне просмотра. Вторая секция кнопок на панели, это пункты в меню Page, которые используются для навигации между страницами. Кнопки для управления данными функциями сделаны привычными для пользователей баз данных, поскольку они выполняют похожие функции. Первая кнопка используется для перемещения на первую страницу отчета. Вторая кнопка для перемещения на предыдущую страницу отчета. Третья для перемещения на следующую страницу и последняя на последнею страницу отчета. На панели есть индикатор, показывающий текущую страницу и общее количество страниц. Этот индикатор страниц, также используется для перемещения на конкретную страницу, введя номер в поле ввода. Или используя пункт Go to Page в меню Page. Например, введя 10 в данном поле, мы перейдем на 10 страницу отчета (при условии, что есть 10 или более страниц).</p>
<p>Масштабирование также доступно в просмотре. Иконка лупы, с символом плюса увеличивает масштаб изображения страницы, а с символом минуса уменьшает. Есть также поле для указания коэффициента масштабирования вручную. Просто введите число в данном поле, и просмотр будет масштабирован на указанный процент.</p>
<p>Есть также два предопределенных значения, для быстрого масштабирования. Первое Fit to Page Width &#8211; установить масштаб по ширине страницы. И второе Fit to Page, вписать всю страницу в размеры окна. Это может использоваться для просмотра страницы целиком на экране. Побочным эффектом этого является то, что страницу будет видно целиком, но содержимое будет трудно читать. Обычно это используется для общей оценки отчета.</p>
<p>Выход их просмотра может быть сделан, или нажатием на иконку с изображением двери, или&nbsp; нажатием на стандартную иконку закрытия окна "X", как и для всех остальных стандартных окон Windows.</p>


