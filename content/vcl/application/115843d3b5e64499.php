<h1>Как выполнить какой-то процесс тогда, когда пользователь не работает с моим приложением?</h1>
<div class="date">01.01.2007</div>


<p>Создайте процедуру, которая будет вызываться при событии Application.OnIdle.</p>
<p>Обьявим процедуру:</p>
<pre>
{Private declarations}
procedure IdleEventHandler(Sender: TObject; var Done: Boolean);
 
В разделе implementation опишем поцедуру:
 
procedure TForm1.IdleEventHandler(Sender: TObject; var Done: Boolean);
begin
  {Do a small bit of work here}    
  Done := false;
end;
</pre>

<p>В методе Form'ы OnCreate укажем что наша процедура вызывается на событии:</p>
<p>Application.OnIdle.Application.OnIdle := IdleEventHandler;</p>
<p>Событие OnIdle возникает один раз - когда приложение переходит в режим "безделья" (idle).</p>
<p>Если в обработчике переменной Done присвоить False событие будет вызываться</p>
<p>вновь и вновь, до тех пор пока приложение "бездельничает" и</p>
<p>переменной Done не присвоенно значение True.</p>
<p>Источник: http://www.vlata.com/delphi/</p>
<div class="author">Автор: p0s0l</div>
