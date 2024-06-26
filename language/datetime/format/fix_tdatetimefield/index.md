---
Title: Корректировка поведения маски TDateTimeField
Author: Виктор Светлов
Date: 01.01.2007
Source: DelphiWorld 6.0 <https://delphiworld.narod.ru/>
---


Корректировка поведения маски TDateTimeField
============================================

При работе с полями в формате "дата-время" объектов типа TDataSet мои
коллеги неоднократно сталкивались с проблемой поведения маски. Недавно у
меня тоже возникла задача работы с такими полями. Возможно, ни один из
нас просто не разобрался, как нужно делать правильно, но нужно было
действовать.

Проблема заключается в том, что при вводе с клавиатуры требуется
обязательно указывать все знаки, включая ненужные в конкретном случае
(временную часть). В противном случае генерируется ошибка:

    'Invalid input value. Use escape key to abandon changes'

После часа, потраченного на разбирательство с маской, возникло желание
написать собственный компонент. Спросив у коллег, которые уже ходили
этим путем, я решил посмотреть в исходниках - вдруг получится быстро
обойти этот вопрос.

Не буду брать на себя смелость комментировать, что и как делается в
модуле Mask.pas. Кто хочет, может разобраться самостоятельно - ничего
особо сложного там нет.

Для начала в свойстве EditMask замените символ `BlankChar` с '\_' на
'0'. В результате получится маска вроде

    !99/99/99 99:99:99;1;0

Чтобы при редактировании и просмотре значение выглядело одинаково,
укажите свойство DisplayFormat

    dd.mm.yy hh:nn:ss

Далее нужно добавить в проект файлы Consts.pas, Sysconsts.pas и
Mask.pas. После внесения изменений закройте Дельфи, и открыв снова,
перекомпилируйте проект. Затем указанные файлы можно исключить из
проекта. Пример приведен для Дельфи 5.

Изменения следующие:

    //Consts.pas:
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
        //      ((Value [Offset] = ' ') and (EditMask[MaskOffset] <> mMskAscii)) then
        if (FMaskBlank <> '0') and
          ((Value[Offset] = FMaskBlank) or
          ((Value[Offset] = ' ') and (EditMask[MaskOffset] <> mMskAscii))) then
          …

В завершении хочу поделиться полезной и простой функцией. Как правило,
при создании документа, мы вставляем текущие дату и время. При этом
секунды как правило не нужны.

    function GetDateTimeWOSec(DateTime: TDateTime): TDateTime;
    begin
      Result := StrToDateTime(FormatDateTime('dd.mm.yy hh:nn', DateTime));
    end;

После проведения описанных манипуляций с полем в формате дата-время
становится так же приятно работать, как с компонентом TRXDateEdit.



 
