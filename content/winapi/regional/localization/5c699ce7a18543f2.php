<h1>Как программно переключить раскладку клавиатуры</h1>
<div class="date">01.01.2007</div>


<pre>
//На русский
procedure TForm1.Button1Click(Sender: TObject);
var
  Layout: array[0.. KL_NAMELENGTH] of char;
begin
  LoadKeyboardLayout( StrCopy(Layout,'00000419'),KLF_ACTIVATE);
end;
</pre>
<pre>
//На английский
procedure TForm1.Button2Click(Sender: TObject);
var
  Layout: array[0.. KL_NAMELENGTH] of char;
begin
  LoadKeyboardLayout(StrCopy(Layout,'00000409'),KLF_ACTIVATE);
end;
</pre>

<p><a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>
<hr />
<p>Эта программа при нажатии на Button1 меняет язык на следующий, при нажатии на Button2 - на русский, а на Button3 - на английский. Каждую секунду программа выводит в заголовок окна число, определяющее текущий язык.</p>

<pre>
procedure TForm1.Button1Click(Sender: TObject);
begin
  ActivateKeyboardLayout(HKL_NEXT, 0);
end;
 
procedure TForm1.Button2Click(Sender: TObject);
begin
  ActivateKeyboardLayout(LoadKeyboardLayout('00000419', 0), 0);
end;
 
procedure TForm1.Button3Click(Sender: TObject);
begin
  ActivateKeyboardLayout(LoadKeyboardLayout('00000409', 0), 0);
end;
 
procedure TForm1.Timer1Timer(Sender: TObject);
var
  s: array [0..63] of char;
begin
  GetKeyboardLayoutName(s);
  Form1.Caption := s;
end; 
</pre>
<p><a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>

