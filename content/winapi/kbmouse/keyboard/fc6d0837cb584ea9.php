<h1>Перехватить нажатие клавиши на клавиатуре</h1>
<div class="date">01.01.2007</div>

Для того, чтобы перехватить нажатие какой-то клавиши на клавиатуре можно использовать зарегистрированную "горячую клавишу" (HotKey). Эта программа пикает при нажатии "1". </p>
<pre>
...
private
  procedure WMHotKey(var Msg: TWMHotKey); message WM_HOTKEY;
...
const
  MyHotKey = ord('1');
 
procedure TForm1.WMHotKey(var Msg: TWMHotKey);
begin
  MessageBeep(0);
end;
 
procedure TForm1.FormCreate(Sender: TObject);
begin
  RegisterHotKey(Form1.Handle, MyHotKey, 0, MyHotKey);
end;
 
procedure TForm1.FormDestroy(Sender: TObject);
begin
  UnRegisterHotKey(Form1.Handle, MyHotKey);
end;
</pre>
<p><a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>


