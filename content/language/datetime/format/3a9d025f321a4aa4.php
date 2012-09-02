<h1>Корректировка поведения маски TDateTimeField</h1>
<div class="date">01.01.2007</div>

<p class="author">Автор: Виктор Светлов</p>
<p>При работе с полями в формате "дата-время" объектов типа TDataSet мои коллеги неоднократно сталкивались с проблемой поведения маски. Недавно у меня тоже возникла задача работы с такими полями. Возможно, ни один из нас просто не разобрался, как нужно делать правильно, но нужно было действовать. </p>
<p>Проблема заключается в том, что при вводе с клавиатуры требуется обязательно указывать все знаки, включая ненужные в конкретном случае (временную часть). В противном случае генерируется ошибка: </p>
<p>'Invalid input value. &nbsp;Use escape key to abandon changes'</p>
<p>После часа, потраченного на разбирательство с маской, возникло желание написать собственный компонент. Спросив у коллег, которые уже ходили этим путем, я решил посмотреть в исходниках - вдруг получится быстро обойти этот вопрос. </p>
<p>Не буду брать на себя смелость комментировать, что и как делается в модуле Mask.pas. Кто хочет, может разобраться самостоятельно - ничего особо сложного там нет. </p>
<p>Для начала в свойстве EditMask замените символ BlankChar с '_' на '0'. В результате получится маска вроде </p>
<p>!99/99/99 99:99:99;1;0</p>
<p>Чтобы при редактировании и просмотре значение выглядело одинаково, укажите свойство DisplayFormat </p>
<p>dd.mm.yy hh:nn:ss</p>
<p>Далее нужно добавить в проект файлы Consts.pas, Sysconsts.pas и Mask.pas. После внесения изменений закройте Дельфи, и открыв снова, перекомпилируйте проект. Затем указанные файлы можно исключить из проекта. Пример приведен для Дельфи 5. </p>
<p>Изменения следующие:</p>
<pre>
Consts.pas 
//SMaskEditErr = 'Invalid input value.  Use escape key to abandon changes';
SMaskEditErr = 'Введено некорректное значение. Нажмите Esc для отмены';
SysConsts.pas 
//SInvalidDateTime = '''%s'' is not a valid date and time';
SInvalidDateTime = '''%s'' - некорректное значение даты и времени';
Mask.pas 
function TCustomMaskEdit.RemoveEditFormat(const Value: string): string;
…
  {шестая строка снизу}
{так было}
//    if Result[I] = FMaskBlank then
//      Result[I] := ' ';
{так стало}
if Result[I] = FMaskBlank then
  if FMaskBlank = '0' then
    Result[I] := FMaskBlank
  else
    Result[I] := ' ';
…
 
  function TCustomMaskEdit.Validate(const Value: string; var Pos: Integer):
    Boolean;
    …
      {одинадцатая строка снизу}
    {так было}
    //    if (Value [Offset] = FMaskBlank) or
    //      ((Value [Offset] = ' ') and (EditMask[MaskOffset] &lt;&gt; mMskAscii)) then
    if (FMaskBlank &lt;&gt; '0') and
      ((Value[Offset] = FMaskBlank) or
      ((Value[Offset] = ' ') and (EditMask[MaskOffset] &lt;&gt; mMskAscii))) then
      …
</pre>
<p>В завершении хочу поделиться полезной и простой функцией. Как правило, при создании документа, мы вставляем текущие дату и время. При этом секунды как правило не нужны. </p>
<pre>
function GetDateTimeWOSec(DateTime: TDateTime): TDateTime;
begin
  Result := StrToDateTime(FormatDateTime('dd.mm.yy hh:nn', DateTime));
end;
</pre>
<p>После проведения описанных манипуляций с полем в формате дата-время становиться так же приятно работать, как с компонентом TRXDateEdit. </p>
<p><a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>
&nbsp;</p>
