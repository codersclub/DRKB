<h1>Как переместить каретку TMemo в нужную строку?</h1>
<div class="date">01.01.2007</div>


<pre>
function SetCaretPosition(memo:TMemo; x,y:integer);

var i:integer;
begin
  i := SendMessage(memo.Handle, EM_LINEINDEX, y, 0) + x;
  SendMessage(memo1.Handle, EM_SETSEL, i, i);
end;
 
или
 
type TFake=class(TCustomMemo);
 
....
 
TFake(MyMemo).SetCaretPos()
</pre>

<p class="author">Автор: Vit</p>
<p>Взято с Vingrad.ru <a href="https://forum.vingrad.ru" target="_blank">https://forum.vingrad.ru</a></p>

