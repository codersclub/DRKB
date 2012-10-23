<h1>Наполовину активное окно</h1>
<div class="date">01.01.2007</div>


<p>Как сделать так, чтобы окно было неактивно? Вы скажите: "Ничего сложного. Нужно только свойство окна Enabled установить в false"... но, так как окно является владельцем компонентов, находящихся на нём, то и все компоненты станут неактивными! Но был найден способ избежать этого!</p>
<pre>
private
  { Private declarations }
  procedure WMNCHitTest (var M: TWMNCHitTest); message wm_NCHitTest;
 
implementation
{$R *.DFM}
 
procedure TForm1.WMNCHitTest (var M:TWMNCHitTest);
begin
  if M.Result = htClient then
    M.Result := htCaption;
end;
</pre>


<p>Взято с <a href="https://delphiworld.narod.ru" target="_blank">https://delphiworld.narod.ru</a></p>
