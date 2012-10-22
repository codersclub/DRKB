<h1>Windows XP манифест в Delphi</h1>
<div class="date">01.01.2007</div>


<p>Windows XP манифест в Delphi</p>
Delphi.Diagnostinc.Ru </p>
<p>Данная статья рассказывает о том как сделать чтобы ваши проекты выглядели как Windows XP программы. </p>
<p>Зачем?</p>
<p>В Windows XP есть менеджер тем (theme manager) который изменяет вид большинства стандартных объектов Windows. Misrosoft утверждает что старые версии библиотеки comctl32.dll содержат код для поддержки различных платформ семейства Windows. Microsoft разумно решила почистить содержимое comctl32.dll для улучшения работы тем в Windows XP. Теперь получается что существует две версии библиотеки: старая (версия 5.8) которая имеет обратную совместимость всех предыдущих версий Windows (в том числе и XP) и новую версию (версия 6) которая совместима только с XP (ну и следующими версиями Windows). </p>
<p>По умолчанию все программы разработанные под Windows XO используют версию 5.8, получая тот же вид что и предыдущие приложения Windows. Для того чтобы использовать компоненты из библиотеки 6 версии в вашем приложении вы должны подключить к вашему приложению Manifest который Windows будет читать для того чтобы отрисовка компонентов производилось через новую библиотеку. </p>
<p>Что такое манифест?</p>
<p>Что такое манифест, и какую роль он играет в выборе версии 6.0 библиотеки comctl32.dll для моего приложения? Манифест - XML документ который должен быть подлинкован в ресурсы вашего приложения. Обычно ресурсы используются для хранения таких вещей как картинки, иконки и курсоры мыши. (С тем как использовать ресурсы вы можете прочитать в моей статье. Прим. Переводчика) XML документ, когда подключается в ресурсную секцию позволяет решить Windows XP какую версию comctl32.dll использовать. </p>
<p>Как это сделать? </p>
<p>Чтобы подключить этот XML манифест в ваше приложение Вы для начала должны знать константы предоставленные Microsoft. Когда вы добавляете ресурс в ваше приложение, есть номер группы и порядковый номер, связанный с ресурсом. Номер группы обычно называется понятным именем. Если вы посмотрите проводник ресурсов (resource explorer), поставляемый с Delphi в виде демонстрационного проекта (распологается {$delphi\Demos}) вы увидите группы называемые "Strings" (Строки), "Bitmaps" (Картинки), "Icons" (Иконки) или "Cursos" (Курсоры мыши) - это просто представления номер группы. Номер группы для "Manifest" (манифеста) - 24, в соответствии с заголовками C распространяемыми Microsoft. Номер манифеста для определения версии библиотеки comctl32.dll - 1 (Также в соответствии с заголовками C распространяемыми Microsoft). Эта информация будет необходима когда мы будем создавать наш новый ресурс (.RES файл) для подключения к нашему приложению. Для создания необходимого .RES файла нам нужно создать файл .RC в котором будет содержаться наш XML манифест, принадлежащий к соответствующей группе и номеру ресурса. В zip-архиве включенном в этот документ вы увидите два файла: </p>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 7px 0px 7px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="24">&#183;</td><td>1. WindowsXP.RC </td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 7px 0px 7px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="24">&#183;</td><td>2. WindowsXP.Manifest </td></tr></table></div><p>Файл WindowsXP.RC содержит инструции для подключения WindowsXP.Manifest (XML-документа), а именно: </p>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 7px 0px 7px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="24">&#183;</td><td>1 24 "WindowsXP.Manifest" </td></tr></table></div><p>Сам манифест - XML документ содержащий информацию о вашем приложении которую вы добавляете как и информацию содержащую версию библиотеки comctl32.dll для использования. Его содержание должно быть немного заточено под ваше приложение, но будет выглядеть примерно так: </p>
<pre>
&lt;?xml version="1.0" encoding="UTF-8" standalone="yes"?&gt;
&lt;assembly 
  xmlns="urn:schemas-microsoft-com:asm.v1"
  manifestVersion="1.0"&gt;
&lt;assemblyIdentity
    name="CiaoSoftware.Ciao.Shell.Contacts"
    processorArchitecture="x86"
    version="5.1.0.0"
    type="win32"/&gt;
&lt;description&gt;Windows Shell&lt;/description&gt;
&lt;dependency&gt;
    &lt;dependentAssembly&gt;
        &lt;assemblyIdentity
            type="win32"
            name="Microsoft.Windows.Common-Controls"
            version="6.0.0.0"
            processorArchitecture="x86"
            publicKeyToken="6595b64144ccf1df"
            language="*"
        /&gt;
    &lt;/dependentAssembly&gt;
&lt;/dependency&gt;
&lt;/assembly&gt;
</pre>
<p>Теперь когда у нас есть эти два файла нам необходимо использовать компилятор ресурсов Delphi чтобы скомпилировать .RC файл. В результате чего у нас получится файл WindowsXP.RES который мы можем подключить в наше приложение. Для компиляции ресурса введите в командной строке: </p>
<p>C:\project1&gt; brcc32 windowsxp.rx</p>
<p>Конечно, я думаю что вы вставили в переменную окружения PATH директорию BIN Delphi. </p>
<p>После компиляции вы увидите Файл WindowsXP.RES в тойже директории. Последний шаг для того чтобы ваше приложение стало WindowsXP-совместимым, это подключение ресурсного файла в ваше приложение. Самый простой способ сделать это добавить нижеприведенную директиву в ваш файл проекта или главную форму: </p>
<p><span style="color: teal">{$R WindowsXP.res}</span></p>
<p>Скорее всего вам прийдется поместить эту строчку сразу за директивой {$R *.dfm} которая уже имеется в вашем приложении, сразу за приедложением implementation. Как только вы подключили WindowsXP.RES в ваше приложение откомпилируйте ваше приложение и запустите его. Менеджер тем Windows приведет ваше приложение к виду остальных приложений написанных для Windows XP. </p>
<p>Предупреждения</p>
<p>Microsoft предупреждает всех разработчиков что они убрали большое количество кода из библиотеки comctl32.dll, и что необходимо тщательно проверять все стороны работы компонентов перед тем как распространять новую версию. По моему опыту могу сказать что могут быть проблемы совместимости с Delphi. С другой стороны я нашел только одну проблему - с компонентом TListView. Если вы используете TListView в режиме показа (View Style) vsReport, у вас возникнут проблемы с использованием свойства TColumns. Во время запуска при попытку использования заголовков колонок с указанием вида показа у вас возникнет ошибка ядра (Kernel Error). </p>

<p>Исправление проблемы с TListView (спасибо Евгению Иванову)</p>
<p>Стал искать как исправить это упущение, так как и Delphi 6 с Update 1 не помогает справиться с этой проблемой. Решение заключается в следующем: </p>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 7px 0px 7px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="24">1.</td><td>Открыть "ComCtrls.pas" и найти "TCustomListView.UpdateColumn" </td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 7px 0px 7px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="24">1.</td><td>Найдем следующую строку. </td></tr></table></div><p> &nbsp;&nbsp;&nbsp; if FImageIndex &lt;&gt; -1 then </p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; fmt := fmt or LVCFMT_IMAGE or LVCFMT_COL_HAS_IMAGES;</p>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 7px 0px 7px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="24">3.</td><td>Заменяем её на: </td></tr></table></div><p> &nbsp;&nbsp;&nbsp; if FImageIndex &lt;&gt; -1 then </p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; fmt := fmt or LVCFMT_IMAGE or LVCFMT_COL_HAS_IMAGES </p>
<p> &nbsp;&nbsp;&nbsp; else </p>
<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; mask := mask and not (LVCF_IMAGE);</p>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 7px 0px 7px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="24">4.</td><td>Сохраняем Comctrls.pas. Теперь TListView не вызывает ошибку в режиме vsReport под Windows XP. </td></tr></table>
</div>Автор поправки Matteo Riso. </p>

<p>Исправление проблемы с TPageControl</p>
<p>Решение проблемы с установкой цвета фона clBtnFace для TTabSheet.<br>
<p>Как вы знаете TPageControl является контейнером TTabSheet: TPageControl нормально воспринимается Windows XP манифестом, но это остается правильным пока вы не добавите TTabSheet...</p>
<p>Решение заключается в следующем: </p>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 7px 0px 7px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="24">1.</td><td>Откройте модуль "ComCtrls.pas" и найдите строчку "TTabSheet.UpdateTabShowing" </td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 7px 0px 7px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="24">1.</td><td>Вы увидите следующий текст: </td></tr></table></div><p>procedure TTabSheet.UpdateTabShowing; </p>
<p>begin </p>
<p>  SetTabShowing((FPageControl &lt;&gt; nil) and FTabVisible); </p>
<p>end; </p>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 7px 0px 7px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="24">3.</td><td>Добавьте следующую строчку в эту процедуру: </td></tr></table></div><p>SetWindowLong(handle,GWL_EXSTYLE,WS_EX_TRANSPARENT);</p>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 7px 0px 7px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="24">4.</td><td>Если в вашем TPageControl создано более одного TTabSheet, возможно при запуске вашего приложения вы увидите все компоненты отрисованные на первом листе (TTabSheet). Не надо впадать в панику... Найдите метод "TPageControl.Loaded" и измените его чтобы он был похож на следующий код: </td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 7px 0px 7px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="24">5.</td><td></td></tr></table></div>
<pre>
procedure TPageControl.Loaded; 
var 
I: integer; 
begin 
  inherited Loaded; 
  UpdateTabHighlights; 
  for I:=self.PageCount-1 downto 0 do 
        self.ActivePage:=self.Pages[I]; 
end;
</pre>
<p>Добавленый код заставляет TPageControl пройтись по всем страницам перед показом. Это конечно немного некрасиво, но работает... Если у вас есть другие методы решения этой проблемы сообщите мне. </p>
Автор поправки Matteo Riso. </p>

<p>Исправление проблемы с TTrackBar</p>
<p>TTrackBar - извините, а какая текущая позиция?</p>
<p>Подсказка, показывающая текущее значение TTrackBar при перемещении ползунка удобна, то есть вам не будет необходимо добавлять TLabel для этого. </p>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 7px 0px 7px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="24">1.</td><td>Откройте "ComCtrls.pas" и найдите "TTrackBar.CreateParams". </td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 7px 0px 7px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="24">1.</td><td>Вы увидите следующий код: </td></tr></table></div>
<pre>
procedure TTrackBar.CreateParams(var Params: TCreateParams); 
const 
  OrientationStyle: array[TTrackbarOrientation] of DWORD = (TBS_HORZ, TBS_VERT); 
  TickStyles: array[TTickStyle] of DWORD = (TBS_NOTICKS, TBS_AUTOTICKS, 0); 
  ATickMarks: array[TTickMark] of DWORD = (TBS_BOTTOM, TBS_TOP, TBS_BOTH); 
begin 
[...] 
  with Params do 
  begin 
    Style := Style or OrientationStyle[FOrientation] or 
      TickStyles[FTickStyle] or ATickMarks[FTickMarks] or TBS_FIXEDLENGTH or 
      TBS_ENABLESELRANGE; 
[...] 
  end; 
end; 
</pre>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 7px 0px 7px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="24">3.</td><td>Добавьте условие "or TBS_TOOLTIPS" в линию "Style:=". В конечном итоге должно получиться: </td></tr></table></div>
<pre>
Style := Style or OrientationStyle[FOrientation] or 
      TickStyles[FTickStyle] or ATickMarks[FTickMarks] or TBS_FIXEDLENGTH or 
      TBS_ENABLESELRANGE or TBS_TOOLTIPS; 
</pre>
<div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 7px 0px 7px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="24">4.</td><td>Сохраните ComCtrls.pas и наслаждайтесь подсказкой. </td></tr></table></div>Автор поправки Matteo Riso. </p>
