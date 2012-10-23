<h1>Как выделить кнопку в TDBNavigator программно?</h1>
<div class="date">01.01.2007</div>


<pre>
type TFake=class(TDBNavigator);
 

 
procedure TForm1.Button1Click(Sender: TObject);
begin
  TFake(DBNavigator1).buttons[nbNext].Perform(WM_RBUTTONDOWN,0,0);
  TFake(DBNavigator1).buttons[nbNext].Perform(WM_RBUTTONUP,0,0);
end;
</pre>

<div class="author">Автор: Vit</div>
<p>Взято с Vingrad.ru <a href="https://forum.vingrad.ru" target="_blank">https://forum.vingrad.ru</a></p>
