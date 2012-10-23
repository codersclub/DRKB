<h1>Позиция дочерних MDI-окон</h1>
<div class="date">01.01.2007</div>


<div class="author">Автор: Richard Cox </div>

<p>Проблема, с котороя я столкнулся, заключается в том, что нижняя часть дочерней формы загораживает панель состояния родительской формы...</p>

<p>У меня была аналогичная проблема -- она проявлялась при условии, когда свойство главной формы WindowState устанавливалось на wsMinimized.</p>

<p>Вот мое решение: добавьте этот небольшой метод к вашей главной форме:</p>

<pre>
interface
 
procedure CMShowingChanged(var Message: TMessage); message CM_SHOWINGCHANGED;
 
implementation
 
procedure TMainForm.CMShowingChanged(var Message: TMessage);
var
  theRect: TRect;
begin
  inherited;
  theRect := GetClientRect;
  AlignControls(nil, theRect);
end;
</pre>

<p>Это работает, поскольку вызов AlignControls (в TForm) делает две вещи:</p>

<p>выравнивает элементы управления (включая ваш проблемный StatusBar) и</p>
<p>вновь позиционирует окно клиента относительно главной формы (оно ссылается на ClientHandle) после того, как элементы управления будут выравнены... что, впрочем, мы и хотели.</p>
<p>Взято с <a href="https://delphiworld.narod.ru" target="_blank">https://delphiworld.narod.ru</a></p>
