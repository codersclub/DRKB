<h1>Управляющие коды принтера</h1>
<div class="date">01.01.2007</div>


<p>Как мне послать на принтер управляющие коды принтера(Printer Control Codes)без перевода их в непечатные символы? Наверняка без Windows API в Delphi не обойтись.Когда я передаю управляющие коды принтера, они печатаются как непечатные символы, а не воспринимаются принтером как управляющие коды.</p>

<p>Вам нужно использовать Escape функцию принтера Passthrough, чтобы переслать данные непосредственно в принтер.В случае использования функции WriteLn это, конечно, не работает.Вот некоторый код, чтобы уговорить вас начать:</p>

<pre>
unit Passthru;
 
interface
 
uses printers, WinProcs, WinTypes, SysUtils;
 
procedure PrintTest;
 
implementation
 
type
 
  TPassThroughData = record
    nLen: Integer;
    Data: array[0..255] of byte;
  end;
 
procedure DirectPrint(s: string);
var
 
  PTBlock: TPassThroughData;
begin
 
  PTBlock.nLen := Length(s);
  StrPCopy(@PTBlock.Data, s);
  Escape(printer.handle, PASSTHROUGH, 0, @PTBlock, nil);
end;
 
procedure PrintTest;
begin
 
  Printer.BeginDoc;
  DirectPrint(CHR(27) + '&amp;l1O' + 'Привет, Вася!');
  Printer.EndDoc;
end;
 
end.
</pre>

<p>Взято из Советов по Delphi от <a href="mailto:mailto:webmaster@webinspector.com" target="_blank">Валентина Озерова</a></p>
<p>Сборник Kuliba</p>

