<h1>Преобразование Delphi приложений в Delphi .NET</h1>
<div class="date">01.01.2007</div>

<p>20.1. Преобразование Delphi приложений в Delphi .Net</p>
Данная глава вводит в особенности переноса существующего кода в DCCIL / Delphi. Net. Она также показывает элементы, которые больше не применимы и как их обойти, чтобы они могли правильно работать в .Net framework.</p>
Данная статья так также дает руководство по оценке преобразования существующего приложения для работы в .Net framework с помощью DCCIL / Delphi.NET.</p>
20.1.1. Термины</p>
Данная статья сфокусирована на преобразовании и его последствиях для вашего Delphi кода. Поэтому, данная статья не является введением в .Net саму по себе, а только дает определение основных базовых терминов, относящихся к .NET.</p>
20.1.1.1. CIL</p>
Common Intermediate Language или просто Intermediate Language (промежуточный язык). Это язык компилятора, который преобразовывает исходный код, пригодный для использования в рантайм.</p>
IL выполняет роль, подобную P-коду или интерпретируемому языку Java. Но также он отличается от них и реализован совсем иначе.</p>
20.1.1.2. CLR</p>
CLR &#8211; это сокращение от Common Language Runtime. CLR &#8211; это основа NET framework и среда исполнения приложений, которые компилируются в IL. Вначале вам может показаться, что CLR очень похожа на интерпретатор P-кода, поскольку выполняет аналогичную роль, но это не интерпретатор простого P-кода, а много больше.</p>
20.1.1.3. CTS</p>
CTS CLR &#8211; это сокращение от Common Type System. CTS включает предопределенные, базовые .NET типы, которые доступны в любом .NET языке. Это означает, что integer больше не определяется каждым компилятором, а встроен в CTS и поэтому integer полностью одинаков во всех .NET языках.</p>
CTS не ограничен только integer, а включает много других типов. CTS разделяет типы на две базовые категории: значения и ссылочные типы.</p>
Типы значений - это типы, которые записываются в стеке. Вы должны быть знакомы с термином &#8211; простой или порядковый типы. Типы значений включают integers, bytes и другие примитивы, структуры и перечисления.</p>
Ссылочные типы &#8211; это типы, значения которых сохраняются в куче, и ссылки используются для доступа к ним. Ссылочные типы включают objects, interfaces и pointers.</p>
20.1.1.4. CLS</p>
CLS &#8211; это сокращение от Common Language Specification. CLS это просто спецификация, которая определяет, какие свойства языка могут и должны быть поддержаны для работы в .NET.</p>
20.1.1.5. Управляемый код (Managed Code)</p>
Управляемый код &#8211; это код который компилируется в IL и исполняется с помощью CLR. Основная цель любого .NET приложения &#8211; это быть 100% обслуживаемым кодом. (От корректора: Ну, блин сказал... J)</p>
20.1.1.6. Неуправляемый код (Unmanaged Code)</p>
Неуправляемый код &#8211; это откомпилированный в машинные инструкции, который получен с помощью Delphi for Windows.&nbsp; Неуправляемый код также включает код DLL, COM серверов и даже Win32 API. Основная цель любого .NET приложения &#8211; это не имееть такого кода.</p>
20.1.1.7. Сборка (Assembly)</p>
Сборка это коллекция .NET IL модулей. Это очень похоже на пакеты в Delphi и Delphi .NET трактует .NET сборки аналогично пакетам Delphi.</p>
20.1.2. Компиляторы и среды (IDE)</p>
Имеется несколько компиляторов и сред относящихся к Delphi и к .NET.</p>
20.1.2.1. Компилятор DCCIL (Diesel)</p>
DCCIL &#8211; это компилятор командной строки, который производит .NET вывод. DCCIL &#8211; это то, что было названо как "Delphi .NET preview compiler" и было включено в Delphi 7.</p>
DCC &#8211; это имя стандартного компилятора командной строки в Delphi и это сокращение от Delphi Command line Compiler.</p>
IL это ссылка на .NET Intermediate Language.</p>
Отсюда DCC + IL = DCCIL. Произносить каждый раз D-C-C-I-L слишком громоздко и поэтому было применено имя "Diesel".</p>
DCCIL имеет подобные DCC параметры и некоторые специфические для .NET расширения .</p>
20.1.2.1.1 Beta</p>
DCCIL в данный момент находится в состоянии беты и не рекомендуется для производства коммерческого кода. Поскольку в нем есть ошибки и даже незаконченные части. Но нельзя считать его бесполезным и Борланд постоянно выпускает новые версии.</p>
Поскольку это бета, то она накладывает ограничения на распространение программ, написанных с помощью DCCIL. Любой код, который создан с помощью DCCIL, также должен распространяться как бета.</p>
20.1.2.2. Версия Delphi 8</p>
Borland довольно молчалив по поводу Delphi 8. Тем не менее, опираясь на публичные высказывания мы может сделать кое какие вывод насчет Delphi 8.&nbsp; Видно, это будет не Delphi .NET, а расширение для платформы Windows. (От переводчика: это не подтвердилось.)</p>
20.1.2.3. Проект SideWinder</p>
Так же есть новости о проекте SideWinder от Борланд. Конечно это не конечное имя, а кодовое имя, которое Борланд назначил для разработки.</p>
SideWinder так же не Delphi .NET. SideWinder &#8211; это среда разработки C# для .NET, которая, будет конкурировать с Microsoft Visual Studio .NET.</p>
20.1.2.4. Проект Galileo</p>
Galileo &#8211; это кодовое имя Борланд для повторно используемой среды. Это первый продукт, который использует SideWinder и Galileo предназначен как базис для построения среды Delphi .NET, когда она будет выпущена.</p>
20.1.3. Разные среды (Frameworks)</p>
20.1.3.1. Среда .Net Framework</p>
Среда .NET framework &#8211; это библиотека классов, которая является ядром .NET. Данная библиотека классов включает классы для ввода/вывода, хранения данных, простые типы, комплексные типы, доступ к базам, пользовательский интерфейс и многое другое. То чем VCL является для Delphi программистов, тем же является для .NET программистов.</p>
АПИ Win32 ушло и было заменено классами в среде .NET, которое предоставляет лучшую и более абстрактную платформу с независимым интерфейсом. Так же предоставлен и прямой доступ до Win32 API, и до DLL. Тем не мене использования подобного доступа делает ваш код не обслуживаемым и нежелательным в .NET приложениях.</p>
20.1.3.2. Среда WinForms</p>
Среда WinForms &#8211; это сборка в .NET framework, которая включает классы для форм, кнопки, органы редактирования и другие элементы GUI для построения GUI приложений. Среда WinForms &#8211; это .Net управляемы интерфейс к Win32 API и &#8211; это то, что Visual Studio .NET использует для построения GUI приложений.</p>
20.1.3.3. Библиотека времени исполнения RTL</p>
Библиотека времени исполнения RTL содержит не визуальные низкий уровень классов в Delphi, такие как TList, TStrings и другие.</p>
Библиотека времени исполнения RTL &#8211; также доступна и в Delphi .NET. Многое из того, что есть в RTL имеет своих двойников в .NET framework, но предоставив RTL Borland сделал более простым перенос существующего кода, без необходимости переписывать большие куски кода и позволяет создавать кросс платформенный код.</p>
20.1.3.4. Библиотека&nbsp; CLX</p>
Данная часть, вносит некоторый конфуз. До Delphi 7 было следующее разделение:</p>
<div style="text-align: justify; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 8px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="24">&#183;</td><td>VCL - Visual Component Library. VCL - библиотека визуальных компонент, что относилось к визуальным компонентам, к не визуальным компонентам и к RTL.</td></tr></table></div><div style="text-align: justify; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 8px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="24">&#183;</td><td>CLX (Pronounced "Clicks") - Component Library for Cross Platform - CLX относилось к новой версии кросс платформенной&nbsp; части VCL, которая базировалась на QT и могла работать как в Linux, так и в Windows.</td></tr></table></div>Теперь же, после выхода Delphi 7, Borland реорганизовал и переопределил значение данного акронима. Это может привести в большое замешательство, по этому примите во внимание. Начиная с Delphi 7 новое назначение следующее:</p>
<div style="text-align: justify; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 8px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="24">&#183;</td><td>CLX - CLX относится ко всем компонентам включенным в Delphi, C++ Builder и в Kylix.</td></tr></table></div><div style="text-align: justify; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 8px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="24">&#183;</td><td>VCL - VCL относится к визуальным компонентам, которые работают напрямую с Win32 API.</td></tr></table></div><div style="text-align: justify; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 8px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="24">&#183;</td><td>Visual CLX - Visual CLX относится к кросс платформенным визуальным компонентам, которые базируются на QT, доступны и в Delphi и в Kylix.</td></tr></table></div><div style="text-align: justify; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 8px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="24">&#183;</td><td>VCL for .NET - VCL for .NET относится к новой VCL, которая запускается под .NET и предоставляет слой совместимости для старых приложений и плюс дополнительную функциональность.</td></tr></table></div>Если вы посмотрите на новые определения, я не уверен, что они согласованы. Я думаю в будущем они приведут к будущим недоразумениям. Я думаю NLX (Nelix?), или NCL (Nickel?), или что ни будь еще более more совместимое будет лучшим выбором для VCL .Net. Как видим, Visual CLX &#8211; это подмножество от CLX, не VCL for .NET &#8211; это родной брат VCL, как и Visual CLX.</p>
Это должно выглядеть так:</p>
<div style="text-align: justify; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 8px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="24">&#183;</td><td>VCL --&gt; CLX</td></tr></table></div><div style="text-align: justify; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 8px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="24">&#183;</td><td>CLX --&gt; Visual CLX</td></tr></table></div><div style="text-align: justify; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 8px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="24">&#183;</td><td>Visual Parts of VCL --&gt; VCL</td></tr></table></div>Хорошо, пусть это все будут мечты.</p>
20.1.3.5. Среда VCL for .Net</p>
Среда VCL for .NET относится к новому VCL, который работает под .NET и предоставляет уровень совместимости для старых приложений и добавляет дополнительную функциональность.</p>
Среда VCL for .NET позволяет сделать более быстрый перенос существующих приложений, аналогично Win32 VCL и CLX. Это позволяет продолжать разработку кросс платформенных приложений. Это важное свойство, которое позволяет продолжать поддержку Windows приложений без .NET framework и также Linux.</p>
20.1.3.6. Что выбрать WinForms или VCL for .Net?</p>
Это область для сомнений у пользователей &#8211; должен я использовать WinForms или VCL for .NET для разработки GUI?</p>
Следующая таблица сравнений позволит вам сделать правильный выбор. Должны быть установлены жесткие правила, но каждое приложение должно обслуживаться независимо.</p>
<table cellspacing="0" cellpadding="4" border="0" style="border: none border-spacing:0px; border-collapse: collapse;">
<tr >
<td >VCL for .Net</p>
</td>
<td >WinForms</p>
</td>
</tr>
<tr >
<td >Большой размер дистрибутива, поскольку должен включать дополнительные сборки.</p>
</td>
<td >Малый размер дистрибутива, поскольку все сборки входят в состав .NET framework.</p>
</td>
</tr>
<tr >
<td >Только для платформы Win32.</p>
</td>
<td >Возможны подмножества для compact .NET framework for pocket PC's. можно переносить на другие реализации .NET.</p>
</td>
</tr>
<tr >
<td >Высокая степень совместимости со старым кодом.</p>
</td>
<td >Требуются значительные изменения в существующем коде.</p>
</td>
</tr>
<tr >
<td >Кросс платформенность с VCL for Win32 и с Visual </p>
</td>
<td >Только для .Net framework.
</td>
</tr>
</table>
<table cellspacing="0" cellpadding="4" border="0" style="border: none border-spacing:0px; border-collapse: collapse;">
<tr >
<td >CLX for Linux (и Windows).</p>
</td>
<td >&nbsp;</p>
</td>
</tr>
<tr >
<td >Более эффективно в некоторых областях.</p>
</td>
<td >Не поддерживает всю оптимизацию, которая есть в VCL.</p>
</td>
</tr>
<tr >
<td >Дополнительные свойства и классы. Это включает дополнительные визуальные органы, но теряются такие вещи как списки действий (action lists), базы данных и многое другое.</p>
</td>
<td >&nbsp;</p>
</td>
</tr>
<tr >
<td >Не доступен полный исходный код.</p>
</td>
<td >Не доступен исходный код
</td>
</tr>
</table>
Другая возможность &#8211; вы можете смешивать код. VCL for .NET и WinForms не исключают друг друга и могут сосуществовать в одном приложении.</p>
20.1.4. Дополнения по переносу</p>
Некоторые из дополнений в Delphi .NET очень важны для переноса приложений, а некоторые нет. Данные вещи не являются жизненно важными и поэтому будут рассмотрены очень кратко.</p>
20.1.4.1. Маппирование типов в CTS</p>
Что бы работать с .NET классами все языки должны использовать CTS (Common Type System). Delphi .NET может делать это просто, в дополнение к типам Delphi. Это может иметь место в ситуации, когда обычный Delphi код использует один набор типов, а интерфейсы к .NET использует другой набор. В результате потребуется постоянное копирование данных туда и обратно, поэтому это не очень хорошая идея с .NET. Подобная ситуация аналогична ситуацией с COM.</p>
Ел избежание подобной проблемы, родные типы в Delphi .NET имеют их маппированые типы в CTS. Так что при объявлении Integer, это в реальности .NET Integer из CTS. Данная связь не ограничена только простыми типами, но также расширена и на объекты.</p>
Здесь приведен список некоторых подстановок:</p>
<table cellspacing="0" cellpadding="4" border="0" style="border: none border-spacing:0px; border-collapse: collapse;">
<tr >
<td >Delphi .Net</p>
</td>
<td >Common Type System</p>
</td>
</tr>
<tr >
<td >String</p>
</td>
<td >System.String</p>
</td>
</tr>
<tr >
<td >Variant</p>
</td>
<td >System.ValueType</p>
</td>
</tr>
<tr >
<td >Records</p>
</td>
<td >System.ValueType</p>
</td>
</tr>
<tr >
<td >Exception</p>
</td>
<td >System.Exception</p>
</td>
</tr>
<tr >
<td >TObject</p>
</td>
<td >System.Object</p>
</td>
</tr>
<tr >
<td >TComponent</p>
</td>
<td >System.ComponentModel.Component
</td>
</tr>
</table>
20.1.4.2. Пространство имен (Namespaces)</p>
Во избежание конфликтов и также как часть CLS (Common Language Specification), Delphi теперь поддерживает пространство имен. Каждый модуль теперь существует внутри пространства имен.</p>
Когда вы видите объявление подобное следующему:</p>
<div style="text-align: justify; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 8px 0px;"><pre>uses
  Borland.Delphi.SysUtils;
var
  GStatus: System.Label;
</pre>
&nbsp;</p>
Важно заметить, что VCL for .NET находится в пространстве имен и влияет на директиву uses.</p>
20.1.4.3. Вложенные типы (Nested Types)</p>
Вложенные типы позволяют объявление типов внутри другого объявления типа.</p>
20.1.4.4. Пользовательские атрибуты (Custom Attributes)</p>
.Net не имеет реализации подобной RTTI в Delphi. Вместо этого она поддерживает нечто подобное, названое отражение (reflection). Отражение выполняет роль подобную RTTI, но функционирует немного различно. Reflection зависит от атрибутов, исполняя некоторые из его функций. Для поддержки этого Delphi .NET имеет расширение в виде атрибутов.</p>
20.1.4.5. Другие дополнения к языку</p>
Delphi.NET also supports many new smaller additions to the language such as static class data, record inheritance, class properties, and more. Most of the enhancements relate to features of classes at the language level.</p>
While useful and required by the CLS, they are not essential in porting applications.</p>
20.1.5. Ограничения </p>
Разработка в Delphi .NET требует использования некоторых ограничений. Эти ограничения требуют, что бы код Delphi, подчинялся требованиям и ограничениям .NET.</p>
20.1.5.1. Не безопасные элементы</p>
В Delphi 7 появилось новое свойство, названое "Unsafe". При компилировании вашего кода в Delphi 7, вы получите предупреждение об не безопасных элементах. Не безопасные элементы &#8211; это такие элементы, которые непозволительно использовать в .NET рантайм.</p>
Данные предупреждения включены по умолчанию и серьезно замедляют работу компилятора. Поэтому если вы не компилируете код для .NET, то вы можете их отключить. Они производят, то что я назвал эффект "C++ effect". Они замедляют компиляцию и генерируют большое количество предупреждений, что приводит к высокому соотношению сигнал-шум ".</p>
Delphi 7 может быть использован для разработки кода, который вы желаете перенести в .NET, но DCCIL не генерирует предупреждений об небезопасных элементах. Поэтому первый шаг &#8211; это откомпилировать код в Delphi 7 и затем удалить предупреждения об небезопасных элементах.</p>
Delphi разделяет предупреждения на три группы &#8211; небезопасные типы, небезопасный код и небезопасное приведение.</p>
20.1.5.1.1 Небезопасные типы</p>
Небезопасные типы включают следующее:</p>
<div style="text-align: justify; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 8px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="24">&#183;</td><td>Символьные указатели: PChar, PWideChar, and PAnsiChar</td></tr></table></div><div style="text-align: justify; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 8px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="24">&#183;</td><td>Не типизированные указатели</td></tr></table></div><div style="text-align: justify; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 8px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="24">&#183;</td><td>Не типизированные var и out параметры</td></tr></table></div><div style="text-align: justify; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 8px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="24">&#183;</td><td>File of &lt;type&gt;</td></tr></table></div><div style="text-align: justify; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 8px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="24">&#183;</td><td>Real48</td></tr></table></div><div style="text-align: justify; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 8px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="24">&#183;</td><td>Записи с вариантными частями (Не путайте с variants)</td></tr></table></div>20.1.5.1.2 Небезопасный код</p>
Небезопасный код включает следующее:</p>
<div style="text-align: justify; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 8px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="24">&#183;</td><td>Абсолютные переменные (Absolute)</td></tr></table></div><div style="text-align: justify; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 8px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="24">&#183;</td><td>Функции Addr(), Ptr(), Hi(), Lo(), Swap()</td></tr></table></div><div style="text-align: justify; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 8px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="24">&#183;</td><td>Процедуры BlockRead(), and BlockWrite()</td></tr></table></div><div style="text-align: justify; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 8px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="24">&#183;</td><td>Процедура Fail()</td></tr></table></div><div style="text-align: justify; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 8px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="24">&#183;</td><td>Процедуры GetMem(), FreeMem(), ReallocMem()</td></tr></table></div><div style="text-align: justify; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 8px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="24">&#183;</td><td>Ассемблерный код</td></tr></table></div><div style="text-align: justify; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 8px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="24">&#183;</td><td>Операторы работы с указателями</td></tr></table></div>20.1.5.1.3 Небезопасные приведения (Casts)</p>
Небезопасное приведение включает следующее:</p>
<div style="text-align: justify; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 8px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="24">&#183;</td><td>Приведение к экземпляру класса, если он не является наследником.</td></tr></table></div><div style="text-align: justify; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 8px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="24">&#183;</td><td>Любые приведения записей, тип record </td></tr></table></div>20.1.5.2. Откидываемая функциональность (Deprecated Functionality)</p>
Некоторые элементы были отброшены, так как они не совместимы с .NET и поэтому бесполезны. Многие из этих элементов вы уже знаете из ранних глав.</p>
<div style="text-align: justify; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 8px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="24">&#183;</td><td>Тип Real48. используйте BCD или другие математические функции.</td></tr></table></div><div style="text-align: justify; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 8px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="24">&#183;</td><td>Функции GetMem(), FreeMem() и ReallocMem(). Используйте динамические массивы или net управление классами.</td></tr></table></div><div style="text-align: justify; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 8px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="24">&#183;</td><td>Процедуры BlockRead(), BlockWrite(). Используйте классы из .NET framework.</td></tr></table></div><div style="text-align: justify; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 8px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="24">&#183;</td><td>Директива Absolute </td></tr></table></div><div style="text-align: justify; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 8px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="24">&#183;</td><td>Функции Addr и @. Используйте классы вместо блоков памяти.</td></tr></table></div><div style="text-align: justify; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 8px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="24">&#183;</td><td>Старые тип объектов Паскаль, ключевое слово object. Используйте только ключевое слово class.</td></tr></table></div><div style="text-align: justify; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 8px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="24">&#183;</td><td>TVarData и прямой доступ до потрохов variant. Семантика Variant поддержана, но только без прямого доступа до внутренностей.</td></tr></table></div><div style="text-align: justify; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 8px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="24">&#183;</td><td>File of &lt;type&gt; - размер типов варьируется от платформы к платформе и не может быть определен во время компилирования и поэтому не может быть использован.</td></tr></table></div><div style="text-align: justify; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 8px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="24">&#183;</td><td>Не типизированные var и out параметры. Используйте директиву const для параметра или класс родителя.</td></tr></table></div><div style="text-align: justify; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 8px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="24">&#183;</td><td>Указатель PChar. В действительности Delphi .NET поддерживает PChar как не обслуживаемый код.</td></tr></table></div><div style="text-align: justify; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 8px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="24">&#183;</td><td>Директивы automated и dispid. Данные директивы неприменимы в .NET.</td></tr></table></div><div style="text-align: justify; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 8px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="24">&#183;</td><td>Директива asm &#8211; ассемблер не поддержан в .NET, код не компилируется в машинный код.</td></tr></table></div><div style="text-align: justify; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 8px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="24">&#183;</td><td>TInterfacedObject, который включает AddRef, QueryInterface и Release.</td></tr></table></div><div style="text-align: justify; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 8px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="24">&#183;</td><td>Динамические агрегаты &#8211; используйте implements. примечание: Implements не реализовано в текущей версии DCCIL.</td></tr></table></div><div style="text-align: justify; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 8px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="24">&#183;</td><td>ExitProc</td></tr></table></div>20.1.6. Изменения</p>
Borland инвестировал множество ресурсов в сохранение совместимости как только это возможно. И Delphi.NET &#8211; это пока еще Delphi, но некоторые вещи не могли быть сохранены для обратной совместимости.</p>
20.1.6.1. Разрушение (Destruction)</p>
Разрушение в Delphi .NET немного отличается. Большинство кода не потребует подстройки, но важно понять в чем же различие.</p>
20.1.6.1.1. Явное разрушение. (Deterministic Destruction)</p>
В обычном приложении Delphi разрушение объектов делается явно. Объект разрушается только тогда, когда код явно вызовет free или destroy. Разрушение может произойти как часть разрушения собственника, но в конце все равно будет код по явному вызову free или destroy. Данное поведение называется как Решительное, явное разрушение.</p>
Явное разрушение позволяет больший контроль, но склонно к утечкам памяти. Оно также позволяет делать ошибки, когда на разрушенный объект есть несколько ссылок или ссылка делается на другую ссылку, а о разрушении неизвестно.</p>
Разрушение требует позаботиться об очистке объекта (finalization) явным кодом в деструкторе и освобождением памяти используемой объектом. Поэтому деструктор должен позаботиться об обеих функциях,</p>
Программисты Delphi часто трактуют эти обе роли как одну.</p>
20.1.6.1.2. Не явное разрушение</p>
.Net разделяет эти функции &#8211; финализации и освобождения памяти, поскольку памятью заведует .NET. .Net использует неявное разрушение. Если вы работали с интерфейсами, то семантика подсчета ссылок, используемая в интерфейсах аналогична.</p>
Вместо явного разрушения, когда объект сам разрушается, CLR подсчитывает ссылки на объект. Когда объект больше не используется, то он помечается для разрушения.</p>
20.1.6.2. Сборка мусора (Garbage Collection)</p>
.Net использует сборку мусора, что бы очистить память используемую объектом. Это название процесса, который определят, что объект больше используется&nbsp; и освобождает занятую им память.</p>
Сборка мусора .NET очень сложная и даже базовая информация заслуживает отдельной главы, если даже не статьи.</p>
Подобно явному и неявному разрушению, сборка мусора имеет малое влияние на перенос приложения. Поскольку для процедуры переноса, сборка мусора является ящиком фокусника, который заботится о разрушении объекта за вас.</p>
20.1.7. Шаги по переносу</p>
Перенос приложений в Delphi .NET для большинства приложений будет очень значимым и потребует определенной осторожности. Для большинства объектно-ориентированного кода, проще чем кажется. Данная статья не может уменьшить количество работы по переносу, но поможет вам сделать это легче. Она позволит уменьшить количество ошибок и предназначена для быстрой реализации переноса.</p>
20.1.7.1. Удаление предупреждений (Unsafe Warnings)</p>
To remove unsafe warnings, load the target project into Delphi 7. With the unsafe warnings turned on, perform a build all. Delphi will produce a series of unsafe warnings. Each warning needs to be eliminated. This may easily be the biggest step in porting your application.</p>
20.1.7.2. Модули и пространство имен</p>
Директивы Uses должны быть преобразованы к использованию пространства имен.</p>
Если код требует одновременного использования в Windows и в .NET framework данные модули должны использовать IFDEF как указано. Константа CLR определена в Delphi .NET.</p>
<div style="text-align: justify; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 0px 0px 8px 0px;"><pre>uses
{$IFDEF CLR}Borland.Win32.Windows{$ELSE}Windows{$ENDIF},
{$IFDEF CLR}Borland.Delphi.SysUtils{$ELSE}SysUtils{$ENDIF},
{$IFDEF CLR}Borland.Vcl.Forms{$ELSE}Forms{$ENDIF};
</pre>
&nbsp;</p>
Пространство имен будет увидено. Три главных из них &#8211; это Borland.Win32 (Windows), Borland.Delphi (RTL) and Borland.VCL (VCL for .NET).</p>
20.1.7.3. Преобразование DFM</p>
Delphi for .NET пока не поддерживает формат DFM. Это возможно будет в будущем, так что данный шаг требуется если вы желаете использовать бета версию DCCIL.</p>
Поскольку DFM не поддержаны, все формы должны быть сконструированы с помощью кода. Есть также программа разработанная для выполнения данной задачи, которая может быть использована с нормальным приложениями Delphi.</p>
20.1.7.4. Преобразование файла проекта</p>
Application.CreateForm более не поддержан, так что формы должны быть созданы вручную, как обычные компоненты. Для установки главной формы приложения, установите свойство Application.MainForm перед вызовом Application.Run.</p>
20.1.7.5. Разрешение с различиями в классах</p>
Во время компиляции могут проявиться различия между VCL for .NET и VCL, поскольку появились небольшие различия между VCL и Visual CLX. Каждое из этих различий должно быть разрешено с помощью IFDEF.</p>
20.1.7.6. Нужна удача</p>
Если вам повезло, то ваш проект преобразован и работает нормально.</p>
Перенос &#8211; это не только перекомпиляция и потребует некоторого времени. Перенос в .NET требует подобных усилий, которые нужны для переноса в из VCL приложений в Visual CLX. Хотя время и усилия значительны, но это все равно меньше, чем писать с нуля и позволяет делать кросс платформенную разработку, так как код будет повторно использоваться и там и там, конечно если он спланирован должным образом.</p>
