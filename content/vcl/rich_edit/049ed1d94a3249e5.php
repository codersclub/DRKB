<h1>Как получить определенную часть текста из TRichEdit?</h1>
<div class="date">01.01.2007</div>


<p>Иногда бывает необходимо полудить только часть текста из RichEdit не выделяя его, то есть не используя свойство SelText. Ниже представлен код, который позволяет сделать это.</p>
<pre>
{Переопределяем неправильное объявление TTextRange в RichEdit.pas} 
  TTextRange = record 
                 chrg: TCharRange; 
                 lpstrText: PAnsiChar; 
               end; 
 
 
function REGetTextRange(RichEdit: TRichEdit; 
                        BeginPos, MaxLength: Integer): string; 
{RichEdit - RichEdit control 
BeginPos - абсолютное значение первого символа
MaxLength - максимально число получаемых символов}
var 
  TextRange: TTextRange; 
begin 
  if MaxLength&gt;0 then 
  begin 
     SetLength(Result, MaxLength); 
     with TextRange do 
     begin 
       chrg.cpMin := BeginPos; 
       chrg.cpMax := BeginPos+MaxLength; 
       lpstrText := PChar(Result); 
     end; 
     SetLength(Result, SendMessage(RichEdit.Handle, EM_GETTEXTRANGE, 0, 
               longint(@TextRange))); 
  end 
   else Result:=''; 
end; 
</pre>

<p>Следующую функцию можно использовать для получения слова, над которым находится курсор мышки:</p>
<pre>
function RECharIndexByPos(RichEdit: TRichEdit; X, Y: Integer): Integer; 
{ функция возвращает абсолютное положение символа для данных координат курсора}
 
var 
  P: TPoint; 
begin 
  P := Point(X, Y); 
  Result := SendMessage(RichEdit.Handle, EM_CHARFROMPOS, 0, longint(@P)); 
end; 
 
function REExtractWordFromPos(RichEdit: TRichEdit;  X,  Y:  Integer):= 
string; 
{ X, Y - координаты в rich edit }
{возвращает слово в текущих координатах курсора}
 
var 
  BegPos, EndPos: Integer; 
begin 
   BegPos := RECharIndexByPos(RichEdit, X,  Y); 
  if (BegPos &lt; 0)  or 
   (SendMessage(RichEdit.Handle,EM_FINDWORDBREAK,WB_CLASSIFY,BegPos) and 
                      (WBF_BREAKLINE or WBF_ISWHITE) &lt;&gt; 0 )      then 
   begin 
      result:=''; 
      exit; 
   end; 
 
   if SendMessage(RichEdit.Handle, EM_FINDWORDBREAK,WB_CLASSIFY,BegPos-1) and 
      (WBF_BREAKLINE or WBF_ISWHITE)  =  0  then 
         BegPos:=SendMessage(RichEdit.Handle, EM_FINDWORDBREAK, 
                             WB_MOVEWORDLEFT, BegPos); 
  EndPos:=SendMessage(RichEdit.Handle,EM_FINDWORDBREAK,WB_MOVEWORDRIGHT,BegPos); 
  Result:=TrimRight(REGetTextRange(RichEdit, BegPos, EndPos - BegPos)); 
end;
</pre>

<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>

